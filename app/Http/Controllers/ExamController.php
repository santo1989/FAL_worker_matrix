<?php

namespace App\Http\Controllers;

use App\Models\ExamCandidate;
use App\Models\ExamProcessEntry;
use App\Models\ExamCycleLog;
use App\Models\ExamApproval;
use App\Models\SewingProcessList;
use App\Models\WorkerEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $query = ExamCandidate::query();

        // Search by NID or Name (case-insensitive for SQL Server and other DBs)
        if ($search = $request->input('search')) {
            $s = mb_strtolower($search);
            $query->where(function ($q) use ($s) {
                $q->whereRaw('LOWER(nid) LIKE ?', ['%' . $s . '%'])
                    ->orWhereRaw('LOWER(name) LIKE ?', ['%' . $s . '%']);
            });
        }

        // Filter by passed status
        if (!is_null($request->input('exam_passed')) && $request->input('exam_passed') !== '') {
            $query->where('exam_passed', $request->input('exam_passed'));
        }

        // Filter by process type / name via exam_process_entries
        $process_type = $request->input('process_type');
        $process_name = $request->input('process_name');
        if ($process_type || $process_name) {
            $pe = DB::table('exam_process_entries');
            if ($process_type) {
                $pe->where('sewing_process_type', $process_type);
            }
            if ($process_name) {
                $pe->where('sewing_process_name', $process_name);
            }
            $candidateIds = $pe->pluck('exam_candidate_id')->unique()->toArray();
            if (!empty($candidateIds)) {
                $query->whereIn('id', $candidateIds);
            } else {
                // no matching candidates for the filter -> empty result
                $query->whereRaw('1 = 0');
            }
        }

        $candidates = $query->orderBy('id', 'desc')->paginate(20)->appends($request->query());

        return view('backend.exam.index', compact('candidates'));
    }

    public function create()
    {
        return view('backend.exam.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nid' => 'required|string',
            'name' => 'required|string',
        ]);

        $candidate = ExamCandidate::create([
            'nid' => $request->nid,
            'name' => $request->name,
            'examination_date' => $request->examination_date ?? now()->format('Y-m-d'),
        ]);

        return redirect()->route('exam.process_entry_form', $candidate->id);
    }

    public function process_entry_form(ExamCandidate $candidate)
    {
        $processes = SewingProcessList::all();
        return view('backend.exam.process_entry', compact('candidate', 'processes'));
    }

    public function process_entry(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|integer',
            'sewing_process_lists_id' => 'array'
        ]);

        $candidate = ExamCandidate::findOrFail($request->candidate_id);

        // Create or update process entries
        foreach ($request->sewing_process_lists_id ?? [] as $process_id) {
            $spl = SewingProcessList::find($process_id);
            if (!$spl) continue;

            ExamProcessEntry::updateOrCreate([
                'exam_candidate_id' => $candidate->id,
                'sewing_process_list_id' => $process_id,
            ], [
                'sewing_process_name' => $spl->process_name,
                'sewing_process_type' => $spl->process_type,
            ]);
        }

        return redirect()->route('exam.cyclesData_entry_form', $candidate->id);
    }

    public function process_type_search(Request $request)
    {
        $process_types = $request->input('process_type', []);

        if (empty($process_types)) {
            return redirect()->back()->withErrors(['process_type' => 'Please select at least one process type']);
        }

        $sewingProcessList = SewingProcessList::whereIn('process_type', $process_types)->get();

        $groupedProcesses = $sewingProcessList->groupBy(['process_type', 'machine_type']);

        $candidate = ExamCandidate::find($request->candidate_id);
        return view('backend.exam.process_entry', compact('candidate', 'groupedProcesses'));
    }

    public function cyclesData_entry_form(ExamCandidate $candidate)
    {
        $entries = ExamProcessEntry::where('exam_candidate_id', $candidate->id)->get();
        return view('backend.exam.cyclesData_entry', compact('candidate', 'entries'));
    }

    public function cyclesData_store(Request $request)
    {
        $modalId = $request->input('modal_id');
        $tableData = json_decode($request->input('table_data'), true) ?: [];

        foreach ($tableData as $data) {
            $entry = ExamProcessEntry::find($modalId);
            if (!$entry) continue;

            ExamCycleLog::create([
                'exam_candidate_id' => $entry->exam_candidate_id,
                'exam_process_entry_id' => $entry->id,
                'rejectDataStatus' => $data['rejectDataStatus'] ?? 0,
                'start_time' => isset($data['startTime']) ? date('Y-m-d H:i:s', $data['startTime'] / 1000) : null,
                'end_time' => isset($data['endTime']) ? date('Y-m-d H:i:s', $data['endTime'] / 1000) : null,
                'duration' => isset($data['endTime']) && isset($data['startTime']) ? (($data['endTime'] - $data['startTime']) / 1000) : null,
            ]);
        }

        // update average duration per entry
        if ($modalId) {
            $avg = ExamCycleLog::where('exam_process_entry_id', $modalId)->where('rejectDataStatus', 0)->avg('duration');
            if ($avg !== null) {
                ExamProcessEntry::where('id', $modalId)->update(['sewing_process_avg_cycles' => round(($avg / 60), 2)]);
            }
        }

        return redirect()->back()->with('success', 'Cycle logs saved');
    }

    public function matrixData_entry_form(ExamCandidate $candidate)
    {
        $entries = ExamProcessEntry::where('exam_candidate_id', $candidate->id)->get();
        return view('backend.exam.matrixData_entry', compact('candidate', 'entries'));
    }

    public function matrixData_store(Request $request)
    {
        $candidate = ExamCandidate::findOrFail($request->candidate_id);

        // update entries
        foreach ($request->operation_id ?? [] as $k => $process_id) {
            $entry = ExamProcessEntry::find($process_id);
            if (!$entry) continue;

            $entry->update([
                'smv' => $request->smv[$k] ?? $entry->smv,
                'target' => $request->target[$k] ?? $entry->target,
                'capacity' => $request->capacity[$k] ?? $entry->capacity,
                'self_production' => $request->production_self[$k] ?? $entry->self_production,
                'achive_production' => $request->production_achive[$k] ?? $entry->achive_production,
                'efficiency' => $request->efficiency[$k] ?? $entry->efficiency,
            ]);
        }

        // Use the same grading algorithm as WorkerEntryController
        $calculated = $this->calculate_grade($candidate->id);

        // Passing grades: only A++ / A+ / A / B+ / B are considered pass by policy.
        // If you want a different threshold, tell me and I will adjust.
        $passingGrades = ['A++', 'A+', 'A', 'B+', 'B', 'C++', 'C+', 'C', 'D'];
        $passed = isset($calculated['grade']) && in_array($calculated['grade'], $passingGrades, true);

        $candidate->update([
            'exam_passed' => $passed,
            'result_data' => $calculated,
        ]);

        return redirect()->route('exam.index')->with('success', 'Matrix data saved. Candidate grade: ' . ($calculated['grade'] ?? 'N/A'));
    }

    public function calculate_grade($candidate_id)
    {
        // Fetch candidate's exam process entries
        $entries = DB::table('exam_process_entries')
            ->where('exam_candidate_id', $candidate_id)
            ->get();

        // Get machine_type count
        $worker_machine_type = DB::table('sewing_process_lists')
            ->where('id',  $entries->pluck('sewing_process_list_id'))
            ->select('machine_type')
            ->distinct()
            ->get();
        $machine_count = $worker_machine_type->count() ?? 0;

        // Categorize processes by type and clamp efficiency (max 100%)
        $processes = [
            'normal' => [],
            'semi-critical' => [],
            'critical' => []
        ];

        foreach ($entries as $entry) {
            if (isset($processes[$entry->sewing_process_type])) {
                $efficiency = min($entry->efficiency, 100);
                $processes[$entry->sewing_process_type][] = $efficiency;
            }
        }

        // Define grading table (highest to lowest)
        $grading_table = [
            // Existing critical process grades (A++, A+, A)
            [
                'grade' => 'A++',
                'status' => ['critical'],
                'min_count' => PHP_INT_MAX,
                'efficiency_min' => 90,
                'efficiency_max' => 100,
                'salary_min' => 15500,
                'salary_max' => PHP_INT_MAX,
                'conditions' => ['must_have_all_critical' => true]
            ],
            [
                'grade' => 'A+',
                'status' => ['critical'],
                'min_count' => 3,
                'efficiency_min' => 75,
                'efficiency_max' => 100,
                'salary_min' => 15250,
                'salary_max' => 15500
            ],
            [
                'grade' => 'A',
                'status' => ['critical'],
                'min_count' => 3,
                'efficiency_min' => 70,
                'efficiency_max' => 100,
                'salary_min' => 14750,
                'salary_max' => 15200
            ],

            // NEW: Machine count-based grades
            [
                'grade' => 'A+',
                'status' => ['normal', 'semi-critical', 'critical'],
                'min_count' => 1,
                'efficiency_min' => 75,
                'efficiency_max' => 100,
                'salary_min' => 15250,
                'salary_max' => 15500,
                'conditions' => ['machine_count' => 2]
            ],
            [
                'grade' => 'A',
                'status' => ['critical'],
                'min_count' => 1,
                'efficiency_min' => 70,
                'efficiency_max' => 100,
                'salary_min' => 14750,
                'salary_max' => 15200,
                'conditions' => ['machine_count' => 1]
            ],

            // Existing non-critical grades (B+, B, etc.)
            [
                'grade' => 'B+',
                'status' => ['semi-critical', 'critical'],
                'min_count' => 3,
                'efficiency_min' => 65,
                'efficiency_max' => 100,
                'salary_min' => 14350,
                'salary_max' => 14700,
                'conditions' => [
                    'min_semi_critical' => 1,
                    'min_critical' => 1
                ]
            ],
            [
                'grade' => 'B',
                'status' => ['semi-critical'],
                'min_count' => 2,
                'efficiency_min' => 60,
                'efficiency_max' => 100,
                'salary_min' => 14100,
                'salary_max' => 14300
            ],

            // NEW: C++ for normal processes (no semi-critical)
            [
                'grade' => 'C++',
                'status' => ['normal'],
                'min_count' => 3,
                'efficiency_min' => 80,
                'efficiency_max' => 100,
                'salary_min' => 13800,
                'salary_max' => 14000,
                'conditions' => ['no_semi_critical' => true]
            ],
            // Existing C++ grade (with semi-critical)
            [
                'grade' => 'C++',
                'status' => ['normal', 'semi-critical'],
                'min_count' => 2,
                'efficiency_min' => 80,
                'efficiency_max' => 100,
                'salary_min' => 13800,
                'salary_max' => 14000,
                'conditions' => ['min_semi_critical' => 1]
            ],
            [
                'grade' => 'C+',
                'status' => ['normal'],
                'min_count' => 2,
                'efficiency_min' => 70,
                'efficiency_max' => 100,
                'salary_min' => 13650,
                'salary_max' => 13750
            ],
            [
                'grade' => 'C',
                'status' => ['normal'],
                'min_count' => 2,
                'efficiency_min' => 60,
                'efficiency_max' => 69,
                'salary_min' => 13550,
                'salary_max' => 13600
            ]
        ];

        // Check grades from highest to lowest
        foreach ($grading_table as $grade) {
            $filtered = [];
            $statusCounts = array_fill_keys($grade['status'], 0);

            // Collect eligible processes
            foreach ($grade['status'] as $status) {
                if (!empty($processes[$status])) {
                    foreach ($processes[$status] as $eff) {
                        if ($eff >= $grade['efficiency_min'] && $eff <= $grade['efficiency_max']) {
                            $filtered[] = $eff;
                            $statusCounts[$status]++;
                        }
                    }
                }
            }

            // Skip if minimum process count not met
            if (count($filtered) < $grade['min_count']) {
                continue;
            }

            // Handle special conditions
            $conditionsMet = true;
            if (isset($grade['conditions'])) {
                foreach ($grade['conditions'] as $cond => $value) {
                    switch ($cond) {
                        case 'must_have_all_critical':
                            $totalCritical = DB::table('sewing_process_lists')
                                ->where('process_type', 'critical')
                                ->count();
                            if (count($processes['critical']) < $totalCritical) {
                                $conditionsMet = false;
                            }
                            break;

                        case 'min_semi_critical':
                            if ($statusCounts['semi-critical'] < $value) {
                                $conditionsMet = false;
                            }
                            break;

                        case 'min_critical':
                            if ($statusCounts['critical'] < $value) {
                                $conditionsMet = false;
                            }
                            break;

                        case 'no_semi_critical':
                            if (!empty($processes['semi-critical'])) {
                                $conditionsMet = false;
                            }
                            break;

                        case 'machine_count':
                            if ($machine_count != $value) {
                                $conditionsMet = false;
                            }
                            break;
                    }
                }
            }

            if (!$conditionsMet) {
                continue;
            }

            // Calculate salary if conditions met
            $avgEff = count($filtered) > 0 ? array_sum($filtered) / count($filtered) : 0;
            $salary = $this->calculate_salary($avgEff, $grade);

            return [
                'grade' => $grade['grade'],
                'salary_range' => $salary
            ];
        }

        // Default grade if no matches
        return [
            'grade' => 'F',
            'salary_range' => 'N/A'
        ];
    }

    private function calculate_salary($avgEff, $grade)
    {
        $effRange = $grade['efficiency_max'] - $grade['efficiency_min'];
        $salRange = $grade['salary_max'] - $grade['salary_min'];

        // Handle open-ended ranges
        $effUpper = $grade['efficiency_max'] === PHP_INT_MAX ? 100 : $grade['efficiency_max'];
        $salUpper = $grade['salary_max'] === PHP_INT_MAX ? 20000 : $grade['salary_max']; // Set reasonable max

        if ($effRange > 0) {
            $ratio = ($avgEff - $grade['efficiency_min']) / ($effUpper - $grade['efficiency_min']);
            $salary = $grade['salary_min'] + ($ratio * ($salUpper - $grade['salary_min']));
        } else {
            $salary = $grade['salary_min'];
        }

        return round(min($salary, $salUpper), 2);
    }

    public function addToWorkerEntries(ExamCandidate $candidate)
    {
        // Legacy direct promotion - keep for backwards compat but prefer approvals
        // compute recommended numeric salary from candidate result_data if available
        $rec = $candidate->result_data['salary_range'] ?? null;
        $recommendedNumeric = null;
        if ($rec) {
            if (is_array($rec)) {
                $nums = array_values(array_filter($rec, 'is_numeric'));
                if (!empty($nums)) {
                    $recommendedNumeric = round(array_sum($nums) / count($nums), 2);
                }
            } elseif (is_numeric($rec)) {
                $recommendedNumeric = round($rec, 2);
            }
        }

        $workerData = [
            'employee_name_english' => $candidate->name,
            'id_card_no' => $candidate->nid,
            'nid' => $candidate->nid,
            'examination_date' => $candidate->examination_date ?? now()->format('Y-m-d'),
        ];

        if ($recommendedNumeric !== null) {
            $workerData['salary'] = $recommendedNumeric;
            $workerData['recomanded_salary'] = $recommendedNumeric;
        }

        $worker = WorkerEntry::create($workerData);

        // copy process entries and cycle logs into worker tables
        $entries = ExamProcessEntry::where('exam_candidate_id', $candidate->id)->get();
        foreach ($entries as $entry) {
            $w = $worker->workerSewingProcessEntries()->create([
                'sewing_process_list_id' => $entry->sewing_process_list_id,
                'worker_name' => $candidate->name,
                'sewing_process_name' => $entry->sewing_process_name,
                'sewing_process_type' => $entry->sewing_process_type,
                'smv' => $entry->smv,
                'target' => $entry->target,
                'sewing_process_avg_cycles' => $entry->sewing_process_avg_cycles,
                'capacity' => $entry->capacity,
                'self_production' => $entry->self_production,
                'achive_production' => $entry->achive_production,
                'efficiency' => $entry->efficiency,
                'examination_date' => $candidate->examination_date ?? now()->format('Y-m-d'),
            ]);

            // copy cycles
            $cycles = ExamCycleLog::where('exam_process_entry_id', $entry->id)->get();
            foreach ($cycles as $cycle) {
                $worker->cycleListLogs()->create([
                    'worker_sewing_process_entries_id' => $w->id,
                    'sewing_process_list_id' => $entry->sewing_process_list_id,
                    'worker_name' => $candidate->name,
                    'sewing_process_name' => $entry->sewing_process_name,
                    'sewing_process_type' => $entry->sewing_process_type,
                    'start_time' => $cycle->start_time,
                    'end_time' => $cycle->end_time,
                    'duration' => $cycle->duration,
                    'rejectDataStatus' => $cycle->rejectDataStatus,
                ]);
            }
        }

        return redirect()->route('workerEntrys_process_entry_form', $worker->id);
    }

    public function show(ExamCandidate $candidate)
    {
        // Load entries and their cycle logs
        $entries = ExamProcessEntry::where('exam_candidate_id', $candidate->id)->get();
        $entries = $entries->map(function ($e) {
            $e->cycles = ExamCycleLog::where('exam_process_entry_id', $e->id)->get();
            return $e;
        });

        // result_data is cast to array in the model; use it directly
        $result = $candidate->result_data ?: null;

        // load latest approval if any
        $approval = ExamApproval::where('exam_candidate_id', $candidate->id)->latest()->first();

        // fetch worker entry if already promoted (match by nid / id card)
        $worker = WorkerEntry::where('id_card_no', $candidate->nid)->latest()->first();

        return view('backend.exam.show', compact('candidate', 'entries', 'result', 'approval', 'worker'));
    }

    public function requestAddToWorker(Request $request, ExamCandidate $candidate)
    {
        $this->authorize('create', ExamApproval::class);

        // compute recommended numeric and max negotiation (3% above recommended)
        $rec = $candidate->result_data['salary_range'] ?? null;
        $recommendedNumeric = null;
        if ($rec) {
            if (is_array($rec)) {
                $nums = array_values(array_filter($rec, 'is_numeric'));
                if (!empty($nums)) {
                    $recommendedNumeric = round(array_sum($nums) / count($nums), 2);
                }
            } elseif (is_numeric($rec)) {
                $recommendedNumeric = round($rec, 2);
            }
        }

        $maxNegotiated = null;
        if (is_numeric($recommendedNumeric)) {
            $maxNegotiated = (int) floor($recommendedNumeric + ($recommendedNumeric * 0.03));
        }

        // Fix validation rules
        $validationRules = [
            'type' => 'required|in:agreed,negotiation,Special_Case_salary,disagree',
            'floor' => 'required|string|max:191',
            'line' => 'required|string|max:191',
        ];

        if ($request->type === 'negotiation') {
            $rule = 'required|numeric|min:0';
            if ($maxNegotiated !== null) {
                $rule .= '|max:' . $maxNegotiated;
            }
            $validationRules['requested_salary'] = $rule;
        } elseif ($request->type === 'Special_Case_salary') {
            $validationRules['Special_Case_salary'] = 'required|numeric|min:0';
            $validationRules['Special_Case_reason'] = 'required|string|max:255';
        } elseif ($request->type === 'disagree') {
            // Disagree case: no additional validation needed
        } else {
            $validationRules['hidden_requested_salary'] = 'required|numeric|min:0';
        }

        $request->validate($validationRules);

        // dd($request->all(), $validationRules);

        // Determine requested salary based on type
        if ($request->type === 'agreed') {
            $requestedSalary = $request->hidden_requested_salary;
        } elseif ($request->type === 'negotiation') {
            $requestedSalary = $request->requested_salary;
        } elseif ($request->type === 'disagree') {
            // For disagree, use the max negotiated salary or recommended salary
            $requestedSalary = $maxNegotiated ?? $recommendedNumeric ?? 0;
        } else {
            $requestedSalary = $request->Special_Case_salary;
        }

        // Normalize requested salary: handle arrays/objects safely and coerce to float
        if (is_array($requestedSalary) || is_object($requestedSalary)) {
            // try to extract numeric values from array/object
            $flat = [];
            $iter = (array) $requestedSalary;
            array_walk_recursive($iter, function ($v) use (&$flat) {
                if (is_numeric($v)) $flat[] = $v;
            });
            if (!empty($flat)) {
                $requestedSalary = round(array_sum($flat) / count($flat), 2);
            } else {
                $requestedSalary = null;
            }
        }

        // Ensure we have a valid salary value
        if ($requestedSalary === null || !is_numeric($requestedSalary) || $requestedSalary < 0) {
            return redirect()->back()->withErrors(['requested_salary' => 'Please provide a valid salary value.']);
        }

        if (ExamApproval::where('exam_candidate_id', $candidate->id)->where('status', 'pending')->exists()) {
            return redirect()->back()->with('error', 'There is already a pending approval for this candidate.');
        }

        // For disagree type, create a rejected approval record without notification
        if ($request->type === 'disagree') {
            $approval = ExamApproval::create([
                'exam_candidate_id' => $candidate->id,
                'requested_by' => Auth::id(),
                'requested_salary' => $requestedSalary,
                'type' => $request->type,
                'status' => 'rejected',
                'floor' => $request->floor,
                'line' => $request->line,
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            return redirect()->back()->with('success', 'Candidate marked as disagreed.');
        }

        $approval = ExamApproval::create([
            'exam_candidate_id' => $candidate->id,
            'requested_by' => Auth::id(),
            'requested_salary' => $requestedSalary,
            'type' => $request->type,
            'status' => 'pending',
            'floor' => $request->floor,
            'line' => $request->line,
            'special_case_salary' => $request->type === 'Special_Case_salary' ? $requestedSalary : null,
            'special_case_reason' => $request->type === 'Special_Case_salary' ? $request->Special_Case_reason : null,
        ]);

        // Notify approvers based on approver_roles and approver_users tables
        $approverRoleIds = \App\Models\ApproverRole::pluck('role_id')->toArray();
        $approverUserIds = \App\Models\ApproverUser::pluck('user_id')->toArray();

        // For Special Case salary, restrict to GM, HR, or Admin roles only
        if ($request->type === 'Special_Case_salary') {
            $query = \App\Models\User::query();
            $query->where(function ($q) {
                // HR role (role_id == 4), Admin, or GM
                $q->where('role_id', 4)
                    ->orWhereHas('role', function ($r) {
                        $r->whereRaw('LOWER(name) IN (?, ?)', ['gm', 'admin']);
                    });
            });
        } else {
            $query = \App\Models\User::query();
            $query->where(function ($q) use ($approverRoleIds, $approverUserIds) {
                if (!empty($approverRoleIds)) {
                    $q->orWhereIn('role_id', $approverRoleIds);
                }
                if (!empty($approverUserIds)) {
                    $q->orWhereIn('id', $approverUserIds);
                }
            });
        }

        // fallback: include HR role (role_id == 4) and any GM/Admin role users to ensure there's at least some approver
        $fallback = \App\Models\User::where(function ($q) {
            $q->where('role_id', 4)->orWhereHas('role', function ($r) {
                $r->whereRaw('LOWER(name) IN (?, ?)', ['gm', 'admin']);
            });
        });

        $approvers = $query->get();
        if ($approvers->isEmpty()) {
            $approvers = $fallback->get();
        }

        foreach ($approvers->unique('id') as $appUser) {
            try {
                $appUser->notify(new \App\Notifications\ApprovalRequestedNotification($approval));
            } catch (\Throwable $e) {
                Log::warning('ApprovalRequestedNotification failed: ' . $e->getMessage(), ['approval_id' => $approval->id, 'user_id' => $appUser->id]);
            }
        }

        return redirect()->back()->with('success', 'Promotion request submitted for approval');
    }

    public function approveApproval(Request $request, ExamApproval $approval)
    {

        $this->authorize('approve', $approval);

        if ($approval->status !== 'pending') {
            return redirect()->back()->with('error', 'Approval already processed');
        }

        DB::transaction(function () use ($approval) {
            $approval->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            // finalize: create worker entry and copy related data
            $this->finalizeAddToWorkerEntries($approval);
        });

        // notify requester
        $approval->requester && $approval->requester->notify(new \App\Notifications\ApprovalProcessedNotification($approval));

        return redirect()->back()->with('success', 'Approved and candidate promoted');
    }

    public function rejectApproval(Request $request, ExamApproval $approval)
    {
        $this->authorize('reject', $approval);

        if ($approval->status !== 'pending') {
            return redirect()->back()->with('error', 'Approval already processed');
        }

        $approval->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // notify requester
        $approval->requester && $approval->requester->notify(new \App\Notifications\ApprovalProcessedNotification($approval));

        return redirect()->back()->with('success', 'Promotion request rejected');
    }

    public function approvalsIndex(Request $request)
    {
        $this->authorize('viewAny', ExamApproval::class);
        // List approvals with optional filters: type and status
        $q = ExamApproval::with('candidate', 'requester')->orderByDesc('created_at');

        if ($type = $request->input('type')) {
            $q->where('type', $type);
        }

        if ($status = $request->input('status')) {
            $q->where('status', $status);
        }

        if ($fromDate = $request->input('from_date')) {
            $q->whereDate('created_at', '>=', $fromDate);
        }

        if ($toDate = $request->input('to_date')) {
            $q->whereDate('created_at', '<=', $toDate);
        }

        $approvals = $q->paginate(50)->appends($request->query());

        return view('backend.exam.approvals_index', compact('approvals'));
    }

    public function bulkApprove(Request $request)
    {
        $ids = $request->input('approval_ids', []);
        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'No approvals selected');
        }

        $approvals = ExamApproval::whereIn('id', $ids)->where('status', 'pending')->get();

        DB::transaction(function () use ($approvals) {
            foreach ($approvals as $approval) {
                $approval->update([
                    'status' => 'approved',
                    'approved_by' => Auth::id(),
                    'approved_at' => now(),
                ]);

                // finalize for each
                $this->finalizeAddToWorkerEntries($approval);

                // notify requester (defensive: don't let notification errors break the batch)
                try {
                    if ($approval->requester) {
                        $approval->requester->notify(new \App\Notifications\ApprovalProcessedNotification($approval));
                    }
                } catch (\Throwable $e) {
                    // log and continue
                    Log::warning('ApprovalProcessedNotification failed: ' . $e->getMessage(), ['approval_id' => $approval->id]);
                }
            }
        });

        return redirect()->back()->with('success', 'Selected approvals approved and finalized');
    }

    public function bulkReject(Request $request)
    {
        $ids = $request->input('approval_ids', []);
        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'No approvals selected');
        }

        $approvals = ExamApproval::whereIn('id', $ids)->where('status', 'pending')->get();

        DB::transaction(function () use ($approvals) {
            foreach ($approvals as $approval) {
                $approval->update([
                    'status' => 'rejected',
                    'approved_by' => Auth::id(),
                    'approved_at' => now(),
                ]);

                // notify requester
                $approval->requester && $approval->requester->notify(new \App\Notifications\ApprovalProcessedNotification($approval));
            }
        });

        return redirect()->back()->with('success', 'Selected approvals rejected');
    }

    /**
     * Delete a single approval. Admin only.
     */
    public function destroyApproval(ExamApproval $approval)
    {
        $user = Auth::user();
        if (strtolower(optional($user->role)->name ?? '') !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $approval->delete();

        return redirect()->back()->with('success', 'Approval deleted');
    }

    /**
     * Bulk delete approvals. Admin only.
     */
    public function bulkDestroy(Request $request)
    {
        $user = Auth::user();
        if (strtolower(optional($user->role)->name ?? '') !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $ids = $request->input('approval_ids', []);
        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'No approvals selected');
        }

        ExamApproval::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', 'Selected approvals deleted');
    }

    private function finalizeAddToWorkerEntries(ExamApproval $approval)
    {
        $candidate = $approval->candidate;

        // create worker entry minimal using nid and name
        // prefer using approved requested_salary; fallback to candidate's recommended numeric
        $salaryToSet = null;
        if (isset($approval->requested_salary) && is_numeric($approval->requested_salary)) {
            $salaryToSet = round($approval->requested_salary, 2);
        } else {
            $rec = $candidate->result_data['salary_range'] ?? null;
            if ($rec) {
                if (is_array($rec)) {
                    $nums = array_values(array_filter($rec, 'is_numeric'));
                    if (!empty($nums)) {
                        $salaryToSet = round(array_sum($nums) / count($nums), 2);
                    }
                } elseif (is_numeric($rec)) {
                    $salaryToSet = round($rec, 2);
                }
            }
        }

        $workerPayload = [
            'employee_name_english' => $candidate->name,
            'id_card_no' => $candidate->nid,
            'nid' => $candidate->nid,
            'examination_date' => $candidate->examination_date ?? now()->format('Y-m-d'),
            'present_grade' => $candidate->result_data['grade'] ?? null,
            'recomanded_grade' => $candidate->result_data['grade'] ?? null,
            'floor' => $approval->floor,
            'line' => $approval->line,
        ];

        if ($salaryToSet !== null) {
            $workerPayload['salary'] = $salaryToSet;
            $workerPayload['recomanded_salary'] = $salaryToSet;
        }

        $worker = WorkerEntry::create($workerPayload);

        $entries = ExamProcessEntry::where('exam_candidate_id', $candidate->id)->get();
        foreach ($entries as $entry) {
            $w = $worker->workerSewingProcessEntries()->create([
                'sewing_process_list_id' => $entry->sewing_process_list_id,
                'worker_name' => $candidate->name,
                'sewing_process_name' => $entry->sewing_process_name,
                'sewing_process_type' => $entry->sewing_process_type,
                'smv' => $entry->smv,
                'target' => $entry->target,
                'sewing_process_avg_cycles' => $entry->sewing_process_avg_cycles,
                'capacity' => $entry->capacity,
                'self_production' => $entry->self_production,
                'achive_production' => $entry->achive_production,
                'efficiency' => $entry->efficiency,
                'examination_date' => $candidate->examination_date ?? now()->format('Y-m-d'),
            ]);

            // copy cycles
            $cycles = ExamCycleLog::where('exam_process_entry_id', $entry->id)->get();
            foreach ($cycles as $cycle) {
                $worker->cycleListLogs()->create([
                    'worker_sewing_process_entries_id' => $w->id,
                    'sewing_process_list_id' => $entry->sewing_process_list_id,
                    'worker_name' => $candidate->name,
                    'sewing_process_name' => $entry->sewing_process_name,
                    'sewing_process_type' => $entry->sewing_process_type,
                    'start_time' => $cycle->start_time,
                    'end_time' => $cycle->end_time,
                    'duration' => $cycle->duration,
                    'rejectDataStatus' => $cycle->rejectDataStatus,
                ]);
            }
        }

        // mark candidate as promoted (optional)
        $candidate->update(['exam_passed' => 2]); // 2 = promoted (custom)
    }

    public function destroy(ExamCandidate $candidate)
    {
        DB::transaction(function () use ($candidate) {
            // model booted deleting will remove related entries/logs, but ensure cleanup
            foreach ($candidate->processEntries as $entry) {
                $entry->cycleLogs()->delete();
            }
            $candidate->processEntries()->delete();
            $candidate->cycleLogs()->delete();

            $candidate->delete();
        });

        return redirect()->route('exam.index')->with('success', 'Candidate and related exam data deleted.');
    }
}
