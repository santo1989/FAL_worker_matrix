<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Operator Assessment Sheet List
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Operator Assessment Sheet </x-slot>

            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('workerEntries.index') }}">Operator Assessment Sheet</a></li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            @if (is_null($workerEntries) || empty($workerEntries))
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <h1 class="text-danger"> <strong>Currently No Information Available!</strong> </h1>
                    </div>
                </div>
            @else
                @if (session('message'))
                    <div class="alert alert-success">
                        <span class="close" data-dismiss="alert">&times;</span>
                        <strong>{{ session('message') }}.</strong>
                    </div>
                @endif

                <div class="container-fluid">
                    <div class="card" style="overflow-x: auto; overflow-y: auto;">
                        <div class="card-header">
                            <form method="GET" action="{{ route('empty_grade_list') }}">
                                @csrf
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <table
                                                class="table table-borderless table-responsive text-center text-dark font-weight-bold">
                                                <tr>


                                                    <div class="form-group">
                                                        <td>Floor:</td>
                                                        <td>
                                                            @php
                                                                $floor = DB::table('worker_entries')
                                                                    ->distinct()
                                                                    ->pluck('floor')
                                                                    ->toArray();
                                                                //    dd($floor);
                                                                //    die();
                                                            @endphp
                                                            <select name="floor" id="floor" class="form-control">
                                                                <option value="">Select Floor</option>
                                                                @foreach ($floor as $item)
                                                                    <option value="{{ $item }}">
                                                                        {{ $item }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </div>
                                                    <div class="form-group">
                                                        <td>ID Card No:</td>
                                                        <td>
                                                            @php
                                                                $id_card_no = DB::table('worker_entries')
                                                                    ->distinct()
                                                                    ->pluck('id_card_no');
                                                            @endphp
                                                            <select name="id_card_no" id="id_card_no"
                                                                class="form-control">
                                                                <option value="">Select ID Card No</option>
                                                                @foreach ($id_card_no as $item)
                                                                    <option value="{{ $item }}">
                                                                        {{ $item }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </div>
                                                    <div class="form-group">
                                                        <td>Process Type:</td>
                                                        <td>
                                                            @php
                                                                $process_type = DB::table(
                                                                    'worker_sewing_process_entries',
                                                                )
                                                                    ->distinct()
                                                                    ->pluck('sewing_process_type');
                                                            @endphp
                                                            <select name="sewing_process_type" id="sewing_process_type"
                                                                class="form-control">
                                                                <option value="">Select Process Type</option>
                                                                @foreach ($process_type as $item)
                                                                    <option value="{{ $item }}">
                                                                        {{ $item }}</option>
                                                                @endforeach
                                                            </select>

                                                        </td>
                                                    </div>
                                                    <div class="form-group">
                                                        <td>Process Name:</td>
                                                        <td>
                                                            @php
                                                                $process_name = DB::table(
                                                                    'worker_sewing_process_entries',
                                                                )
                                                                    ->distinct()
                                                                    ->pluck('sewing_process_name');
                                                            @endphp
                                                            <select name="sewing_process_name" id="sewing_process_name"
                                                                class="form-control">
                                                                <option value="">Select Process Name</option>
                                                                @foreach ($process_name as $item)
                                                                    <option value="{{ $item }}">
                                                                        {{ $item }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </div>
                                                    <div class="form-group">
                                                        <td>Present Grade:</td>
                                                        <td>
                                                            @php
                                                                $present_grade = DB::table('worker_entries')
                                                                    ->distinct()
                                                                    ->pluck('present_grade');
                                                            @endphp
                                                            <select name="present_grade" id="present_grade"
                                                                class="form-control">
                                                                <option value="">Select Grade</option>
                                                                @foreach ($present_grade as $item)
                                                                    <option value="{{ $item }}">
                                                                        {{ $item }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </div>
                                                    <div class="form-group">
                                                        <td>Recommended Grade:</td>
                                                        <td>
                                                            @php
                                                                $recomanded_grade = DB::table('worker_entries')
                                                                    ->distinct()
                                                                    ->pluck('recomanded_grade');
                                                            @endphp
                                                            <select name="recomanded_grade" id="recomanded_grade"
                                                                class="form-control">
                                                                <option value="">Select Grade</option>
                                                                @foreach ($recomanded_grade as $item)
                                                                    <option value="{{ $item }}">
                                                                        {{ $item }}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </div>
                                                    <td>
                                                        <button class="btn btn-outline-info btn-sm"
                                                            onclick="validateForm()"><i class="fa fa-search"></i>
                                                            Search</button>

                                                        <script>
                                                            function validateForm() {
                                                                var floor = document.getElementById('floor').value;
                                                                var id_card_no = document.getElementById('id_card_no').value;
                                                                var sewing_process_type = document.getElementById('sewing_process_type').value;
                                                                var sewing_process_name = document.getElementById('sewing_process_name').value;
                                                                var recomanded_grade = document.getElementById('recomanded_grade').value;

                                                                if (floor == '' && id_card_no == '' && sewing_process_type == '' && sewing_process_name == '' &&
                                                                    recomanded_grade == '') {
                                                                    //alert show in sweet alert
                                                                    Swal.fire({
                                                                        icon: 'error',
                                                                        title: 'Oops...',
                                                                        text: 'Please Select At Least One Field!',
                                                                    });

                                                                    return false;
                                                                }
                                                            }
                                                        </script>

                                                    </td>

                                                    <td>
                                                        <a href="{{ route('empty_grade_list') }}"
                                                            class="btn btn-outline-danger btn-sm"><i
                                                                class="fa fa-refresh"></i> Reset</a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>

                    <div class="card" style="overflow-x: auto; overflow-y: auto;">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6 col-sm-12">


                                    @can('Admin')
                                        <x-backend.form.anchor :href="route('workerEntries.create')" type="create" />
                                    @endcan
                                    {{-- <form method="GET" action="{{ route('empty_grade_list') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="low_performer" value="low_performer">

                                        <button type="submit" class="btn btn-outline-info">
                                            <i class="fa fa-list" aria-hidden="true"></i> Low Performer List
                                        </button>

                                    </form>

                                    <form method="GET" action="{{ route('empty_grade_list') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="high_performer" value="high_performer">

                                        <button type="submit" class="btn btn-outline-warning">
                                            <i class="fa fa-list" aria-hidden="true"></i> High Performer List
                                        </button>

                                    </form> --}}
                                    {{-- all_data_download download button  --}}
                                    <a href="{{ route('all_data_download') }}" class="btn btn-outline-info">
                                        <i class="fa fa-download" aria-hidden="true"></i> All Data Download </a>
                                </div>
                                <div class="col-md-6 col-sm-12 text-md-end">
                                    @if (session('search_worker') || $search_worker)
                                        <form method="GET" action="{{ route('empty_grade_list') }}">
                                            @csrf

                                            <div class="row">
                                                <div class="col-md-12 col-sm-12">
                                                    <div class="form-group" id="hide_div">
                                                        <label for="export_format">Export Format:</label>
                                                        <select name="export_format" id="export_format"
                                                            class="form-control">
                                                            <option value="xlsx">Excel (XLS)</option>
                                                        </select>
                                                    </div>
                                                    <button type="submit" class="btn btn-outline-info">
                                                        <i class="fa fa-file-excel" aria-hidden="true"></i> Export
                                                    </button>
                                                </div>
                                            </div>

                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {{-- spl Table goes here --}}

                            <table id="datatablesSimple" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sl#</th>
                                        <th>Floor</th>
                                        <th>Line</th>
                                        <th>ID Card No</th>
                                        <th>Name</th>
                                        <th>Process Type</th>
                                        <th>Machine Type</th>
                                        <th>Process Name</th>
                                        <th>Present Grade</th>
                                        <th>Recommended Grade</th>
                                        <th>Recommended Salary</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sl=0 @endphp
                                    @foreach ($workerEntries as $spl)
                                        @php
                                            $data = DB::table('worker_sewing_process_entries')
                                                ->where('worker_entry_id', $spl->id)
                                                ->get();
                                            $machine_type = DB::table('sewing_process_lists')
                                                ->whereIn('id', $data->pluck('sewing_process_list_id'))
                                                ->get('machine_type');

                                            //consider grade value D=1, C=2, C+=3, C++=4, B=5, B+=6, A=7, A+=8 then if $spl->recomanded_grade < $spl->present_grade then it will show red color in the table row

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

                                            // Converting grades to numerical values if any of them is not found in the array then it will be 0
                                            if ($spl->present_grade != null && $spl->recomanded_grade != null) {
                                                $present_grade_value = $grades[$spl->present_grade];
                                                $recommended_grade_value = $grades[$spl->recomanded_grade];
                                            } else {
                                                $present_grade_value = 9;
                                                $recommended_grade_value = 0;
                                            }

                                            // Applying CSS class based on the condition
                                            // $row_class =
                                            //     $recommended_grade_value < $present_grade_value ? 'bg-danger' : '';

                                        @endphp

                                        {{-- class="{{ $row_class }}" --}}


                                        <tr>
                                            <td>{{ $spl->id }}</td>
                                            <td>{{ $spl->floor }}</td>
                                            <td>
                                                @if ($spl->line == null)
                                                    <a href="{{ route('workerEntries_Line_Entry', $spl->id) }}"
                                                        class="btn btn-outline-success my-1 mx-1 btn-sm"><i
                                                            class="bi bi-edit"></i>
                                                        Line Entry</a>
                                                @else
                                                    {{ $spl->line }}
                                                @endif
                                            </td>
                                            <td>{{ $spl->id_card_no }}</td>
                                            <td>{{ $spl->employee_name_english }}</td>
                                            <td>
                                                <ol>
                                                    @foreach ($data as $item)
                                                        <li>{{ ucwords($item->sewing_process_type) }}</li>
                                                        {{-- @if ($item->sewing_process_type == 'normal')
                                                        <span class="badge badge-success">Normal Process</span>
                                                    @elseif ($item->sewing_process_type == 'critical')
                                                        <span class="badge badge-danger">Critical Process</span>
                                                    @elseif ($item->sewing_process_type == 'both')
                                                        <span class="badge badge-warning">Both Process</span>
                                                    @else
                                                        <span class="badge badge-dark">No Process</span>
                                                    @endif --}}
                                                    @endforeach
                                                </ol>
                                            </td>
                                            <td>
                                                <ol>
                                                    @foreach ($machine_type as $type)
                                                        {{-- @if ($type->machine_type == 'LSM')
                                                        <span class="badge badge-secondary">LOCK STITCH MACHINE</span>
                                                    @elseif ($type->machine_type == 'FLM')
                                                        <span class="badge badge-warning">FLAT LOCK MACHINE</span>
                                                    @elseif ($type->machine_type == 'OLM')
                                                        <span class="badge badge-info">OVER LOCK MACHINE</span>
                                                    @elseif ($type->machine_type == 'NM')
                                                        <span class="badge badge-success">NORMAL MACHINES</span>
                                                    @elseif ($type->machine_type == 'SM')
                                                        <span class="badge badge-dark">SPECIAL MACHINES</span>
                                                    @else
                                                        <span class="badge badge-dark">No Machine</span>
                                                    @endif --}}

                                                        <li>{{ ucwords($type->machine_type) }}</li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                            <td>
                                                <ol>
                                                    @foreach ($data as $item)
                                                        <li>{{ ucwords($item->sewing_process_name) }}</li>
                                                    @endforeach
                                                </ol>
                                                {{-- @foreach ($data as $item)
                                                    {{ ucwords($item->sewing_process_name) }}
                                                @endforeach --}}
                                            </td>
                                            <td>{{ $spl->present_grade }}</td>
                                            <td>{{ $spl->recomanded_grade }}</td>
                                            <td>
                                                @if ($spl->recomanded_salary == null || $spl->recomanded_salary == 'N/A')
                                                    Failed
                                                @else
                                                    {{ $spl->recomanded_salary }} TK
                                                @endif
                                            </td>
                                            <td>


                                                @can('General')
                                                    <x-backend.form.anchor :href="route('workerEntries.edit', $spl)" type="edit" />

                                                    <form style="display:inline"
                                                        action="{{ route('workerEntries.destroy', ['workerEntry' => $spl->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')

                                                        <button onclick="return confirm('Are you sure want to delete ?')"
                                                            class="btn btn-outline-danger my-1 mx-1 btn-sm"
                                                            type="submit"><i class="bi bi-trash"></i>
                                                            Delete</button>
                                                    </form>
                                                @endcan
                                                <x-backend.form.anchor :href="route('workerEntries.show', $spl)" type="show" />
                                                <x-backend.form.anchor :href="route('workerEntries.approval', $spl)" type="Download" />
                                                @can('General')
                                                    <a href="{{ route('cyclesData_entry_form', ['workerEntry' => $spl->id]) }}"
                                                        class="btn btn-outline-success my-1 mx-1 btn-sm"><i
                                                            class="bi bi-file"></i>
                                                        Cycle Entry</a>
                                                @endcan
                                                @can('Admin')
                                                    <a href="{{ route('cyclesData_entry_form', ['workerEntry' => $spl->id]) }}"
                                                        class="btn btn-outline-success my-1 mx-1 btn-sm"><i
                                                            class="bi bi-file"></i>
                                                        Cycle Entry</a>
                                                    <x-backend.form.anchor :href="route('workerEntries.edit', $spl)" type="edit" />
                                                    <form style="display:inline"
                                                        action="{{ route('workerEntries.destroy', ['workerEntry' => $spl->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')

                                                        <button onclick="return confirm('Are you sure want to delete ?')"
                                                            class="btn btn-outline-danger my-1 mx-1 btn-sm"
                                                            type="submit"><i class="bi bi-trash"></i>
                                                            Delete</button>
                                                    </form>
                                                @endcan
                                                @can('Supervisor')
                                                    <a href="{{ route('cyclesData_entry_form', ['workerEntry' => $spl->id]) }}"
                                                        class="btn btn-outline-success my-1 mx-1 btn-sm"><i
                                                            class="bi bi-file"></i>
                                                        Cycle Entry</a>
                                                    <x-backend.form.anchor :href="route('workerEntries.edit', $spl)" type="edit" />
                                                    <form style="display:inline"
                                                        action="{{ route('workerEntries.destroy', ['workerEntry' => $spl->id]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')

                                                        <button onclick="return confirm('Are you sure want to delete ?')"
                                                            class="btn btn-outline-danger my-1 mx-1 btn-sm"
                                                            type="submit"><i class="bi bi-trash"></i>
                                                            Delete</button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.col -->
                </div>
                <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    @endif

    <script>
        $(function() {
            $("#datatablesSimple").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>

</x-backend.layouts.master>
