<?php

namespace App\Http\Controllers;

use App\Models\CycleListLog;
use App\Models\DisciplinaryProblem;
use App\Models\SewingProcessList;
use App\Models\TrainingDevelopment;
use App\Models\User;
use App\Models\WorkerEntry;
use App\Models\WorkerSewingProcessEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class WorkerEntryController extends Controller
{

    // public function index()
    // {
    //     $workerEntriesCollection = WorkerEntry::with(['sewingProcessEntries' => function ($query) {
    //         $query->with('sewingProcessList:id,machine_type');
    //     }])
    //         ->whereNull('old_matrix_Data_status')
    //         ->orderBy('id', 'desc');

    //     $cacheDuration = 60 * 60; // 1 hour cache duration
    //     $filtersApplied = false;
    //     $search_worker = null;

    //     $filters = [
    //         'floor' => fn($value) => WorkerEntry::where('floor', $value)->pluck('id'),
    //         'id_card_no' => fn($value) => WorkerEntry::where('id_card_no', $value)->pluck('id'),
    //         'sewing_process_type' => fn($value) => WorkerSewingProcessEntry::where('sewing_process_type', $value)->pluck('worker_entry_id'),
    //         'sewing_process_name' => fn($value) => WorkerSewingProcessEntry::where('sewing_process_name', $value)->pluck('worker_entry_id'),
    //         'present_grade' => fn($value) => WorkerEntry::where('present_grade', $value)->pluck('id'),
    //         'recomanded_grade' => fn($value) => WorkerEntry::where('recomanded_grade', $value)->pluck('id'),
    //         'low_performer' => fn() => $this->filterByPerformance('low'),
    //         'high_performer' => fn() => $this->filterByPerformance('high'),
    //     ];

    //     foreach ($filters as $param => $callback) {
    //         if ($value = request($param)) {
    //             $filtersApplied = true;
    //             $cacheKey = "workerEntries_{$param}_" . ($value ?? 'default');
    //             $workerEntriesCollection = $this->cacheFilterResults($workerEntriesCollection, $cacheKey, $cacheDuration, fn() => $callback($value));
    //         }
    //     }

    //     // For AJAX requests, return paginated JSON
    //     if (request()->ajax()) {
    //         $workerEntries = $workerEntriesCollection->paginate(10);

    //         $workerEntries->transform(function ($entry) {
    //             $entry->actions = view('backend.library.dataEntry.partials.actions', ['workerEntry' => $entry])->render();
    //             return $entry;
    //         });

    //         return response()->json([
    //             'workerEntries' => $workerEntries->items(),
    //             'pagination' => [
    //                 'current_page' => $workerEntries->currentPage(),
    //                 'last_page' => $workerEntries->lastPage(),
    //                 'total' => $workerEntries->total(),
    //             ],
    //             'search_worker' => $search_worker
    //         ]);
    //     }

    //     // For regular requests, handle filters and export
    //     if ($filtersApplied) {
    //         $workerEntries = $workerEntriesCollection->paginate(10);
    //         session(['search_worker' => $workerEntries]);
    //         $search_worker = $workerEntries;
    //     } elseif (request('export_format')) {
    //         $search_worker = session('search_worker');
    //     } else {
    //         $workerEntries = $workerEntriesCollection->paginate(10);
    //         session(['search_worker' => null]);
    //     }

    //     if (strtolower(request('export_format')) === 'xlsx') {
    //         $search_worker = session('search_worker');

    //         if (!$search_worker) {
    //             return redirect()->route('workerEntries.index')->withErrors('First search the data then export.');
    //         }

    //         $data = compact('search_worker');
    //         $viewContent = View::make('backend.library.dataEntry.export', $data)->render();
    //         $filename = Auth::user()->name . '_' . now()->format('Y_m_d') . '_' . time() . '.xls';

    //         return response()->make($viewContent, 200, [
    //             'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    //             'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    //         ]);
    //     }

    //     // Add actions for each entry for initial load
    //     $workerEntries->transform(function ($entry) {
    //         $entry->actions = view('backend.library.dataEntry.partials.actions', ['workerEntry' => $entry])->render();
    //         return $entry;
    //     });

    //     return view('backend.library.dataEntry.index', compact('workerEntries', 'search_worker'));
    // }




    // private function filterByPerformance($type)
    // {
    //     $grades = [
    //         'D' => 1,
    //         'C' => 2,
    //         'C+' => 3,
    //         'C++' => 4,
    //         'B' => 5,
    //         'B+' => 6,
    //         'A' => 7,
    //         'A+' => 8,
    //         'F' => 0, // Add F with value 0
    //     ];

    //     return WorkerEntry::all()->filter(function ($workerEntry) use ($grades, $type) {
    //         $presentValue = $grades[$workerEntry->present_grade] ?? 9;
    //         $recommendedValue = $grades[$workerEntry->recomanded_grade] ?? 0;

    //         return $type === 'low'
    //             ? $presentValue > $recommendedValue
    //             : $presentValue < $recommendedValue;
    //     })->pluck('id')->toArray();
    // }



    public function index()
    {
        $workerEntriesCollection = WorkerEntry::with(['sewingProcessEntries' => function ($query) {
            $query->with('sewingProcessList:id,machine_type');
        }])
            ->whereNull('old_matrix_Data_status')
            ->orderBy('id', 'desc');

        $cacheDuration = 60 * 60; // 1 hour cache duration
        $filtersApplied = false;
        $showExportButton = false; // Initialize export button flag

        $filters = [
            'floor' => fn($value) => WorkerEntry::where('floor', $value)->pluck('id'),
            'id_card_no' => fn($value) => WorkerEntry::where('id_card_no', $value)->pluck('id'),
            'sewing_process_type' => fn($value) => WorkerSewingProcessEntry::where('sewing_process_type', $value)->pluck('worker_entry_id'),
            'sewing_process_name' => fn($value) => WorkerSewingProcessEntry::where('sewing_process_name', $value)->pluck('worker_entry_id'),
            'present_grade' => fn($value) => WorkerEntry::where('present_grade', $value)->pluck('id'),
            'recomanded_grade' => fn($value) => WorkerEntry::where('recomanded_grade', $value)->pluck('id'),
            'low_performer' => fn() => $this->filterByPerformance('low'),
            'high_performer' => fn() => $this->filterByPerformance('high'),
        ];

        foreach ($filters as $param => $callback) {
            if ($value = request($param)) {
                $filtersApplied = true;
                $cacheKey = "workerEntries_{$param}_" . ($value ?? 'default');
                $workerEntriesCollection = $this->cacheFilterResults($workerEntriesCollection, $cacheKey, $cacheDuration, fn() => $callback($value));
            }
        }

        // Store filtered IDs for export and set export button flag
        if ($filtersApplied) {
            $filteredIds = $workerEntriesCollection->pluck('id')->toArray();
            session(['search_worker_ids' => $filteredIds]);
            $showExportButton = true;
        } else {
            session()->forget('search_worker_ids');
        }

        // For AJAX requests, return paginated JSON
        if (request()->ajax()) {
            $workerEntries = $workerEntriesCollection->paginate(10);

            $workerEntries->transform(function ($entry) {
                $entry->actions = view('backend.library.dataEntry.partials.actions', ['workerEntry' => $entry])->render();
                return $entry;
            });

            return response()->json([
                'workerEntries' => $workerEntries->items(),
                'pagination' => [
                    'current_page' => $workerEntries->currentPage(),
                    'last_page' => $workerEntries->lastPage(),
                    'total' => $workerEntries->total(),
                ],
            ]);
        }

        // Handle Excel export - FIXED CONDITION
        if (request('export_format') === 'xlsx') {
            $filteredIds = session('search_worker_ids', []);

            if (empty($filteredIds)) {
                return redirect()->route('workerEntries.index')->withErrors('First search the data then export.');
            }

            $search_worker = WorkerEntry::with(['sewingProcessEntries' => function ($query) {
                $query->with('sewingProcessList:id,machine_type');
            }])
                ->whereIn('id', $filteredIds)
                ->orderBy('id', 'desc')
                ->get();

            $data = compact('search_worker');
            $viewContent = View::make('backend.library.dataEntry.export', $data)->render();
            $filename = Auth::user()->name . '_' . now()->format('Y_m_d') . '_' . time() . '.xls';

            return response()->make($viewContent, 200, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        }

        $workerEntries = $workerEntriesCollection->paginate(10);

        // Add actions for each entry for initial load
        $workerEntries->transform(function ($entry) {
            $entry->actions = view('backend.library.dataEntry.partials.actions', ['workerEntry' => $entry])->render();
            return $entry;
        });

        return view('backend.library.dataEntry.index', compact('workerEntries', 'showExportButton'));
    }


    private function filterByPerformance($type)
    {
        $grades = [
            'D' => 1,
            'C' => 2,
            'C+' => 3,
            'C++' => 4,
            'B' => 5,
            'B+' => 6,
            'A' => 7,
            'A+' => 8,
            'F' => 0
        ];

        $presentCase = 'case';
        $presentBindings = [];
        foreach ($grades as $grade => $value) {
            $presentCase .= " when present_grade = ? then ?";
            $presentBindings[] = $grade;
            $presentBindings[] = $value;
        }
        $presentCase .= ' else 9 end';

        $recommendedCase = 'case';
        $recommendedBindings = [];
        foreach ($grades as $grade => $value) {
            $recommendedCase .= " when recomanded_grade = ? then ?";
            $recommendedBindings[] = $grade;
            $recommendedBindings[] = $value;
        }
        $recommendedCase .= ' else 0 end';

        $bindings = array_merge($presentBindings, $recommendedBindings);
        $operator = $type === 'low' ? '>' : '<';

        return WorkerEntry::query()
            ->whereRaw("({$presentCase}) {$operator} ({$recommendedCase})", $bindings)
            ->pluck('id')
            ->toArray();
    }

    private function cacheFilterResults($query, $cacheKey, $cacheDuration, $filterCallback)
    {
        $ids = Cache::remember($cacheKey, $cacheDuration, $filterCallback);
        return $query->whereIn('id', $ids);
    }
    public function old_index()
    {
        $workerEntriesCollection = WorkerEntry::with(['sewingProcessEntries' => function ($query) {
            $query->with('sewingProcessList:id,machine_type');
        }])
            ->where('old_matrix_Data_status', 1)
            ->orderBy('id', 'desc');

        $search_worker = null;
        $workerProcessEntries = WorkerSewingProcessEntry::all();

        if (request('floor')) {
            $workerEntriesCollection = $workerEntriesCollection->where('floor', request('floor'));
            $search_worker = $workerEntriesCollection->get();
            session(['search_worker' => $search_worker]);
        }

        if (request('id_card_no')) {
            $workerEntriesCollection = $workerEntriesCollection->where('id_card_no', request('id_card_no'));
            $search_worker = $workerEntriesCollection->get();
            session(['search_worker' => $search_worker]);
        }

        if (request('process_type')) {
            $workerProcessEntries = WorkerSewingProcessEntry::where('sewing_process_type', request('process_type'))->get();
            $workerEntriesCollection = $workerEntriesCollection->whereIn('id', $workerProcessEntries->pluck('worker_entry_id'));
            $search_worker = $workerEntriesCollection->get();
            session(['search_worker' => $search_worker]);
        }

        if (request('process_name')) {
            $workerProcessEntries = WorkerSewingProcessEntry::where('sewing_process_name', request('process_name'))->get();
            $workerEntriesCollection = $workerEntriesCollection->whereIn('id', $workerProcessEntries->pluck('worker_entry_id'));
            $search_worker = $workerEntriesCollection->get();
            session(['search_worker' => $search_worker]);
        }

        if (request('recomanded_grade')) {
            $workerEntriesCollection = $workerEntriesCollection->where('recomanded_grade', request('recomanded_grade'));
            $search_worker = $workerEntriesCollection->get();
            session(['search_worker' => $search_worker]);
        }

        if (request('low_performer')) {
            $grades = [
                'D' => 1,
                'C' => 2,
                'C+' => 3,
                'C++' => 4,
                'B' => 5,
                'B+' => 6,
                'A' => 7,
                'A+' => 8,
                'F' => 0,
            ];

            $search_worker_ids = [];
            foreach ($workerEntriesCollection->get() as $workerEntry) {
                if ($workerEntry->present_grade != null && $workerEntry->recomanded_grade != null) {
                    $present_grade_value = $grades[$workerEntry->present_grade] ?? 9;
                    $recommended_grade_value = $grades[$workerEntry->recomanded_grade] ?? 0;
                } else {
                    $present_grade_value = 9;
                    $recommended_grade_value = 0;
                }

                if ($present_grade_value > $recommended_grade_value) {
                    $search_worker_ids[] = $workerEntry->id;
                }
            }

            $workerEntriesCollection = $workerEntriesCollection->whereIn('id', $search_worker_ids);
            $search_worker = $workerEntriesCollection->get();
            session(['search_worker' => $search_worker]);
        }

        if (request('high_performer')) {
            $grades = [
                'D' => 1,
                'C' => 2,
                'C+' => 3,
                'C++' => 4,
                'B' => 5,
                'B+' => 6,
                'A' => 7,
                'A+' => 8,
                'F' => 0,
            ];

            $search_worker_ids = [];
            foreach ($workerEntriesCollection->get() as $workerEntry) {
                if ($workerEntry->present_grade != null && $workerEntry->recomanded_grade != null) {
                    $present_grade_value = $grades[$workerEntry->present_grade] ?? 9;
                    $recommended_grade_value = $grades[$workerEntry->recomanded_grade] ?? 0;
                } else {
                    $present_grade_value = 9;
                    $recommended_grade_value = 0;
                }

                if ($present_grade_value < $recommended_grade_value) {
                    $search_worker_ids[] = $workerEntry->id;
                }
            }

            $workerEntriesCollection = $workerEntriesCollection->whereIn('id', $search_worker_ids);
            $search_worker = $workerEntriesCollection->get();
            session(['search_worker' => $search_worker]);
        }

        $workerEntries = $workerEntriesCollection->paginate(10);

        // Add actions for each entry
        $workerEntries->transform(function ($entry) {
            $entry->actions = view('backend.library.dataEntry.partials.actions', ['workerEntry' => $entry])->render();
            return $entry;
        });

        if (request()->ajax()) {
            return response()->json([
                'workerEntries' => $workerEntries->items(),
                'pagination' => [
                    'current_page' => $workerEntries->currentPage(),
                    'last_page' => $workerEntries->lastPage(),
                    'total' => $workerEntries->total(),
                ],
                'search_worker' => $search_worker
            ]);
        }

        $format = strtolower(request('export_format'));
        if ($format === 'xlsx') {
            $search_worker = session('search_worker');

            if ($search_worker == null) {
                return redirect()->route('workerEntries.index')->withErrors('First search the data then export.');
            } else {
                $data = compact('search_worker');
                $viewContent = View::make('backend.library.dataEntry.export', $data)->render();
                $filename = Auth::user()->name . '_' . Carbon::now()->format('Y_m_d') . '_' . time() . '.xls';
                $headers = [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                ];

                return response()->make($viewContent, 200, $headers);
            }
        }

        return view('backend.library.dataEntry.old_index', compact('workerEntries', 'search_worker'));
    }

   

     public function create()
    {
        return view('backend.library.dataEntry.create', [
            'worker' => new WorkerEntry(),
        ]);
    }



    public function workerEntrys_id_entry(Request $request)
    {
        // dd($request->all());



        $joiningDate = Carbon::parse($request->joining_date);
        $now = Carbon::now();

        $years = $joiningDate->diffInYears($now);
        $months = $joiningDate->diffInMonths($now) % 12; // Calculate remaining months after years
        $days = $joiningDate->diffInDays($now) % 30; // Calculate remaining days after months

        $experience = "{$years} years {$months} months {$days} days";

        if ($request->designation_name == "Line Leader") {
            $designation_id = 1;
        } elseif ($request->designation_name == "JSMO") {
            $designation_id = 2;
        } elseif ($request->designation_name == "OSMO") {
            $designation_id = 3;
        } elseif ($request->designation_name == "SMO") {
            $designation_id = 4;
        } elseif ($request->designation_name == "SSMO") {
            $designation_id = 5;
        }



        // data Entry by id card
        $workerEntry = WorkerEntry::create([
            'division_id' => $request->division_id,
            'division_name' => $request->division_name,
            'company_id' => $request->company_id,
            'company_name' => $request->company_name,
            'department_id' => $request->department_id,
            'department_name' => $request->department_name,
            'designation_id' => $designation_id,
            'designation_name' => $request->designation_name,
            'employee_name_english' => $request->employee_name_english,
            'id_card_no' => $request->id_card_no,
            'joining_date' => $request->joining_date,
            'present_grade' => $request->present_grade,
            'examination_date' => $request->examination_date,
            'experience' =>  $experience,
            'salary' => $request->salary,
            'floor' => $request->floor,
            'line' => $request->line,
        ]);
        return redirect()->route('workerEntrys_process_entry_form', $workerEntry->id);
    }

    public function workerEntrys_process_entry_form(WorkerEntry $workerEntry)
    {
        // dd($workerEntry->id);
        $workerEntry = WorkerEntry::find($workerEntry->id);

        return view('backend.library.dataEntry.process_entry', compact('workerEntry'));
        // return redirect()->route('workerEntrys_process_entry_form', $workerEntry->id);
    }

    public function workerEntrys_process_entry(Request $request)
    {
        // dd($request->all());

        //find old SewingProcessList id and if new SewingProcessList id is  not same then find the data whhich is not exist in new SewingProcessList id and delete that id related all data from cycle_list_logs table , worker_sewing_process_entries table where worker_entry_id is $request->worker_id and sewing_process_list_id is not in new SewingProcessList id
        $oldSewingProcessList = WorkerSewingProcessEntry::where('worker_entry_id', $request->worker_id)->get();
        $oldSewingProcessListId = $oldSewingProcessList->pluck('sewing_process_list_id');
        $newSewingProcessListId = $request->sewing_process_lists_id;

        $deleteSewingProcessListId = $oldSewingProcessListId->diff($newSewingProcessListId);

        // dd($oldSewingProcessList, $oldSewingProcessListId, $newSewingProcessListId, $deleteSewingProcessListId);


        // if ($deleteSewingProcessListId->count() > 0) {
        //     CycleListLog::where('worker_entry_id', $request->worker_id)->whereIn('sewing_process_list_id', $deleteSewingProcessListId)->delete();
        //     WorkerSewingProcessEntry::where('worker_entry_id', $request->worker_id)->whereIn('sewing_process_list_id', $deleteSewingProcessListId)->delete();
        // }




        foreach ($request->sewing_process_lists_id as $key => $process_id) {
            $SewingProcessList = SewingProcessList::find($process_id);
            $workerInfo = WorkerEntry::find($request->worker_id);

            $WorkerSewingProcessEntry = new WorkerSewingProcessEntry();
            if ($WorkerSewingProcessEntry->where('worker_entry_id', $request->worker_id)->where('sewing_process_list_id', $process_id)->exists()) {
                $WorkerSewingProcessEntry->where('worker_entry_id', $request->worker_id)->where('sewing_process_list_id', $process_id)->update([
                    'worker_entry_id' => $request->worker_id,
                    'worker_name' => $workerInfo->employee_name_english,
                    'user_id' => $workerInfo->id,
                    'sewing_process_list_id' => $process_id,
                    'sewing_process_name' => $SewingProcessList->process_name,
                    'sewing_process_type' => $SewingProcessList->process_type,
                    'dataEntryBy' => Auth()->user()->name,
                    'dataEntryDate' => now()
                ]);
            } else {
                $WorkerSewingProcessEntry->worker_entry_id = $request->worker_id;
                $WorkerSewingProcessEntry->worker_name = $workerInfo->employee_name_english;
                $WorkerSewingProcessEntry->user_id = $workerInfo->id;
                $WorkerSewingProcessEntry->sewing_process_list_id = $process_id;
                $WorkerSewingProcessEntry->sewing_process_name = $SewingProcessList->process_name;
                $WorkerSewingProcessEntry->sewing_process_type = $SewingProcessList->process_type;
                $WorkerSewingProcessEntry->dataEntryBy = Auth()->user()->name;
                $WorkerSewingProcessEntry->dataEntryDate = now();
                $WorkerSewingProcessEntry->save();
            }
        }
        return redirect()->route('cyclesData_entry_form', $request->worker_id);
        // $operationEntry = WorkerSewingProcessEntry::where('worker_entry_id', $request->worker_id)->get();
        // $workerEntry_id = $request->worker_id;
        // return view('backend.library.dataEntry.cyclesData_entry', compact('operationEntry', 'workerEntry_id'));
    }

    public function cyclesData_entry_form(WorkerEntry $workerEntry)
    {

        $operationEntry = WorkerSewingProcessEntry::where('worker_entry_id', $workerEntry->id)->get();
        $workerEntry_id = $workerEntry->id;
        return view('backend.library.dataEntry.cyclesData_entry', compact('operationEntry', 'workerEntry_id'));
    }
    public function cyclesData_entry(WorkerEntry $workerEntry)
    {

        $operationEntry = WorkerSewingProcessEntry::where('worker_entry_id', $workerEntry->id)->get();
        $workerEntry_id = $workerEntry->id;
        return view('backend.library.dataEntry.cyclesData_entry', compact('operationEntry', 'workerEntry_id'));
    }

    public function cyclesData_store(Request $request, WorkerSewingProcessEntry $oe)
    {
        try {
            // Extract data from the request
            $modalId = $request->input('modal_id');
            $tableData = json_decode($request->input('table_data'), true);
            $operationType = $request->input('operation_type');
            $operationName = $request->input('operation_name');

            // Initialize an array to store cycle list log records
            $cycleListLogs = [];

            foreach ($tableData as $data) {
                $cycle = WorkerSewingProcessEntry::where('id', $modalId)->first();

                // Create an array representing a row to be inserted
                $cycleListLogData = [
                    'worker_entry_id' => $cycle->worker_entry_id,
                    'sewing_process_list_id' => $cycle->sewing_process_list_id,
                    'user_id' => $cycle->user_id,
                    'worker_name' => $cycle->worker_name,
                    'sewing_process_name' => $operationName,
                    'sewing_process_type' => $operationType,
                    'worker_sewing_process_entries_id' => $modalId,
                    'rejectDataStatus' => $data['rejectDataStatus'],
                    'start_time' => date('Y-m-d H:i:s', $data['startTime'] / 1000), // Convert milliseconds to seconds
                    'end_time' => date('Y-m-d H:i:s', $data['endTime'] / 1000),     // Convert milliseconds to seconds
                    'duration' => ($data['endTime'] - $data['startTime']) / 1000,  // Convert milliseconds to seconds
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Add the row data to the array of cycle list log records
                $cycleListLogs[] = $cycleListLogData;
            }

            // Bulk insert the cycle list log records
            CycleListLog::insert($cycleListLogs);

            // Calculate the average duration in seconds
            $averageDurationInSeconds = CycleListLog::where('worker_sewing_process_entries_id', $modalId)
                ->where('rejectDataStatus', 0) // Only consider records with rejectDataStatus 0
                ->avg('duration');

            // Update the worker_sewing_process_entries with the rounded average value
            $averageDurationInSeconds = round($averageDurationInSeconds / 60, 2);
            WorkerSewingProcessEntry::where('id', $modalId)
                ->update(['sewing_process_avg_cycles' => $averageDurationInSeconds]);

            // Redirect or return a success response
            return redirect()->back()->with('success', 'Cycle List Logs inserted successfully!');
        } catch (\Exception $e) {
            // Handle any exceptions or validation errors here
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function workerEntrys_matrixData_entry_form(WorkerEntry $workerEntry)
    {

        $operationEntry = WorkerSewingProcessEntry::where('worker_entry_id', $workerEntry->id)->get();
        return view('backend.library.dataEntry.matrixData_entry', compact('operationEntry'));
    }

    public function matrixData_store(Request $request)
    {
        // dd($request->all());    // dd($request->all());
        try {
            // Loop through the arrays and update records
            foreach ($request->operation_id as $key => $process_id) {
                $WorkerSewingProcessEntry = WorkerSewingProcessEntry::where('id', $process_id)->first();
                $examination_date = WorkerEntry::where('id', $request->worker_id)->first()->examination_date;

                // Update the WorkerSewingProcessEntry record
                $WorkerSewingProcessEntry->update([
                    'smv' => $request->smv[$key],
                    'target' => $request->target[$key],
                    'capacity' => $request->capacity[$key],
                    'self_production' => $request->production_self[$key],
                    'achive_production' => $request->production_achive[$key],
                    'efficiency' => $request->efficiency[$key],
                    'necessity_of_helper' => $request->necessity_of_helper,
                    'perception_about_size' => $request->perception_about_size,
                    'rating' => $request->team_rating,
                    'examination_date' => $examination_date,
                    'dataEditBy' => Auth()->user()->name,
                    'dataEditDate' => now(),
                ]);
            }

            // Calculate the grade and recommended salary range
            $Worker = WorkerEntry::where('id', $request->worker_id)->first();
            $calculated_grade = $this->calculate_grade($request->worker_id);

            if ($calculated_grade['grade'] === 'Fail') {
                // If grade is Fail, retain the present grade
                $Worker->update([
                    'recomanded_grade' => $Worker->present_grade,
                    'recomanded_salary' => 'N/A',
                ]);
            } else {
                // Update recommended grade and salary range
                $Worker->update([
                    'recomanded_grade' => $calculated_grade['grade'],
                    'recomanded_salary' => $calculated_grade['salary_range'],
                ]);
            }

            // Redirect or return a success response
            return redirect()->route('workerEntries.index')->with('success', 'Matrix Data inserted successfully!');
        } catch (\Exception $e) {
            // Handle any exceptions or validation errors here
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function show(WorkerEntry $workerEntry)
    {
        $workerEntry = WorkerEntry::find($workerEntry->id);
        $sewingProcessEntries = WorkerSewingProcessEntry::where('worker_entry_id', $workerEntry->id)->get();
        $cycleListLogs = CycleListLog::where('worker_entry_id', $workerEntry->id)->get();
        return view('backend.library.dataEntry.show', compact('workerEntry', 'sewingProcessEntries', 'cycleListLogs'));
    }

    public function approval(WorkerEntry $workerEntry)
    {
        $workerEntry = WorkerEntry::find($workerEntry->id);
        //only show the data which smv, sewing_process_avg_cycles, capacity, self_production,achive_production is not null
        $sewingProcessEntries = WorkerSewingProcessEntry::where('worker_entry_id', $workerEntry->id)
            ->whereNotNull('smv')
            ->whereNotNull('sewing_process_avg_cycles')
            ->whereNotNull('capacity')
            // ->whereNotNull('self_production')
            // ->whereNotNull('achive_production')
            ->get();

        $curiosity_to_lern = WorkerSewingProcessEntry::where('worker_entry_id', $workerEntry->id)->whereNull('smv')
            ->whereNull('sewing_process_avg_cycles')
            ->whereNull('capacity')
            ->whereNull('self_production')
            ->whereNull('achive_production')
            ->get();

        $cycleListLogs = CycleListLog::where('worker_entry_id', $workerEntry->id)->get();
        // dd($cycleListLogs, $sewingProcessEntries);
        return view('backend.library.dataEntry.approvalData_entry', compact('workerEntry', 'sewingProcessEntries', 'curiosity_to_lern', 'cycleListLogs'));
    }

    public function edit(WorkerEntry $workerEntry)
    {
        // dd($workerEntry->id);
        $workerEntry = WorkerEntry::find($workerEntry->id);
        $sewingProcessEntries = WorkerSewingProcessEntry::where('worker_entry_id', $workerEntry->id)->get();
        $cycleListLogs = CycleListLog::where('worker_entry_id', $workerEntry->id)->get();
        return view('backend.library.dataEntry.edit', compact('workerEntry', 'sewingProcessEntries', 'cycleListLogs'));
    }



    public function update(Request $request, WorkerEntry $workerEntry)
    {

        // dd($request->all());
        $workerEntry = WorkerEntry::find($workerEntry->id);

        $joiningDate = Carbon::parse($request->joining_date);
        $now = Carbon::now();

        $years = $joiningDate->diffInYears($now);
        $months = $joiningDate->diffInMonths($now) % 12; // Calculate remaining months after years
        $days = $joiningDate->diffInDays($now) % 30; // Calculate remaining days after months

        $experience = "{$years} years {$months} months {$days} days";

        if (
            $request->designation_name == "Line Leader"
        ) {
            $designation_id = 1;
        } elseif ($request->designation_name == "JSMO") {
            $designation_id = 2;
        } elseif ($request->designation_name == "OSMO") {
            $designation_id = 3;
        } elseif ($request->designation_name == "SMO") {
            $designation_id = 4;
        } elseif ($request->designation_name == "SSMO") {
            $designation_id = 5;
        }

        // data Entry by id card
        $workerEntry->update([
            'employee_name_english' => $request->employee_name_english ?? $workerEntry->employee_name_english,
            'joining_date' => $request->joining_date ?? $workerEntry->joining_date,
            'examination_date' => $request->examination_date ?? $workerEntry->examination_date,
            'designation_id' => $designation_id ?? $workerEntry->designation_id,
            'designation_name' => $request->designation_name ?? $workerEntry->designation_name,
            'present_grade' => $request->present_grade ?? $workerEntry->present_grade,
            'experience' => $experience ?? $workerEntry->experience,
            'salary' => $request->salary ?? $workerEntry->salary,
            'line' => $request->line ?? $workerEntry->line,
        ]);
        return redirect()->route('workerEntrys_process_entry_form', $workerEntry->id);
    }


    public function destroy(WorkerEntry $workerEntry)
    {
        $workerEntry = WorkerEntry::find($workerEntry->id);
        $sewingProcessEntries = WorkerSewingProcessEntry::where('worker_entry_id', $workerEntry->id)->get();
        foreach ($sewingProcessEntries as $key => $sewingProcessEntry) {
            $sewingProcessEntry->delete();
        }
        $cycleListLogs = CycleListLog::where('worker_entry_id', $workerEntry->id)->get();
        foreach ($cycleListLogs as $key => $cycleListLog) {
            $cycleListLog->delete();
        }

        $workerEntry->delete();
        return redirect()->back()->with('success', 'Worker Entry deleted successfully!');
    }

    public function workerEntrys_id_search(Request $request)
    {

        $id_card_no = $request->id;

        // Execute the query and retrieve the worker data
        // $worker = WorkerEntry::where('id_card_no', 'LIKE', '%' . $id_card_no . '%')->first();
        $worker = WorkerEntry::where('id_card_no', $id_card_no)->first();


        // return view('backend.library.dataEntry.create', compact('worker'));
        $workerEntry = WorkerEntry::find($worker->id);
        $sewingProcessEntries = WorkerSewingProcessEntry::where('worker_entry_id', $workerEntry->id)->get();
        $cycleListLogs = CycleListLog::where('worker_entry_id', $workerEntry->id)->get();
        return view('backend.library.dataEntry.edit', compact('workerEntry', 'sewingProcessEntries', 'cycleListLogs'));
    }

   

    public function workerEntrys_process_type_search(Request $request)
    {
        $process_types = $request->input('process_type', []);

        if (empty($process_types)) {
            return redirect()->back()->withErrors(['process_type' => 'Please select at least one process type']);
        }

        $sewingProcessList = SewingProcessList::whereIn('process_type', $process_types)->get();

        $groupedProcesses = $sewingProcessList->groupBy(['process_type', 'machine_type']);

        $workerEntry = WorkerEntry::find($request->worker_id);
        return view('backend.library.dataEntry.process_entry', compact('workerEntry', 'groupedProcesses'));
    }

  

    public function calculate_grade($worker_id)
    {
        // Fetch worker's sewing process entries
        $workerEntries = DB::table('worker_sewing_process_entries')
            ->where('worker_entry_id', $worker_id)
            ->get();

        // Get machine_type count
        $worker_machine_type = DB::table('sewing_process_lists')
            ->where('id',  $workerEntries->pluck('sewing_process_list_id'))
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

        foreach ($workerEntries as $entry) {
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
                'efficiency_min' => 75, // Default for critical-based A+
                'efficiency_max' => 100,
                'salary_min' => 15250,
                'salary_max' => 15500
            ],
            [
                'grade' => 'A',
                'status' => ['critical'],
                'min_count' => 3,
                'efficiency_min' => 70, // Default for critical-based A
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
                'efficiency_max' => 79,
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



    /* new method end
     */



    public function training_development()
    {
        return view('report.training_development');
    }

    public function training_development_store(Request $request)
    {
        // dd($request->all());
        try {
            foreach ($request->id_card_no as $key => $id_card_no) {
                // Find the corresponding worker entry
                $workerEntry = WorkerEntry::where('id_card_no', $id_card_no)->first();

                // Ensure worker entry is found
                if (!$workerEntry) {
                    // You can skip this record or throw an exception based on your requirement
                    continue; // Skip to the next iteration
                    // throw new \Exception("Worker entry not found for ID: $id_card_no");
                }
                // dd($workerEntry);
                // training development record creation
                $trainingDevelopment = new TrainingDevelopment();
                $trainingDevelopment->training_date = $request->training_date;
                $trainingDevelopment->worker_entry_id = $workerEntry->id;
                $trainingDevelopment->examination_date = $workerEntry->examination_date;
                $trainingDevelopment->training_name = $request->training_name;
                $trainingDevelopment->id_card_no = $id_card_no;
                $trainingDevelopment->training_duration = $request->training_duration;
                $trainingDevelopment->dataEntryBy = Auth()->user()->name;
                $trainingDevelopment->save();
            }

            return redirect()->route('workerEntries.index')->with('success', 'Training Development Data inserted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    //disciplinary_problems
    public function disciplinary_problems()
    {
        return view('report.disciplinary_problems');
    }


    public function disciplinary_problems_store(Request $request)
    {
        // dd($request->all());
        try {
            // Loop through each disciplinary problem entry
            foreach ($request->id_card_no as $key => $id_card_no) {
                // Find the corresponding worker entry
                $workerEntry = WorkerEntry::where('id_card_no', $id_card_no)->first();

                // Ensure worker entry is found
                if (!$workerEntry) {
                    // If worker entry not found, you can choose to skip or throw an exception
                    continue; // Skip to the next iteration
                    // throw new \Exception("Worker entry not found for ID: $id_card_no");
                }

                // dd($workerEntry);

                // Create a new disciplinary problem record
                $disciplinaryProblem = new DisciplinaryProblem();
                $disciplinaryProblem->disciplinary_problem_date = $request->disciplinary_problem_date;
                $disciplinaryProblem->worker_entry_id = $workerEntry->id;
                $disciplinaryProblem->examination_date = $workerEntry->examination_date;
                $disciplinaryProblem->disciplinary_problem_status = 1; // Assuming this is a default value
                // $disciplinaryProblem->id_card_no = $id_card_no;
                $disciplinaryProblem->disciplinary_problem_description = $request->disciplinary_problem_description[$key];
                $disciplinaryProblem->dataEntryBy = Auth()->user()->name;
                // dd($disciplinaryProblem);
                $disciplinaryProblem->save();
            }

            return redirect()->route('workerEntries.index')->withMessage('Disciplinary Problems Data inserted successfully!');
        } catch (\Exception $e) {
            // Handle exceptions
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function workerEntries_Line_Entry(WorkerEntry $workerEntry)
    {
        $workerEntry = WorkerEntry::find($workerEntry->id);
        $sewingProcessEntries = WorkerSewingProcessEntry::where('worker_entry_id', $workerEntry->id)->get();
        $cycleListLogs = CycleListLog::where('worker_entry_id', $workerEntry->id)->get();
        return view('backend.library.dataEntry.workerEntries_Line_Entry', compact('workerEntry', 'sewingProcessEntries', 'cycleListLogs'));
    }



    public function workerEntries_Line_Entry_store(Request $request, WorkerEntry $workerEntry)
    {

        // dd($request->all());
        $workerEntry = WorkerEntry::find($workerEntry->id);

        // data Entry by id card
        $workerEntry->update([
            'line' => $request->line ?? $workerEntry->line,
        ]);
        return redirect()->route('workerEntries.index');
    }
    public function all_data_download()
    {
        // Group by 'floor' and 'line' correctly using a closure
        $search_worker = WorkerEntry::whereNull('old_matrix_Data_status')
            ->get();

        $data = compact('search_worker');

        // Generate the view content based on the requested format
        $viewContent = View::make('backend.library.dataEntry.export', $data)->render();

        // Set appropriate headers for the file download
        $filename = Auth::user()->name . '_' . Carbon::now()->format('Y_m_d') . '_' . time() . '.xls';
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Content-Transfer-Encoding' => 'binary',
            'Cache-Control' => 'must-revalidate',
            'Pragma' => 'public',
            'Content-Length' => strlen($viewContent)
        ];

        // Use the "binary" option in response to ensure the file is downloaded correctly
        return response()->make($viewContent, 200, $headers);
    }

    public function empty_grade_list()
    {
        //finding all the worker entries which recomanded_grade is ''


        $workerEntriesCollection = WorkerEntry::where('recomanded_grade', null)->whereNull('old_matrix_Data_status')->DISTINCT('id_card_no')
            //  ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)->orderBy('id', 'desc');
        $cacheDuration = 60 * 60 * 24 * 7; // 1 week
        $filtersApplied = false;
        $search_worker = null;

        // Define filterable parameters and their corresponding logic
        $filters = [
            'floor' => fn($value) => WorkerEntry::where('floor', $value)->pluck('id'),
            'id_card_no' => fn($value) => WorkerEntry::where('id_card_no', $value)->pluck('id'),
            'process_type' => fn($value) => WorkerSewingProcessEntry::where('sewing_process_type', $value)->pluck('worker_entry_id'),
            'process_name' => fn($value) => WorkerSewingProcessEntry::where('sewing_process_name', $value)->pluck('worker_entry_id'),
            'present_grade' => fn($value) => WorkerEntry::where('present_grade', $value)->pluck('id'),
            'recomanded_grade' => fn($value) => WorkerEntry::where('recomanded_grade', $value)->pluck('id'),
            'low_performer' => fn() => $this->filterByPerformance('low'),
            'high_performer' => fn() => $this->filterByPerformance('high'),
        ];

        // Apply filters dynamically
        foreach ($filters as $param => $callback) {
            if ($value = request($param)) {
                $filtersApplied = true;
                $cacheKey = "workerEntries_{$param}_" . ($value ?? 'default');
                $workerEntriesCollection = $this->cacheFilterResults($workerEntriesCollection, $cacheKey, $cacheDuration, fn() => $callback($value));
            }
        }

        // Fetch filtered results
        $workerEntries = $workerEntriesCollection->get();

        // Handle session storage
        if ($filtersApplied) {
            session(['search_worker' => $workerEntries]);
            $search_worker = $workerEntries;
        } elseif (request('export_format')) {
            $search_worker = session('search_worker');
        } else {
            session(['search_worker' => null]);
        }

        // Export logic
        if (strtolower(request('export_format')) === 'xlsx') {
            $search_worker = session('search_worker');

            if (!$search_worker) {
                return redirect()->route('empty_grade_list')->withErrors('First search the data then export.');
            }

            $data = compact('search_worker');
            $viewContent = View::make('backend.library.dataEntry.export', $data)->render();
            $filename = Auth::user()->name . '_' . now()->format('Y_m_d') . '_' . time() . '.xls';

            return response()->make($viewContent, 200, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        }

        return view('backend.library.dataEntry.update_grade_list', compact('workerEntries', 'search_worker'));
    }

    

    private $allowedFields = [
        'worker_entries' => [
            'floor',
            'line',
            'id_card_no',
            'employee_name_english',
            'joining_date',
            'examination_date',
            'present_grade',
            'recomanded_grade',
            'recomanded_salary'
        ],
        'worker_sewing_process_entries' => [
            'sewing_process_name',
            'sewing_process_type',
            'smv',
            'target',
            'sewing_process_avg_cycles',
            'capacity',
            'self_production',
            'achive_production',
            'efficiency',
            'necessity_of_helper',
            'rating'
        ],
        'cycle_list_logs' => [
            'start_time',
            'end_time',
            'duration',
            'rejectDataStatus'
        ]
    ];

    public function showBuilder()
    {
        return view('report-builder', [
            'fields' => $this->allowedFields
        ]);
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'fields' => 'required|array',
            'fields.*' => 'string',
            'groupBy' => 'nullable|array',
            'groupBy.*' => 'string',
            'orderBy' => 'nullable|array',
            'orderBy.*.column' => 'required|string',
            'orderBy.*.direction' => 'required|in:ASC,DESC'
        ]);

        // Validate selected fields
        $selectedFields = [];
        $tables = [];
        foreach ($request->fields as $field) {
            [$table, $column] = explode('.', $field);
            if (!isset($this->allowedFields[$table]) || !in_array($column, $this->allowedFields[$table])) {
                abort(400, 'Invalid field selection: ' . $field);
            }
            $selectedFields[] = "{$table}.{$column} as " . str_replace('.', '_', $field);
            $tables[$table] = true;
        }

        // Validate group by fields
        foreach ($request->groupBy ?? [] as $groupField) {
            [$table, $column] = explode('.', $groupField);
            if (!isset($this->allowedFields[$table]) || !in_array($column, $this->allowedFields[$table])) {
                abort(400, 'Invalid group by field: ' . $groupField);
            }
            if (!in_array($groupField, $request->fields)) {
                abort(400, 'Group by field must be in selected fields: ' . $groupField);
            }
        }

        // Validate order by fields
        foreach ($request->orderBy ?? [] as $order) {
            [$table, $column] = explode('.', $order['column']);
            if (!isset($this->allowedFields[$table]) || !in_array($column, $this->allowedFields[$table])) {
                abort(400, 'Invalid order by field: ' . $order['column']);
            }
        }

        // Build base query
        $query = DB::table('worker_entries');

        // Add joins
        if (isset($tables['worker_sewing_process_entries'])) {
            $query->join(
                'worker_sewing_process_entries',
                'worker_entries.id',
                '=',
                'worker_sewing_process_entries.worker_entry_id'
            );
        }

        if (isset($tables['cycle_list_logs'])) {
            $query->join(
                'cycle_list_logs',
                'worker_sewing_process_entries.id',
                '=',
                'cycle_list_logs.worker_sewing_process_entries_id'
            );
        }

        // Apply grouping
        if (!empty($request->groupBy)) {
            $query->groupBy($request->groupBy);
        }

        // Apply ordering
        foreach ($request->orderBy ?? [] as $order) {
            $query->orderBy($order['column'], $order['direction']);
        }

        // Execute query
        $results = $query->selectRaw(implode(', ', $selectedFields))->get();

        return response()->json([
            'fields' => array_map(fn($f) => str_replace('.', '_', $f), $request->fields),
            'rows' => $results
        ]);
    }
}
