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

class WorkerEntryController extends Controller
{

    // public function index()
    // {
    //     // //last 1 month data entry worker list order by id desc
    //     // $workerEntries = WorkerEntry::where('created_at', '>=', now()->subDays(30))->orderBy('id', 'desc')->get();
    //     // $search_worker= WorkerEntry::all();
    //     $workerEntriesCollection = WorkerEntry::where('old_matrix_Data_status ', NULL)->orderBy('id', 'desc');
    //     $search_worker = null; // Initialize the variable
    //     $workerProcessEntries = WorkerSewingProcessEntry::all();

    //     // Check if the floor field is selected
    //     if (request('floor')) {
    //         $workerEntriesCollection = $workerEntriesCollection->where('floor', request('floor'));
    //         $search_worker = $workerEntriesCollection->get();
    //         session(['search_worker' => $search_worker]);
    //     }

    //     // Check if the id_card_no field is selected
    //     if (request('id_card_no')) {
    //         $workerEntriesCollection = $workerEntriesCollection->where('id_card_no', request('id_card_no'));
    //         $search_worker = $workerEntriesCollection->get();
    //         session(['search_worker' => $search_worker]);
    //     }

    //     // Check if the process_type fields are filled
    //     if (request('process_type')) {
    //         $workerProcessEntries = WorkerSewingProcessEntry::where('sewing_process_type', request('process_type'))->get();
    //         $workerEntriesCollection = $workerEntriesCollection->whereIn('id', $workerProcessEntries->pluck('worker_entry_id'));
    //         $search_worker = $workerEntriesCollection->get();
    //         session(['search_worker' => $search_worker]);
    //     }

    //     // Check if the process_name field is filled
    //     if (request('process_name')) {
    //         $workerProcessEntries = WorkerSewingProcessEntry::where('sewing_process_name', request('process_name'))->get();
    //         // dd($workerProcessEntries);
    //         $workerEntriesCollection = $workerEntriesCollection->whereIn('id', $workerProcessEntries->pluck('worker_entry_id'));
    //         $search_worker = $workerEntriesCollection->get();
    //         session(['search_worker' => $search_worker]);
    //     }

    //     // Check if the recomanded_grade field is filled
    //     if (request('recomanded_grade')) {
    //         $workerEntriesCollection = $workerEntriesCollection->where('recomanded_grade', request('recomanded_grade'));
    //         $search_worker = $workerEntriesCollection->get();
    //         session(['search_worker' => $search_worker]);
    //     }



    //     // Check if the request low_performer field is filled start

    //     // Check if the request low_performer field is filled
    //     if (request('low_performer')) {
    //         // Assigning numerical values to grades
    //         $grades = [
    //             'D' => 1,
    //             'C' => 2,
    //             'C+' => 3,
    //             'C++' => 4,
    //             'B' => 5,
    //             'B+' => 6,
    //             'A' => 7,
    //             'A+' => 8,
    //         ];

    //         // Fetch worker entries from the database
    //         $workerCollection = WorkerEntry::all(); // Assuming WorkerEntry is your Eloquent model

    //         // Loop through each worker entry and filter based on the condition
    //         $search_worker_ids = [];
    //         foreach ($workerCollection as $key => $workerEntry) {
    //             if ($workerEntry->present_grade != null && $workerEntry->recomanded_grade != null) {
    //                 $present_grade_value = $grades[$workerEntry->present_grade];
    //                 $recommended_grade_value = $grades[$workerEntry->recomanded_grade];
    //             } else {
    //                 // Set default values if grades are not available
    //                 $present_grade_value = 9; // Assuming 9 is higher than any grade value
    //                 $recommended_grade_value = 0; // Assuming 0 is lower than any grade value
    //             }

    //             // If present grade is less than recommended grade, include in search results
    //             if ($present_grade_value > $recommended_grade_value) {
    //                 $search_worker_ids[] = $workerEntry->id;
    //             }
    //         }

    //         // Filter the workerEntriesCollection based on the collected IDs
    //         $workerEntriesCollection = $workerEntriesCollection->whereIn('id', $search_worker_ids);

    //         // dd($workerEntriesCollection);

    //         // Store the filtered worker entries in the session
    //         $search_worker = $workerEntriesCollection->get();
    //         session(['search_worker' => $search_worker]); // Store in the session
    //     }


    //     // Check if the request low_performer field is filled end

    //     // Check if the request high_performer field is filled start

    //     // Check if the request high_performer field is filled
    //     if (request('high_performer')) {
    //         // Assigning numerical values to grades
    //         $grades = [
    //             'D' => 1,
    //             'C' => 2,
    //             'C+' => 3,
    //             'C++' => 4,
    //             'B' => 5,
    //             'B+' => 6,
    //             'A' => 7,
    //             'A+' => 8,
    //         ];

    //         // Fetch worker entries from the database
    //         $workerCollection = WorkerEntry::all(); // Assuming WorkerEntry is your Eloquent model

    //         // Loop through each worker entry and filter based on the condition
    //         $search_worker_ids = [];
    //         foreach ($workerCollection as $key => $workerEntry) {
    //             if ($workerEntry->present_grade != null && $workerEntry->recomanded_grade != null) {
    //                 $present_grade_value = $grades[$workerEntry->present_grade];
    //                 $recommended_grade_value = $grades[$workerEntry->recomanded_grade];
    //             } else {
    //                 // Set default values if grades are not available
    //                 $present_grade_value = 9; // Assuming 9 is higher than any grade value
    //                 $recommended_grade_value = 0; // Assuming 0 is lower than any grade value
    //             }

    //             // If present grade is less than recommended grade, include in search results
    //             if ($present_grade_value < $recommended_grade_value) {
    //                 $search_worker_ids[] = $workerEntry->id;
    //             }
    //         }

    //         // Filter the workerEntriesCollection based on the collected IDs
    //         $workerEntriesCollection = $workerEntriesCollection->whereIn('id', $search_worker_ids);

    //         // dd($workerEntriesCollection);

    //         // Store the filtered worker entries in the session
    //         $search_worker = $workerEntriesCollection->get();
    //         session(['search_worker' => $search_worker]); // Store in the session
    //     }

    //     // Check if the request high_performer field is filled end

    //     $workerEntries = $workerEntriesCollection->get();

    //     // Check if export format is requested
    //     $format = strtolower(request('export_format'));

    //     if ($format === 'xlsx') {
    //         // Store the necessary values in the session
    //         session(['export_format' => $format]);

    //         // Retrieve the values from the session
    //         $format = session('export_format');
    //         $search_worker = session('search_worker');

    //         if ($search_worker == null) {
    //             return redirect()->route('workerEntries.index')->withErrors('First search the data then export');
    //         } else {
    //             $data = compact('search_worker');
    //             // Generate the view content based on the requested format
    //             $viewContent = View::make('backend.library.dataEntry.export', $data)->render();

    //             // Set appropriate headers for the file download
    //             $filename = Auth::user()->name . '_' . Carbon::now()->format('Y_m_d') . '_' . time() . '.xls';
    //             $headers = [
    //                 'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    //                 'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    //                 'Content-Transfer-Encoding' => 'binary',
    //                 'Cache-Control' => 'must-revalidate',
    //                 'Pragma' => 'public',
    //                 'Content-Length' => strlen($viewContent)
    //             ];

    //             // Use the "binary" option in response to ensure the file is downloaded correctly
    //             return response()->make($viewContent, 200, $headers);
    //         }
    //     }

    //     return view('backend.library.dataEntry.index', compact('workerEntries', 'search_worker'));
    // }


    public function index()
    {
        $workerEntriesCollection = WorkerEntry::whereNull('old_matrix_Data_status')->orderBy('id', 'desc');
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
                return redirect()->route('workerEntries.index')->withErrors('First search the data then export.');
            }

            $data = compact('search_worker');
            $viewContent = View::make('backend.library.dataEntry.export', $data)->render();
            $filename = Auth::user()->name . '_' . now()->format('Y_m_d') . '_' . time() . '.xls';

            return response()->make($viewContent, 200, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        }

        return view('backend.library.dataEntry.index', compact('workerEntries', 'search_worker'));
    }




    private function cacheFilterResults($query, $cacheKey, $cacheDuration, $filterCallback)
    {
        $ids = Cache::remember($cacheKey, $cacheDuration, $filterCallback);
        return $query->whereIn('id', $ids);
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
        ];

        return WorkerEntry::all()->filter(function ($workerEntry) use ($grades, $type) {
            $presentValue = $grades[$workerEntry->present_grade] ?? 9;
            $recommendedValue = $grades[$workerEntry->recomanded_grade] ?? 0;

            return $type === 'low'
                ? $presentValue > $recommendedValue
                : $presentValue < $recommendedValue;
        })->pluck('id')->toArray();
    }



    public function old_index()
    {
        // //last 1 month data entry worker list order by id desc
        // $workerEntries = WorkerEntry::where('created_at', '>=', now()->subDays(30))->orderBy('id', 'desc')->get();
        // $search_worker= WorkerEntry::all();
        $workerEntriesCollection = WorkerEntry::where('old_matrix_Data_status ', 1)->orderBy('id', 'desc');
        $search_worker = null; // Initialize the variable
        $workerProcessEntries = WorkerSewingProcessEntry::all();

        // Check if the floor field is selected
        if (request('floor')) {
            $workerEntriesCollection = $workerEntriesCollection->where('floor', request('floor'));
            $search_worker = $workerEntriesCollection->get();
            session(['search_worker' => $search_worker]);
        }

        // Check if the id_card_no field is selected
        if (request('id_card_no')) {
            $workerEntriesCollection = $workerEntriesCollection->where('id_card_no', request('id_card_no'));
            $search_worker = $workerEntriesCollection->get();
            session(['search_worker' => $search_worker]);
        }

        // Check if the process_type fields are filled
        if (request('process_type')) {
            $workerProcessEntries = WorkerSewingProcessEntry::where('sewing_process_type', request('process_type'))->get();
            $workerEntriesCollection = $workerEntriesCollection->whereIn('id', $workerProcessEntries->pluck('worker_entry_id'));
            $search_worker = $workerEntriesCollection->get();
            session(['search_worker' => $search_worker]);
        }

        // Check if the process_name field is filled
        if (request('process_name')) {
            $workerProcessEntries = WorkerSewingProcessEntry::where('sewing_process_name', request('process_name'))->get();
            // dd($workerProcessEntries);
            $workerEntriesCollection = $workerEntriesCollection->whereIn('id', $workerProcessEntries->pluck('worker_entry_id'));
            $search_worker = $workerEntriesCollection->get();
            session(['search_worker' => $search_worker]);
        }

        // Check if the recomanded_grade field is filled
        if (request('recomanded_grade')) {
            $workerEntriesCollection = $workerEntriesCollection->where('recomanded_grade', request('recomanded_grade'));
            $search_worker = $workerEntriesCollection->get();
            session(['search_worker' => $search_worker]);
        }



        // Check if the request low_performer field is filled start

        // Check if the request low_performer field is filled
        if (request('low_performer')) {
            // Assigning numerical values to grades
            $grades = [
                'D' => 1,
                'C' => 2,
                'C+' => 3,
                'C++' => 4,
                'B' => 5,
                'B+' => 6,
                'A' => 7,
                'A+' => 8,
            ];

            // Fetch worker entries from the database
            $workerCollection = WorkerEntry::all(); // Assuming WorkerEntry is your Eloquent model

            // Loop through each worker entry and filter based on the condition
            $search_worker_ids = [];
            foreach ($workerCollection as $key => $workerEntry) {
                if ($workerEntry->present_grade != null && $workerEntry->recomanded_grade != null) {
                    $present_grade_value = $grades[$workerEntry->present_grade];
                    $recommended_grade_value = $grades[$workerEntry->recomanded_grade];
                } else {
                    // Set default values if grades are not available
                    $present_grade_value = 9; // Assuming 9 is higher than any grade value
                    $recommended_grade_value = 0; // Assuming 0 is lower than any grade value
                }

                // If present grade is less than recommended grade, include in search results
                if ($present_grade_value > $recommended_grade_value) {
                    $search_worker_ids[] = $workerEntry->id;
                }
            }

            // Filter the workerEntriesCollection based on the collected IDs
            $workerEntriesCollection = $workerEntriesCollection->whereIn('id', $search_worker_ids);

            // dd($workerEntriesCollection);

            // Store the filtered worker entries in the session
            $search_worker = $workerEntriesCollection->get();
            session(['search_worker' => $search_worker]); // Store in the session
        }


        // Check if the request low_performer field is filled end

        // Check if the request high_performer field is filled start

        // Check if the request high_performer field is filled
        if (request('high_performer')) {
            // Assigning numerical values to grades
            $grades = [
                'D' => 1,
                'C' => 2,
                'C+' => 3,
                'C++' => 4,
                'B' => 5,
                'B+' => 6,
                'A' => 7,
                'A+' => 8,
            ];

            // Fetch worker entries from the database
            $workerCollection = WorkerEntry::all(); // Assuming WorkerEntry is your Eloquent model

            // Loop through each worker entry and filter based on the condition
            $search_worker_ids = [];
            foreach ($workerCollection as $key => $workerEntry) {
                if ($workerEntry->present_grade != null && $workerEntry->recomanded_grade != null) {
                    $present_grade_value = $grades[$workerEntry->present_grade];
                    $recommended_grade_value = $grades[$workerEntry->recomanded_grade];
                } else {
                    // Set default values if grades are not available
                    $present_grade_value = 9; // Assuming 9 is higher than any grade value
                    $recommended_grade_value = 0; // Assuming 0 is lower than any grade value
                }

                // If present grade is less than recommended grade, include in search results
                if ($present_grade_value < $recommended_grade_value) {
                    $search_worker_ids[] = $workerEntry->id;
                }
            }

            // Filter the workerEntriesCollection based on the collected IDs
            $workerEntriesCollection = $workerEntriesCollection->whereIn('id', $search_worker_ids);

            // dd($workerEntriesCollection);

            // Store the filtered worker entries in the session
            $search_worker = $workerEntriesCollection->get();
            session(['search_worker' => $search_worker]); // Store in the session
        }

        // Check if the request high_performer field is filled end

        $workerEntries = $workerEntriesCollection->get();

        // Check if export format is requested
        $format = strtolower(request('export_format'));

        if ($format === 'xlsx') {
            // Store the necessary values in the session
            session(['export_format' => $format]);

            // Retrieve the values from the session
            $format = session('export_format');
            $search_worker = session('search_worker');

            if ($search_worker == null) {
                return redirect()->route('workerEntries.index')->withErrors('First search the data then export');
            } else {
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
        $workerEntry = WorkerEntry::find($workerEntry->id);

        return view('backend.library.dataEntry.process_entry', compact('workerEntry'));
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


        if ($deleteSewingProcessListId->count() > 0) {
            CycleListLog::where('worker_entry_id', $request->worker_id)->whereIn('sewing_process_list_id', $deleteSewingProcessListId)->delete();
            WorkerSewingProcessEntry::where('worker_entry_id', $request->worker_id)->whereIn('sewing_process_list_id', $deleteSewingProcessListId)->delete();
        }




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


    // public function matrixData_store(Request $request)
    // {
    //     // dd($request->all());

    //     try {
    //         // Loop through the arrays and update records
    //         foreach ($request->operation_id as $key => $process_id) {
    //             $WorkerSewingProcessEntry = WorkerSewingProcessEntry::where('id', $process_id)->first();
    //             $examination_date = WorkerEntry::where('id', $request->worker_id)->first()->examination_date;
    //             // dd($examination_date);

    //             // Update The WorkerSewingProcessEntry record
    //             $WorkerSewingProcessEntry->update([
    //                 'smv' => $request->smv[$key],
    //                 'target' => $request->target[$key],
    //                 'capacity' => $request->capacity[$key],
    //                 'self_production' => $request->production_self[$key],
    //                 'achive_production' => $request->production_achive[$key],
    //                 'efficiency' => $request->efficiency[$key],
    //                 'necessity_of_helper' => $request->necessity_of_helper,
    //                 'perception_about_size' => $request->perception_about_size,
    //                 'rating' => $request->rating,
    //                 'examination_date' => $examination_date,

    //                 'dataEditBy' => Auth()->user()->name,
    //                 'dataEditDate' => now(),

    //             ]);
    //         }


    //         // Calculate the grade
    //         $Worker = WorkerEntry::where('id', $request->worker_id)->first();
    //         if ($this->calculate_grade($request->worker_id) == 'Fail') {
    //             $Worker->update([
    //                 'recomanded_grade' => $Worker->present_grade,
    //             ]);
    //         } else {
    //             $Worker->update([
    //                 'recomanded_grade' => $this->calculate_grade($request->worker_id)
    //             ]);
    //         }


    //         // Redirect or return a success response
    //         return redirect()->route('workerEntries.index')->with('success', 'Matrix Data inserted successfully!');
    //     } catch (\Exception $e) {
    //         // Handle any exceptions or validation errors here
    //         return redirect()->back()->withErrors($e->getMessage());
    //     }
    //     // return route('cyclesData_entry', $request->worker_id);
    // }


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
        $worker = WorkerEntry::where('id_card_no', 'LIKE', '%' . $id_card_no . '%')->first();


        return view('backend.library.dataEntry.create', compact('worker'));
    }

    public function workerEntrys_process_type_search(Request $request)
    {
        // dd($request->all());

        $process_type = $request->process_type;


        // Execute the query and retrieve the worker data
        if ($process_type == 'normal' || $process_type == 'semi-critical' || $process_type == 'critical') {
            $sewingProcessList = SewingProcessList::where('process_type', $process_type)->get();
        }



        // Group sewing processes by both process_type and machine_type
        $groupedProcesses = $sewingProcessList->groupBy(['process_type', 'machine_type']);



        // dd($groupedProcesses);

        $workerEntry = WorkerEntry::find($request->worker_id);
        return view('backend.library.dataEntry.process_entry', compact('workerEntry', 'groupedProcesses'));
    }

    // public function calculate_grade($worker_id)
    // {
    //     $workerEntries = DB::table('worker_sewing_process_entries')->where('worker_entry_id', $worker_id)->get();

    //     $special = DB::table('sewing_process_lists')->where('machine_type', 'SM')->pluck('id')->toArray();
    //     // dd($special);

    //     $special_process_list = $workerEntries->whereIn('sewing_process_list_id', $special)->pluck('efficiency')->toArray();

    //     // dd($special_process_list);

    //     $normal_process = [];
    //     $special_process = [];
    //     $critical_process = [];

    //     foreach ($workerEntries as $key => $workerEntry) {
    //         if ($workerEntry->sewing_process_type == 'normal') {
    //             $normal_process[] = $workerEntry->efficiency;
    //         } elseif ($workerEntry->sewing_process_type == 'critical') {
    //             $efficiency = $workerEntry->efficiency;
    //             if (in_array($efficiency, $special_process_list)) {
    //                 $special_process[] = $efficiency;
    //             } else {
    //                 $critical_process[] = $efficiency;
    //             }
    //         }
    //     }
    //     // dd($special_process);
    //     // dd($critical_process);
    //     // dd($normal_process); 
    //     if (count($special_process) > 0) {
    //         // Calculate the maximum value in the $special_process array
    //         $max_special_value = max($special_process);
    //         // dd($max_special_value);

    //         if ($max_special_value >= 110 && $max_special_value <= 119) {
    //             $grade = 'A';
    //         } elseif ($max_special_value >= 120) {
    //             $grade = 'A+';
    //         } else {
    //             $grade = 'Fail';
    //         }
    //         return $grade;
    //     }


    //     if (count($normal_process) > 0 && count($critical_process) == 0) {
    //         // Calculate grade based on normal_process values
    //         $normal_max = max($normal_process);
    //         if ($normal_max >= 50 && $normal_max < 60) {
    //             $grade = 'D';
    //         } elseif ($normal_max >= 60 && $normal_max < 70) {
    //             $grade = 'C';
    //         } elseif ($normal_max >= 70 && $normal_max < 100) {
    //             $grade = 'C+';
    //         } else {
    //             $grade = 'Fail';
    //         }
    //     } elseif (count($normal_process) > 0 && count($critical_process) > 0) {
    //         // Calculate grade based on normal_process and critical_process
    //         $normal_max = max($normal_process);
    //         $critical_max = max($critical_process);

    //         if ($normal_max >= 60 && $critical_max >= 70) {
    //             $grade = 'C++';
    //         } else {
    //             if ($normal_max >= 50 && $normal_max < 60) {
    //                 $grade = 'D';
    //             } elseif ($normal_max >= 60 && $normal_max < 70) {
    //                 $grade = 'C';
    //             } elseif ($normal_max >= 70 && $normal_max < 100) {
    //                 $grade = 'C+';
    //             } else {
    //                 $grade = 'Fail';
    //             }
    //         }
    //     } elseif (count($normal_process) == 0 && count($critical_process) > 0) {

    //         // Filter and sort the critical_process array to include values >= 70
    //         $filtered_critical_process = array_filter($critical_process, function ($value) {
    //             return $value >= 70;
    //         });



    //         // Sort and get the unique maximum values
    //         rsort($filtered_critical_process);

    //         // Calculate grade based on critical_process values
    //         $critical_max_values = array_slice($filtered_critical_process, 0, 4, true);
    //         $critical_count = count($critical_max_values);

    //         if ($critical_count < 2) {
    //             $grade = 'Fail';
    //             return $grade;
    //         }

    //         // dd($critical_max_values);

    //         if ($critical_count == 2) {
    //             $max1 = $critical_max_values[0];
    //             $max2 = $critical_max_values[1];
    //             $max3 = 0;
    //             $max4 = 0;
    //         } elseif ($critical_count == 3) {
    //             $max1 = $critical_max_values[0];
    //             $max2 = $critical_max_values[1];
    //             $max3 = $critical_max_values[2];
    //             $max4 = 0;
    //         } elseif ($critical_count == 4) {
    //             $max1 = $critical_max_values[0];
    //             $max2 = $critical_max_values[1];
    //             $max3 = $critical_max_values[2];
    //             $max4 = $critical_max_values[3];
    //         }

    //         if ($max1 >= 70 && $max2 >= 70 && $max1 <= 99 && $max2 <= 74) {
    //             $grade = 'B';
    //         } elseif ($max1 >= 75 && $max2 >= 75 && $max1 <= 99 && $max2 <= 99 && $max3 <= 80 || $max1 >= 75 && $max2 >= 75 && $max1 <= 99 && $max2 <= 99 && $max3 == 0) {
    //             $grade = 'B+';
    //         } elseif ($max1 >= 85 && $max2 >= 85 && $max3 >= 85 && $max1 <= 99 && $max2 <= 99 && $max3 <= 99 && $max4 <= 80 || $max1 >= 85 && $max2 >= 85 && $max3 >= 85 && $max1 <= 99 && $max2 <= 99 && $max3 <= 99 && $max4 == 0) {
    //             $grade = 'A';
    //         } elseif ($max1 >= 80 && $max2 >= 80 && $max3 >= 80 && $max4 >= 80 && $max1 <= 99 && $max2 <= 99 && $max3 <= 99 && $max4 <= 99) {
    //             $grade = 'A+';
    //         }
    //     } else {
    //         $grade = 'Fail';
    //     }

    //     return $grade;
    // }
    // public function calculate_grade($worker_id)
    // {
    //     // Fetch worker entries and special process IDs
    //     $workerEntries = DB::table('worker_sewing_process_entries')->where('worker_entry_id', $worker_id)->get();
    //     $special = DB::table('sewing_process_lists')->where('machine_type', 'SM')->pluck('id')->toArray();
    //     $special_process_list = $workerEntries->whereIn('sewing_process_list_id', $special)->pluck('efficiency')->toArray();

    //     // Initialize arrays for processes
    //     $normal_process = [];
    //     $semi_critical_process = [];
    //     $critical_process = [];

    //     // Categorize worker entries
    //     foreach ($workerEntries as $workerEntry) {
    //         if ($workerEntry->sewing_process_type == 'normal') {
    //             $normal_process[] = $workerEntry->efficiency;
    //         } elseif ($workerEntry->sewing_process_type == 'semi-critical') {
    //             $semi_critical_process[] = $workerEntry->efficiency;
    //         } elseif ($workerEntry->sewing_process_type == 'critical') {
    //             $critical_process[] = $workerEntry->efficiency;
    //         }
    //     }

    //     // Define grading table
    //     $grading_table = [
    //         [
    //             'grade' => 'D',
    //             'max_mc' => 1,
    //             'status' => 'normal',
    //             'min_count' => 2,
    //             'efficiency_min' => 0,
    //             'efficiency_max' => 59
    //         ],
    //         ['grade' => 'C', 'max_mc' => 1, 'status' => 'normal', 'min_count' => 2, 'efficiency_min' => 60, 'efficiency_max' => 69],
    //         ['grade' => 'C+', 'max_mc' => 1, 'status' => 'normal', 'min_count' => 3, 'efficiency_min' => 70, 'efficiency_max' => 79],
    //         ['grade' => 'C++', 'max_mc' => 1, 'status' => 'normal', 'min_count' => 3, 'efficiency_min' => 80, 'efficiency_max' => 100],
    //         ['grade' => 'B', 'max_mc' => 2, 'status' => 'semi-critical', 'min_count' => 2, 'efficiency_min' => 70, 'efficiency_max' => 79],
    //         ['grade' => 'B+', 'max_mc' => 2, 'status' => 'semi-critical', 'min_count' => 4, 'efficiency_min' => 80, 'efficiency_max' => 100],
    //         ['grade' => 'A', 'max_mc' => 3, 'status' => 'critical', 'min_count' => 2, 'efficiency_min' => 80, 'efficiency_max' => 100],
    //         [
    //             'grade' => 'A+',
    //             'max_mc' => 4,
    //             'status' => 'critical',
    //             'min_count' => 5,
    //             'efficiency_min' => 80,
    //             'efficiency_max' => 100
    //         ],
    //     ];

    //     // Iterate over the grading table
    //     foreach ($grading_table as $row) {
    //         $process_array = match ($row['status']) {
    //             'normal' => $normal_process,
    //             'semi-critical' => $semi_critical_process,
    //             'critical' => $critical_process,
    //         };

    //         // Filter the processes based on efficiency range
    //         $filtered_process = array_filter($process_array, function ($efficiency) use ($row) {
    //             return $efficiency >= $row['efficiency_min'] && $efficiency <= $row['efficiency_max'];
    //         });

    //         // If process count meets the minimum requirement and machine capability is valid, assign grade
    //         if (count($filtered_process) >= $row['min_count']) {
    //             return $row['grade'];
    //         }
    //     }

    //     // If no grade is assigned, dynamically attempt to recheck against other entries
    //     foreach ($grading_table as $row) {
    //         $max_values = [];
    //         $process_array = match ($row['status']) {
    //             'normal' => $normal_process,
    //             'semi-critical' => $semi_critical_process,
    //             'critical' => $critical_process,
    //         };

    //         $filtered_process = array_filter($process_array, function ($efficiency) use ($row) {
    //             return $efficiency >= $row['efficiency_min'];
    //         });

    //         // Dynamically work with the maximum values
    //         $max_values = array_slice(array_reverse(array_unique($filtered_process)), 0, $row['min_count']);
    //         if (count($max_values) >= $row['min_count']) {
    //             return $row['grade'];
    //         }
    //     }

    //     // Default to fail if no grade is assigned
    //     return 'Fail';
    // }

    // // public function calculate_grade($worker_id)
    // //     {
    // //     // Step 1: Fetch worker's sewing process entries
    // //     $workerEntries = DB::table('worker_sewing_process_entries')
    // //         ->where('worker_entry_id', $worker_id)
    // //         ->get();

    // //     // Fetch Special Process IDs (Flat Lock and Overlock operations)
    // //     $special_process_ids = DB::table('sewing_process_lists')
    // //         ->where('machine_type', 'SM')
    // //         ->pluck('id')
    // //         ->toArray();

    // //     // Initialize process arrays
    // //     $normal_process = [];
    // //     $semi_critical_process = [];
    // //     $critical_process = [];

    // //     // Step 2: Categorize entries based on process type
    // //     foreach ($workerEntries as $workerEntry) {
    // //         $efficiency = $workerEntry->efficiency;

    // //         if ($workerEntry->sewing_process_type == 'normal') {
    // //             $normal_process[] = $efficiency;
    // //         } elseif ($workerEntry->sewing_process_type == 'critical') {
    // //             $critical_process[] = $efficiency;
    // //         } elseif ($workerEntry->sewing_process_type == 'semi-critical') {
    // //             $semi_critical_process[] = $efficiency;
    // //         }
    // //     }

    // //     // Step 3: Calculate grades based on table structure

    // //     //first sort the array in descending order to get the maximum value then check the condition
    // //     rsort($critical_process);
    // //     rsort($semi_critical_process);
    // //     rsort($normal_process);

    // //     // **Grade A+**: Critical Process, Minimum 5 Processes, Efficiency >= 80%
    // //     if (count($critical_process) >= 5 && min($critical_process) >= 80) {
    // //         if ($this->has_flatlock_and_overlock($workerEntries, $special_process_ids)) {
    // //             return 'A+';
    // //         }
    // //     }

    // //     // **Grade A**: Critical Process, 2-4 Processes, Efficiency >= 80%
    // //     if (
    // //         count($critical_process) >= 2 && count($critical_process) <= 4 && min($critical_process) >= 80
    // //     ) {
    // //         return 'A';
    // //     }

    // //     // **Grade B+**: Semi-Critical Process, Minimum 4 Processes, Efficiency >= 80%
    // //     if (count($semi_critical_process) >= 4 && min($semi_critical_process) >= 80) {
    // //         return 'B+';
    // //     }

    // //     // **Grade B**: Semi-Critical Process, 2-3 Processes, Efficiency 70%-79%
    // //     if (
    // //         count($semi_critical_process) >= 2 && count($semi_critical_process) <= 3
    // //     ) {
    // //         if (min($semi_critical_process) >= 70 && max($semi_critical_process) < 80) {
    // //             return 'B';
    // //         }
    // //     }

    // //     // **Grade C++**: Normal Process, 2-3 Processes, Efficiency 80%-100%
    // //     if (count($normal_process) >= 2 && count($normal_process) <= 3 && min($normal_process) >= 80) {
    // //         return 'C++';
    // //     }

    // //     // **Grade C+**: Normal Process, 2-3 Processes, Efficiency 70%-79%
    // //     if (count($normal_process) >= 2 && count($normal_process) <= 3) {
    // //         if (min($normal_process) >= 70 && max($normal_process) < 80) {
    // //             return 'C+';
    // //         }
    // //     }

    // //     // **Grade C**: Normal Process, 2-3 Processes, Efficiency 60%-69%
    // //     if (count($normal_process) >= 2 && count($normal_process) <= 3) {
    // //         if (min($normal_process) >= 60 && max($normal_process) < 70) {
    // //             return 'C';
    // //         }
    // //     }

    // //     // **Grade D**: Normal Process, 2-3 Processes, Efficiency Below 60%
    // //     if (
    // //         count($normal_process) >= 2 && count($normal_process) <= 3 && max($normal_process) < 60
    // //     ) {
    // //         return 'D';
    // //     }

    // //     // Default case: Fail
    // //     return 'Fail';
    // // }

    // // /**
    // //  * Check if Flat Lock and Overlock processes are present
    // //  */
    // // private function has_flatlock_and_overlock($entries, $special_process_ids)
    // // {
    // //     $process_ids = $entries->pluck('sewing_process_list_id')->toArray();
    // //     $flatlock = in_array($special_process_ids[0], $process_ids); // Flat Lock
    // //     $overlock = in_array($special_process_ids[1], $process_ids); // Overlock

    // //     return $flatlock && $overlock;
    // // }


    // public function calculate_grade($worker_id)
    // {
    //     // Fetch worker entries and categorize them
    //     $workerEntries = DB::table('worker_sewing_process_entries')->where(
    //         'worker_entry_id',
    //         $worker_id
    //     )->get();

    //     $normal_process = [];
    //     $semi_critical_process = [];
    //     $critical_process = [];

    //     foreach ($workerEntries as $workerEntry) {
    //         if ($workerEntry->sewing_process_type == 'normal') {
    //             $normal_process[] = $workerEntry->efficiency;
    //         } elseif ($workerEntry->sewing_process_type == 'semi-critical') {
    //             $semi_critical_process[] = $workerEntry->efficiency;
    //         } elseif ($workerEntry->sewing_process_type == 'critical') {
    //             $critical_process[] = $workerEntry->efficiency;
    //         }
    //     }

    //     // Sort processes in descending order
    //     rsort($normal_process);
    //     rsort($semi_critical_process);
    //     rsort($critical_process);

    //     // Define grading table
    //     $grading_table = [
    //         ['grade' => 'C',   'max_mc' => 1, 'status' => 'normal', 'min_count' => 2, 'efficiency_min' => 60, 'efficiency_max' => 69, 'salary_range' => '13550-13650 Tk'],
    //         [
    //             'grade' => 'C+',
    //             'max_mc' => 1,
    //             'status' => 'normal',
    //             'min_count' => 2,
    //             'efficiency_min' => 70,
    //             'efficiency_max' => 79,
    //             'salary_range' => '13700-13800 Tk'
    //         ],
    //         [
    //             'grade' => 'C++',
    //             'max_mc' => 1,
    //             'status' => 'normal',
    //             'min_count' => 2,
    //             'efficiency_min' => 80,
    //             'efficiency_max' => PHP_INT_MAX,
    //             'salary_range' => '13850-14000 Tk'
    //         ],
    //         [
    //             'grade' => 'B',
    //             'max_mc' => 2,
    //             'status' => 'semi-critical',
    //             'min_count' => 2,
    //             'efficiency_min' => 70,
    //             'efficiency_max' => 79,
    //             'salary_range' => '14100-14300 Tk'
    //         ],
    //         ['grade' => 'B+',  'max_mc' => 2, 'status' => 'semi-critical', 'min_count' => 4, 'efficiency_min' => 80, 'efficiency_max' => PHP_INT_MAX, 'salary_range' => '14350-14550 Tk'],
    //         ['grade' => 'A',   'max_mc' => 3, 'status' => 'critical', 'min_count' => 2, 'efficiency_min' => 70, 'efficiency_max' => 79, 'salary_range' => '14600-15000 Tk'],
    //         ['grade' => 'A+',  'max_mc' => 4, 'status' => 'critical', 'min_count' => 5, 'efficiency_min' => 80, 'efficiency_max' => PHP_INT_MAX, 'salary_range' => '15100-15300 Tk'],
    //     ];

    //     // Iterate over the grading table
    //     foreach ($grading_table as $row) {
    //         $process_array = match ($row['status']) {
    //             'normal' => $normal_process,
    //             'semi-critical' => $semi_critical_process,
    //             'critical' => $critical_process,
    //         };

    //         // Filter process array based on efficiency range
    //         $filtered_process = array_filter($process_array, function ($efficiency) use ($row) {
    //             return $efficiency >= $row['efficiency_min'] && $efficiency <= $row['efficiency_max'];
    //         });

    //         // Check if process count meets the minimum requirement
    //         if (count($filtered_process) >= $row['min_count']) {
    //             return [
    //                 'grade' => $row['grade'],
    //                 'salary_range' => $row['salary_range'],
    //             ];
    //         }
    //     }

    //     // Default return for "Fail"
    //     return [
    //         'grade' => 'Fail',
    //         'salary_range' => 'N/A',
    //     ];
    // }
    // public function calculate_grade($worker_id)
    // {
    //     // Fetch worker entries and categorize them
    //     $workerEntries = DB::table('worker_sewing_process_entries')
    //     ->where('worker_entry_id', $worker_id)
    //     ->get();

    //     $normal_process = [];
    //     $semi_critical_process = [];
    //     $critical_process = [];

    //     foreach ($workerEntries as $workerEntry) {
    //         if ($workerEntry->sewing_process_type === 'normal') {
    //             $normal_process[] = $workerEntry->efficiency;
    //         } elseif ($workerEntry->sewing_process_type === 'semi-critical') {
    //             $semi_critical_process[] = $workerEntry->efficiency;
    //         } elseif ($workerEntry->sewing_process_type === 'critical') {
    //             $critical_process[] = $workerEntry->efficiency;
    //         }
    //     }

    //     // Sort processes in descending order
    //     rsort($normal_process);
    //     rsort($semi_critical_process);
    //     rsort($critical_process);

    //     // Define grading table
    //     $grading_table = [
    //         ['grade' => 'C',   'max_mc' => 1, 'status' => 'normal', 'min_count' => 2, 'efficiency_min' => 60, 'efficiency_max' => 69, 'salary_range' => '13550-13650 Tk'],
    //         ['grade' => 'C+',  'max_mc' => 1, 'status' => 'normal', 'min_count' => 2, 'efficiency_min' => 70, 'efficiency_max' => 79, 'salary_range' => '13700-13800 Tk'],
    //         ['grade' => 'C++', 'max_mc' => 1, 'status' => 'normal', 'min_count' => 2, 'efficiency_min' => 80, 'efficiency_max' => PHP_INT_MAX, 'salary_range' => '13850-14000 Tk'],
    //         ['grade' => 'B',   'max_mc' => 2, 'status' => 'semi-critical', 'min_count' => 2, 'efficiency_min' => 70, 'efficiency_max' => 79, 'salary_range' => '14100-14300 Tk'],
    //         ['grade' => 'B+',  'max_mc' => 2, 'status' => 'semi-critical', 'min_count' => 4, 'efficiency_min' => 80, 'efficiency_max' => PHP_INT_MAX, 'salary_range' => '14350-14550 Tk'],
    //         ['grade' => 'A',   'max_mc' => 3, 'status' => 'critical', 'min_count' => 2, 'efficiency_min' => 70, 'efficiency_max' => 79, 'salary_range' => '14600-15000 Tk'],
    //         ['grade' => 'A+',  'max_mc' => 4, 'status' => 'critical', 'min_count' => 5, 'efficiency_min' => 80, 'efficiency_max' => PHP_INT_MAX, 'salary_range' => '15100-15300 Tk'],
    //     ];

    //     // Iterate over the grading table
    //     foreach ($grading_table as $row) {
    //         $process_array = match ($row['status']) {
    //             'normal' => $normal_process,
    //             'semi-critical' => $semi_critical_process,
    //             'critical' => $critical_process,
    //         };

    //         // Filter process array based on efficiency range
    //         $filtered_process = array_filter($process_array, function ($efficiency) use ($row) {
    //             return $efficiency >= $row['efficiency_min'] && $efficiency <= $row['efficiency_max'];
    //         });

    //         // Check if process count meets the minimum requirement
    //         if (count($filtered_process) >= $row['min_count']) {
    //             $efficiency = max($filtered_process); // Take the highest efficiency in the filtered array

    //             // Calculate salary dynamically
    //             $salary_range = explode('-', str_replace(' Tk', '', $row['salary_range']));
    //             $salary_min = (float)$salary_range[0];
    //             $salary_max = (float)$salary_range[1];

    //             $salary = $salary_min + (($efficiency - $row['efficiency_min']) / ($row['efficiency_max'] - $row['efficiency_min'])) * ($salary_max - $salary_min);
    //             $salary = round($salary, 2); // Round to 2 decimal places

    //             return [
    //                 'grade' => $row['grade'],
    //                 'salary_range' => "{$salary} Tk",
    //             ];
    //         }
    //     }

    //     // Default return for "Fail"
    //     return [
    //         'grade' => 'Fail',
    //         'salary_range' => 'N/A',
    //     ];
    // }

    // public function calculate_grade($worker_id)
    // {
    //     // Fetch worker entries and categorize them
    //     $workerEntries = DB::table('worker_sewing_process_entries')
    //         ->where('worker_entry_id', $worker_id)
    //         ->get();

    //     $normal_process = [];
    //     $semi_critical_process = [];
    //     $critical_process = [];

    //     foreach ($workerEntries as $workerEntry) {
    //         if ($workerEntry->sewing_process_type === 'normal') {
    //             $normal_process[] = $workerEntry->efficiency;
    //         } elseif ($workerEntry->sewing_process_type === 'semi-critical') {
    //             $semi_critical_process[] = $workerEntry->efficiency;
    //         } elseif ($workerEntry->sewing_process_type === 'critical') {
    //             $critical_process[] = $workerEntry->efficiency;
    //         }
    //     }

    //     // Sort processes in descending order
    //     rsort($normal_process);
    //     rsort($semi_critical_process);
    //     rsort($critical_process);

    //     // Define grading table
    //     $grading_table = [
    //         [
    //             'grade' => 'C',
    //             'max_mc' => 1,
    //             'status' => 'normal',
    //             'min_count' => 2,
    //             'efficiency_min' => 60,
    //             'efficiency_max' => 69,
    //             'salary_range' => '13550-13650 Tk'
    //         ],
    //         ['grade' => 'C+',  'max_mc' => 1, 'status' => 'normal', 'min_count' => 2, 'efficiency_min' => 70, 'efficiency_max' => 79, 'salary_range' => '13700-13800 Tk'],
    //         ['grade' => 'C++', 'max_mc' => 1, 'status' => 'normal', 'min_count' => 2, 'efficiency_min' => 80, 'efficiency_max' => 100, 'salary_range' => '13850-14000 Tk'], // Adjusted to 100
    //         [
    //             'grade' => 'B',
    //             'max_mc' => 2,
    //             'status' => 'semi-critical',
    //             'min_count' => 2,
    //             'efficiency_min' => 70,
    //             'efficiency_max' => 79,
    //             'salary_range' => '14100-14300 Tk'
    //         ],
    //         ['grade' => 'B+',  'max_mc' => 2, 'status' => 'semi-critical', 'min_count' => 4, 'efficiency_min' => 80, 'efficiency_max' => 100, 'salary_range' => '14350-14550 Tk'], // Adjusted to 100
    //         ['grade' => 'A',   'max_mc' => 3, 'status' => 'critical', 'min_count' => 2, 'efficiency_min' => 70, 'efficiency_max' => 79, 'salary_range' => '14600-15000 Tk'],
    //         ['grade' => 'A+',  'max_mc' => 4, 'status' => 'critical', 'min_count' => 5, 'efficiency_min' => 80, 'efficiency_max' => 100, 'salary_range' => '15100-15300 Tk'], // Adjusted to 100
    //     ];

    //     // Iterate over the grading table
    //     foreach ($grading_table as $row) {
    //         $process_array = match ($row['status']) {
    //             'normal' => $normal_process,
    //             'semi-critical' => $semi_critical_process,
    //             'critical' => $critical_process,
    //         };

    //         // Filter process array based on efficiency range
    //         $filtered_process = array_filter($process_array, function ($efficiency) use ($row) {
    //             $efficiency_max = $row['efficiency_max'] === PHP_INT_MAX ? 100 : $row['efficiency_max'];
    //             return $efficiency >= $row['efficiency_min'] && $efficiency <= $efficiency_max;
    //         });

    //         // Check if process count meets the minimum requirement
    //         if (
    //             count($filtered_process) >= $row['min_count']
    //         ) {
    //             $avg_efficiency = array_sum($filtered_process) / count($filtered_process); // Calculate average efficiency
    //             $efficiency_max = $row['efficiency_max'] === PHP_INT_MAX ? 100 : $row['efficiency_max'];

    //             // Calculate salary dynamically
    //             $salary_range = explode('-', str_replace(' Tk', '', $row['salary_range']));
    //             $salary_min = (float)$salary_range[0];
    //             $salary_max = (float)$salary_range[1];

    //             $salary = $salary_min + (($avg_efficiency - $row['efficiency_min']) / ($efficiency_max - $row['efficiency_min'])) * ($salary_max - $salary_min);
    //             $salary = round($salary, 2); // Round to 2 decimal places

    //             return [
    //                 'grade' => $row['grade'],
    //                 'salary_range' => "{$salary}",
    //             ];
    //         }
    //     }

    //     // Default return for "Fail"
    //     return [
    //         'grade' => 'Fail',
    //         'salary_range' => 'N/A',
    //     ];
    // }

    /* new method start
     */


    // public function calculate_grade($worker_id)
    // {
    //     // Fetch worker entries and categorize them
    //     $workerEntries = DB::table('worker_sewing_process_entries')
    //     ->where('worker_entry_id', $worker_id)
    //         ->get();

    //     $normal_process = [];
    //     $semi_critical_process = [];
    //     $critical_process = [];

    //     foreach ($workerEntries as $workerEntry) {
    //         if ($workerEntry->sewing_process_type === 'normal') {
    //             $normal_process[] = $workerEntry->efficiency;
    //         } elseif ($workerEntry->sewing_process_type === 'semi-critical') {
    //             $semi_critical_process[] = $workerEntry->efficiency;
    //         } elseif ($workerEntry->sewing_process_type === 'critical') {
    //             $critical_process[] = $workerEntry->efficiency;
    //         }
    //     }

    //     // Sort processes in descending order
    //     rsort($normal_process);
    //     rsort($semi_critical_process);
    //     rsort($critical_process);

    //     // Define grading table
    //     $grading_table = [
    //         ['grade' => 'C', 'max_mc' => 1, 'status' => 'normal', 'min_count' => 2, 'efficiency_min' => 60, 'efficiency_max' => 69, 'salary_range' => '13550-13650 Tk'],
    //         ['grade' => 'C+', 'max_mc' => 1, 'status' => 'normal', 'min_count' => 2, 'efficiency_min' => 70, 'efficiency_max' => 79, 'salary_range' => '13700-13800 Tk'],
    //         ['grade' => 'C++', 'max_mc' => 1, 'status' => 'normal', 'min_count' => 2, 'efficiency_min' => 80, 'efficiency_max' => 100, 'salary_range' => '13850-14000 Tk'],
    //         ['grade' => 'B', 'max_mc' => 2, 'status' => 'semi-critical', 'min_count' => 2, 'efficiency_min' => 70, 'efficiency_max' => 79, 'salary_range' => '14100-14300 Tk'],
    //         ['grade' => 'B+', 'max_mc' => 2, 'status' => 'semi-critical', 'min_count' => 4, 'efficiency_min' => 80, 'efficiency_max' => 100, 'salary_range' => '14350-14550 Tk'],
    //         [
    //             'grade' => 'A',
    //             'max_mc' => 3,
    //             'status' => 'critical',
    //             'min_count' => 2,
    //             'efficiency_min' => 70,
    //             'efficiency_max' => 79,
    //             'salary_range' => '14600-15000 Tk',
    //             'required_ids' => [79, 56, 60, 59, 75, 72, 73, 61, 74],
    //             'min_required_ids' => 2,
    //         ],
    //         [
    //             'grade' => 'A+',
    //             'max_mc' => 4,
    //             'status' => 'critical',
    //             'min_count' => 5,
    //             'efficiency_min' => 80,
    //             'efficiency_max' => 100,
    //             'salary_range' => '15100-15300 Tk',
    //             'required_ids' => [56, 60, 59, 75, 72, 73],
    //             'min_required_ids' => 4,
    //         ],
    //     ];

    //     // Iterate over the grading table
    //     foreach ($grading_table as $row) {
    //         $process_array = match ($row['status']) {
    //             'normal' => $normal_process,
    //             'semi-critical' => $semi_critical_process,
    //             'critical' => $critical_process,
    //         };

    //         // Filter process array based on efficiency range
    //         $filtered_process = array_filter($process_array, function ($efficiency) use ($row) {
    //             $efficiency_max = $row['efficiency_max'] === PHP_INT_MAX ? 100 : $row['efficiency_max'];
    //             return $efficiency >= $row['efficiency_min'] && $efficiency <= $efficiency_max;
    //         });

    //         // Check required process IDs for A and A+ grades
    //         if (in_array($row['grade'], ['A', 'A+'])) {
    //             if (!$this->has_required_process_ids($workerEntries, $row['required_ids'], $row['min_required_ids'])) {
    //                 continue;
    //             }

    //             // Check for Flat Lock and Overlock processes for A+
    //             if ($row['grade'] === 'A+' && !$this->has_flatlock_and_overlock($workerEntries)) {
    //                 continue;
    //             }
    //         }

    //         // Check if process count meets the minimum requirement
    //         if (count($filtered_process) >= $row['min_count']) {
    //             $avg_efficiency = array_sum($filtered_process) / count($filtered_process); // Calculate average efficiency
    //             $efficiency_max = $row['efficiency_max'] === PHP_INT_MAX ? 100 : $row['efficiency_max'];

    //             // Calculate salary dynamically
    //             $salary_range = explode('-', str_replace(' Tk', '', $row['salary_range']));
    //             $salary_min = (float)$salary_range[0];
    //             $salary_max = (float)$salary_range[1];

    //             $salary = $salary_min + (($avg_efficiency - $row['efficiency_min']) / ($efficiency_max - $row['efficiency_min'])) * ($salary_max - $salary_min);
    //             $salary = round($salary, 2); // Round to 2 decimal places

    //             return [
    //                 'grade' => $row['grade'],
    //                 'salary_range' => "{$salary} Tk",
    //             ];
    //         }
    //     }

    //     // Default return for "Fail"
    //     return [
    //         'grade' => 'Fail',
    //         'salary_range' => 'N/A',
    //     ];
    // }

    // /**
    //  * Check if required sewing_process_list_ids are present.
    //  */
    // private function has_required_process_ids($entries, $required_ids, $min_count)
    // {
    //     $process_ids = $entries->pluck('sewing_process_list_id')->toArray();
    //     $matching_ids = array_intersect($process_ids, $required_ids);

    //     return count($matching_ids) >= $min_count;
    // }

    // /**
    //  * Check if Flat Lock and Overlock processes are present.
    //  */
    // private function has_flatlock_and_overlock($entries)
    // {
    //     $process_ids = $entries->pluck('sewing_process_list_id')->toArray();
    //     $flatlock = in_array('F/L', $process_ids); // Flat Lock
    //     $overlock = in_array('OL', $process_ids); // Overlock

    //     return $flatlock && $overlock;
    // }

    public function calculate_grade($worker_id)
    {
        // Fetch worker entries and categorize them
        $workerEntries = DB::table('worker_sewing_process_entries')
        ->where('worker_entry_id', $worker_id)
            ->get();

        $normal_process = [];
        $semi_critical_process = [];
        $critical_process = [];

        foreach ($workerEntries as $workerEntry) {
            if ($workerEntry->sewing_process_type === 'normal') {
                $normal_process[] = $workerEntry->efficiency;
            } elseif ($workerEntry->sewing_process_type === 'semi-critical') {
                $semi_critical_process[] = $workerEntry->efficiency;
            } elseif ($workerEntry->sewing_process_type === 'critical') {
                $critical_process[] = $workerEntry->efficiency;
            }
        }

        // Sort processes in descending order
        rsort($normal_process);
        rsort($semi_critical_process);
        rsort($critical_process);

        // Define grading table
        $grading_table = [
            ['grade' => 'C', 'max_mc' => 1, 'status' => 'normal', 'min_count' => 2, 'efficiency_min' => 60, 'efficiency_max' => 69, 'salary_range' => '13550-13650 Tk'],
            ['grade' => 'C+', 'max_mc' => 1, 'status' => 'normal', 'min_count' => 2, 'efficiency_min' => 70, 'efficiency_max' => 79, 'salary_range' => '13700-13800 Tk'],
            ['grade' => 'C++', 'max_mc' => 1, 'status' => 'normal', 'min_count' => 2, 'efficiency_min' => 80, 'efficiency_max' => 100, 'salary_range' => '13850-14000 Tk'],
            ['grade' => 'B', 'max_mc' => 2, 'status' => 'semi-critical', 'min_count' => 2, 'efficiency_min' => 70, 'efficiency_max' => 79, 'salary_range' => '14100-14300 Tk'],
            ['grade' => 'B+', 'max_mc' => 2, 'status' => 'semi-critical', 'min_count' => 4, 'efficiency_min' => 80, 'efficiency_max' => 100, 'salary_range' => '14350-14550 Tk'],
            [
                'grade' => 'A',
                'max_mc' => 3,
                'status' => 'critical',
                'min_count' => 2,
                'efficiency_min' => 70,
                'efficiency_max' => 79,
                'salary_range' => '14600-15000 Tk',
                'required_ids' => [79, 56, 60, 59, 75, 72, 73, 61, 74],
                'min_required_ids' => 2,
            ],
            [
                'grade' => 'A+',
                'max_mc' => 4,
                'status' => 'critical',
                'min_count' => 5,
                'efficiency_min' => 80,
                'efficiency_max' => 100,
                'salary_range' => '15100-15300 Tk',
                'required_ids' => [56, 60, 59, 75, 72, 73],
                'min_required_ids' => 4,
            ],
        ];

        // Iterate over the grading table (first pass)
        foreach ($grading_table as $row) {
            $process_array = match ($row['status']) {
                'normal' => $normal_process,
                'semi-critical' => $semi_critical_process,
                'critical' => $critical_process,
            };

            $filtered_process = array_filter($process_array, function ($efficiency) use ($row) {
                $efficiency_max = $row['efficiency_max'] === PHP_INT_MAX ? 100 : $row['efficiency_max'];
                return $efficiency >= $row['efficiency_min'] && $efficiency <= $efficiency_max;
            });

            if (in_array($row['grade'], ['A', 'A+'])) {
                if (!$this->has_required_process_ids($workerEntries, $row['required_ids'], $row['min_required_ids'])) {
                    continue;
                }

                if ($row['grade'] === 'A+' && !$this->has_flatlock_and_overlock($workerEntries)) {
                    continue;
                }
            }

            if (count($filtered_process) >= $row['min_count']) {
                return $this->calculate_salary($filtered_process, $row);
            }
        }

        // Second pass: find the closest match dynamically
        $best_match = null;
        $highest_efficiency = 0;

        foreach ($grading_table as $row) {
            $process_array = match ($row['status']) {
                'normal' => $normal_process,
                'semi-critical' => $semi_critical_process,
                'critical' => $critical_process,
            };

            $filtered_process = array_filter($process_array, function ($efficiency) use ($row) {
                $efficiency_max = $row['efficiency_max'] === PHP_INT_MAX ? 100 : $row['efficiency_max'];
                return $efficiency >= $row['efficiency_min'] && $efficiency <= $efficiency_max;
            });

            if (count($filtered_process) >= $row['min_count']) {
                $avg_efficiency = array_sum($filtered_process) / count($filtered_process);
                if ($avg_efficiency > $highest_efficiency) {
                    $highest_efficiency = $avg_efficiency;
                    $best_match = $row;
                }
            }
        }

        if ($best_match) {
            return $this->calculate_salary($filtered_process, $best_match);
        }

        // Default return for "Fail"
        return [
            'grade' => 'Fail',
            'salary_range' => 'N/A',
        ];
    }

    /**
     * Helper function to calculate salary for a given grade.
     */
    private function calculate_salary($filtered_process, $row)
    {
        $avg_efficiency = array_sum($filtered_process) / count($filtered_process);
        $efficiency_max = $row['efficiency_max'] === PHP_INT_MAX ? 100 : $row['efficiency_max'];

        $salary_range = explode('-', str_replace(' Tk', '', $row['salary_range']));
        $salary_min = (float)$salary_range[0];
        $salary_max = (float)$salary_range[1];

        $salary = $salary_min + (($avg_efficiency - $row['efficiency_min']) / ($efficiency_max - $row['efficiency_min'])) * ($salary_max - $salary_min);
        $salary = round($salary, 2);

        return [
            'grade' => $row['grade'],
            'salary_range' => "{$salary}",
        ];
    }

    /**
     * Check if required sewing_process_list_ids are present.
     */
    private function has_required_process_ids($entries, $required_ids, $min_count)
    {
        $process_ids = $entries->pluck('sewing_process_list_id')->toArray();
        $matching_ids = array_intersect($process_ids, $required_ids);

        return count($matching_ids) >= $min_count;
    }

    /**
     * Check if Flat Lock and Overlock processes are present.
     */
    private function has_flatlock_and_overlock($entries)
    {
        $process_ids = $entries->pluck('sewing_process_list_id')->toArray();
        $flatlock = in_array('F/L', $process_ids);
        $overlock = in_array('OL', $process_ids);

        return $flatlock && $overlock;
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
}
