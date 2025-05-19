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

