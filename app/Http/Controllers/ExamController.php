<?php

namespace App\Http\Controllers;

use App\Models\ExamCandidate;
use App\Models\ExamProcessEntry;
use App\Models\ExamCycleLog;
use App\Models\SewingProcessList;
use App\Models\WorkerEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // create worker entry minimal using nid and name
        $worker = WorkerEntry::create([
            'employee_name_english' => $candidate->name,
            'id_card_no' => $candidate->nid,
            'examination_date' => $candidate->examination_date ?? now()->format('Y-m-d'),
        ]);

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

        return view('backend.exam.show', compact('candidate', 'entries', 'result'));
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
