<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Operator Assessment Sheet List
    </x-slot>

    {{-- <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Operator Assessment Sheet </x-slot>

            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('workerEntries.index') }}">Operator Assessment Sheet</a></li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot> --}}

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
                            <form method="GET" action="{{ route('workerEntries.index') }}" id="filterForm">
                                @php
                                    // Combined database queries
                                    $workerData = DB::table('worker_entries')
                                        ->select('floor', 'id_card_no', 'present_grade', 'recomanded_grade')
                                        ->distinct()
                                        ->get();

                                    $processData = DB::table('worker_sewing_process_entries')
                                        ->select('sewing_process_type', 'sewing_process_name')
                                        ->distinct()
                                        ->get();
                                @endphp

                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row g-3">
                                                <!-- Floor -->
                                                <div class="col-md-2">
                                                    <label class="form-label">Floor:</label>
                                                    <select name="floor" class="form-control select2">
                                                        <option value="">Select Floor</option>
                                                        @foreach ($workerData->unique('floor') as $item)
                                                            <option value="{{ $item->floor }}"
                                                                {{ request('floor') == $item->floor ? 'selected' : '' }}>
                                                                {{ $item->floor }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- ID Card No -->
                                                <div class="col-md-2">
                                                    <label class="form-label">ID Card No:</label>
                                                    {{-- <select name="id_card_no" class="form-control select2">
                                                        <option value="">Select ID Card No</option>
                                                        @foreach ($workerData->unique('id_card_no') as $item)
                                                            <option value="{{ $item->id_card_no }}"
                                                                {{ request('id_card_no') == $item->id_card_no ? 'selected' : '' }}>
                                                                {{ $item->id_card_no }}</option>
                                                        @endforeach
                                                    </select> --}}
                                                    <!--showing id card no as text input with data list-->
                                                    <input type="text" name="id_card_no" class="form-control"
                                                        placeholder="Enter ID Card No" list="idCardNoList"
                                                        value="{{ request('id_card_no') }}">
                                                    <datalist id="idCardNoList">
                                                        @foreach ($workerData->unique('id_card_no') as $item)
                                                            <option value="{{ $item->id_card_no }}"
                                                                {{ request('id_card_no') == $item->id_card_no ? 'selected' : '' }}>
                                                                {{ $item->id_card_no }}</option>
                                                        @endforeach
                                                    </datalist>


                                                </div>

                                                <!-- Process Type -->
                                                <div class="col-md-2">
                                                    <label class="form-label">Process Type:</label>
                                                    <select name="sewing_process_type" class="form-control select2">
                                                        <option value="">Select Process Type</option>
                                                        @foreach ($processData->unique('sewing_process_type') as $item)
                                                            <option value="{{ $item->sewing_process_type }}"
                                                                {{ request('sewing_process_type') == $item->sewing_process_type ? 'selected' : '' }}>
                                                                {{ $item->sewing_process_type }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Process Name -->
                                                <div class="col-md-2">
                                                    <label class="form-label">Process Name:</label>
                                                    <select name="sewing_process_name" class="form-control select2">
                                                        <option value="">Select Process Name</option>
                                                        @foreach ($processData->unique('sewing_process_name') as $item)
                                                            <option value="{{ $item->sewing_process_name }}"
                                                                {{ request('sewing_process_name') == $item->sewing_process_name ? 'selected' : '' }}>
                                                                {{ $item->sewing_process_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Present Grade -->
                                                <div class="col-md-2">
                                                    <label class="form-label">Present Grade:</label>
                                                    <select name="present_grade" class="form-control select2">
                                                        <option value="">Select Grade</option>
                                                        @foreach ($workerData->unique('present_grade') as $item)
                                                            <option value="{{ $item->present_grade }}"
                                                                {{ request('present_grade') == $item->present_grade ? 'selected' : '' }}>
                                                                {{ $item->present_grade }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Recommended Grade -->
                                                <div class="col-md-2">
                                                    <label class="form-label">Recommended Grade:</label>
                                                    <select name="recomanded_grade" class="form-control select2">
                                                        <option value="">Select Grade</option>
                                                        @foreach ($workerData->unique('recomanded_grade') as $item)
                                                            <option value="{{ $item->recomanded_grade }}"
                                                                {{ request('recomanded_grade') == $item->recomanded_grade ? 'selected' : '' }}>
                                                                {{ $item->recomanded_grade }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Action Buttons -->
                                                <div class="col-md-12 text-end mt-3">
                                                    <button type="submit" class="btn btn-outline-info btn-sm">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>
                                                    <a href="{{ route('workerEntries.index') }}"
                                                        class="btn btn-outline-danger btn-sm">
                                                        <i class="fa fa-refresh"></i> Reset
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>



                        </div>
                    </div>

                    <div class="card" style="overflow-x: auto; overflow-y: auto;">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-10 col-sm-12">
                                    @can('Admin')
                                        <x-backend.form.anchor :href="route('workerEntries.create')" type="create" />
                                    @endcan
                                    <form method="GET" action="{{ route('workerEntries.index') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="low_performer" value="low_performer">
                                        <button type="submit" class="btn btn-outline-info">
                                            <i class="fa fa-list" aria-hidden="true"></i> Low Performer List
                                        </button>
                                    </form>
                                    <form method="GET" action="{{ route('workerEntries.index') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="high_performer" value="high_performer">
                                        <button type="submit" class="btn btn-outline-warning">
                                            <i class="fa fa-list" aria-hidden="true"></i> High Performer List
                                        </button>
                                    </form>
                                    @if (auth()->user()->role_id == 1 || auth()->user()->role_id == 3)
                                        <a href="{{ route('all_data_download') }}" class="btn btn-outline-info">
                                            <i class="fa fa-download" aria-hidden="true"></i> All Data Download </a>
                                    @endif
                                    <a href="{{ route('empty_grade_list') }}" class="btn btn-outline-primary"><i
                                            class="fa fa-list" aria-hidden="true"></i>
                                        Unfinished
                                        list</a>
                                </div>
                                <!-- Replace the export button section with this -->
                                <div class="col-md-2 col-sm-12 text-md-end">
                                    @if ($showExportButton ?? false)
                                        <form method="GET" action="{{ route('workerEntries.index') }}"
                                            id="exportForm">
                                            @csrf
                                            <input type="hidden" name="export_format" value="xlsx">
                                            <!-- Preserve filter parameters -->
                                            @foreach (request()->all() as $key => $value)
                                                @if ($key !== 'export_format' && !in_array($key, ['_token', 'page']))
                                                    <input type="hidden" name="{{ $key }}"
                                                        value="{{ $value }}">
                                                @endif
                                            @endforeach
                                            <button type="submit" class="btn btn-outline-info">
                                                <i class="fa fa-file-excel" aria-hidden="true"></i> Export
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header id="datatablesSimple"-->
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
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

                                            $grades = [
                                                'F' => 0,
                                                'D' => 1,
                                                'C' => 2,
                                                'C+' => 3,
                                                'C++' => 4,
                                                'B' => 5,
                                                'B+' => 6,
                                                'A' => 7,
                                                'A+' => 8,
                                            ];

                                            if ($spl->present_grade != null && $spl->recomanded_grade != null) {
                                                $present_grade_value = $grades[$spl->present_grade];
                                                $recommended_grade_value = $grades[$spl->recomanded_grade];
                                            } else {
                                                $present_grade_value = 9;
                                                $recommended_grade_value = 0;
                                            }

                                            $row_class =
                                                $recommended_grade_value < $present_grade_value ? 'bg-danger' : '';
                                        @endphp
                                        <tr class="{{ $row_class }}">
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
                                                    @endforeach
                                                </ol>
                                            </td>
                                            <td>
                                                <ol>
                                                    @foreach ($machine_type as $type)
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
                                            {{-- <td></td> --}}
                                            {!! $spl->actions !!}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Server-side pagination -->
                            <div class="d-flex justify-content-center mt-3">
                                {{ $workerEntries->withQueryString()->links() }}
                            </div>
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


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        //at list one dropdown should be selected before submitting the form
        document.getElementById('filterForm').addEventListener('submit', function(event) {
            const floor = document.querySelector('select[name="floor"]').value;
            const idCardNo = document.querySelector('select[name="id_card_no"]').value;
            const processType = document.querySelector('select[name="sewing_process_type"]').value;
            const processName = document.querySelector('select[name="sewing_process_name"]').value;
            const presentGrade = document.querySelector('select[name="present_grade"]').value;
            const recommendedGrade = document.querySelector('select[name="recomanded_grade"]').value;

            if (!floor && !idCardNo && !processType && !processName && !presentGrade && !recommendedGrade) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Please select at least one filter option before submitting the form!'
                });
            }
        });

        //when id_card_no is selected, auto-submit the form
        document.querySelector('input[name="id_card_no"]').addEventListener('input', function() {

            const idCardNo = this.value;
            if (idCardNo) {
                //minimum 5 characters required to submit the form
                if (idCardNo.length < 5) {
                    return; // Do not submit if less than 5 characters
                }
                document.getElementById('filterForm').submit();
            }
        });
    </script>
    <!-- Add this script at the bottom -->
    <script>
        // Handle export form submission
        document.getElementById('exportForm')?.addEventListener('submit', function(e) {
            // Prevent duplicate parameter issues
            const form = this;
            const existingParams = new URLSearchParams(window.location.search);
            const formData = new FormData(form);

            // Clear existing params to avoid duplication
            existingParams.forEach((value, key) => {
                if (formData.has(key)) {
                    formData.delete(key);
                }
            });

            // Re-add all parameters
            existingParams.forEach((value, key) => {
                formData.append(key, value);
            });

            // Create new URL
            const url = new URL(form.action);
            url.search = new URLSearchParams(formData).toString();

            // Submit via redirect
            window.location.href = url.toString();
            e.preventDefault();
        });
    </script>

</x-backend.layouts.master>
