<x-backend.layouts.master>

    <x-slot name="pageTitle">Exam Candidate List</x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Exam Candidate List </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Exam Candidate List</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            @if (is_null($candidates) || $candidates->isEmpty())
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-danger"><strong>No Exam Candidates found.</strong></h1>
                        @can('Admin')
                            <a href="{{ route('exam.create') }}" class="btn btn-primary mt-3">Create Candidate</a>
                        @endcan
                        <a type="button" class="btn btn-secondary mt-3" href="{{ route('exam.index') }}">Reload Page</a>
                    </div>
                </div>
            @else
                @if (session('message'))
                    <div class="alert alert-success">
                        <span class="close" data-dismiss="alert">&times;</span>
                        <strong>{{ session('message') }}</strong>
                    </div>
                @endif

                <div class="card" style="overflow-x: auto;">
                    <div class="card-header">
                        <form method="GET" action="{{ route('exam.index') }}" id="examFilterForm">
                            @php
                                // Get process list for filters (use actual column names)
                                $processData = DB::table('sewing_process_lists')
                                    ->select('process_type', 'process_name')
                                    ->distinct()
                                    ->get();
                            @endphp

                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label class="form-label">Process Type</label>
                                    <select name="process_type" class="form-control select2">
                                        <option value="">All</option>
                                        @foreach ($processData->unique('process_type') as $item)
                                            <option value="{{ $item->process_type }}"
                                                {{ request('process_type') == $item->process_type ? 'selected' : '' }}>
                                                {{ $item->process_type }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Process Name</label>
                                    <select name="process_name" class="form-control select2">
                                        <option value="">All</option>
                                        @foreach ($processData->unique('process_name') as $item)
                                            <option value="{{ $item->process_name }}"
                                                {{ request('process_name') == $item->process_name ? 'selected' : '' }}>
                                                {{ $item->process_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Passed</label>
                                    <select name="exam_passed" class="form-control">
                                        <option value="">All</option>
                                        <option value="1" {{ request('exam_passed') === '1' ? 'selected' : '' }}>
                                            Yes</option>
                                        <option value="0" {{ request('exam_passed') === '0' ? 'selected' : '' }}>
                                            No</option>
                                    </select>
                                </div>
                                <!--search by NID or Name-->
                                <div class="col-md-2">
                                    <label class="form-label">Search by NID or Name</label>
                                    <input type="text" name="search" class="form-control"
                                        value="{{ request('search') }}" placeholder="Enter NID or Name">
                                </div>


                                <div class="col-md-2 text-end mt-4">
                                    <button type="submit" class="btn btn-outline-info btn-sm"><i
                                            class="fa fa-search"></i> Search</button>
                                    <a href="{{ route('exam.index') }}" class="btn btn-outline-danger btn-sm"><i
                                            class="fa fa-refresh"></i> Reset</a>
                                    @can('Admin')
                                        <a href="{{ route('exam.create') }}" class="btn btn-primary btn-sm">New
                                            Candidate</a>
                                    @endcan
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Sl#</th>
                                    <th>ID</th>
                                    <th>NID</th>
                                    <th>Name</th>
                                    <th>Exam Date</th>
                                    <th>Processes</th>
                                    <th>Result Grade</th>
                                    <th>Passed</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $sl = 0; @endphp
                                @foreach ($candidates as $cand)
                                    @php
                                        // fetch process entries for this candidate
                                        $entries = DB::table('exam_process_entries')
                                            ->where('exam_candidate_id', $cand->id)
                                            ->get();

                                        // derive a compact grade from stored result_data if available
                                        $result = null;
                                        if (!empty($cand->result_data)) {
                                            // result_data may already be decoded (array) or stored as JSON string
                                            if (is_string($cand->result_data)) {
                                                $resultArr = json_decode($cand->result_data, true);
                                            } elseif (is_array($cand->result_data)) {
                                                $resultArr = $cand->result_data;
                                            } else {
                                                $resultArr = null;
                                            }

                                            if (is_array($resultArr)) {
                                                $result = $resultArr['grade'] ?? null;
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ ++$sl }}</td>
                                        <td>{{ $cand->id }}</td>
                                        <td>{{ $cand->nid }}</td>
                                        <td>{{ $cand->name }}</td>
                                        <td>{{ $cand->examination_date }}</td>
                                        <td>
                                            <ol>
                                                @foreach ($entries as $e)
                                                    <li>{{ ucwords($e->sewing_process_name) }}
                                                        ({{ $e->sewing_process_type }})</li>
                                                @endforeach
                                            </ol>
                                        </td>
                                        <td>{{ $result ?? '-' }}</td>
                                        <td>{{ $cand->exam_passed ? 'Yes' : 'No' }}</td>
                                        <td>
                                            <a href="{{ route('exam.show', $cand->id) }}"
                                                class="btn btn-sm btn-secondary">Show</a>
                                            <a href="{{ route('exam.process_entry_form', $cand->id) }}"
                                                class="btn btn-sm btn-info">Process</a>
                                            <a href="{{ route('exam.cyclesData_entry_form', $cand->id) }}"
                                                class="btn btn-sm btn-warning">Cycles</a>
                                            <a href="{{ route('exam.matrixData_entry_form', $cand->id) }}"
                                                class="btn btn-sm btn-success">Matrix</a>
                                            @if ($cand->exam_passed)
                                                <a href="{{ route('exam.addToWorkerEntries', $cand->id) }}"
                                                    class="btn btn-sm btn-primary">Add to Worker Entries</a>
                                            @endif
                                            @can('Admin')
                                                <form method="POST" action="{{ route('exam.destroy', $cand->id) }}"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Delete candidate and all related exam data?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $candidates->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

</x-backend.layouts.master>
