<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Miration
    </x-slot>
    <div class="container pt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Miration
                    </div>
                    <form action="{{ route('migrate_worker_lists.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="date"> Date</label>
                                        <input type="date" name="date" id="date" class="form-control" placeholder="Enter Date" required value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="id_card_no">Worker ID Card No</label>
                                        <select name="id_card_no[]" id="id_card_no" class="form-control" multiple required>
                                            @php
                                            $current_year = date('Y');
                                            $workerEntries = \App\Models\WorkerEntry::where(
                                            'examination_date',
                                            'like',
                                            $current_year . '%',
                                            )->where('old_matrix_Data_status', '!=', 'migrated')
                                            ->distinct()->get(['id_card_no', 'employee_name_english']);
                                            @endphp
                                            @foreach ($workerEntries as $workerEntry)
                                            <option value="{{ $workerEntry->id_card_no }}">
                                                {{ $workerEntry->id_card_no }} : {{ $workerEntry->employee_name_english }}
                                            </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('home') }}" class="btn btn-outline-danger"><i
                                    class="fas fa-times"></i> Cancel</a>
                            <button type="submit" class="btn btn-outline-success"><i class="fas fa-save"></i> Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container pt-1">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Miration List
                    </div>
                    @php
                    $current_year = date('Y');
                    $trainingDevelopments = \App\Models\TrainingDevelopment::where(
                    'training_date',
                    'like',
                    $current_year . '%',
                    )->get();

                    // dd($trainingDevelopments);
                    @endphp

                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Training Date</th>
                                    <th>Training Title</th>
                                    <th>Training Duration</th>
                                    <th>Training Perticipent ID Card No</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trainingDevelopments as $trainingDevelopment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $trainingDevelopment->training_date }}</td>
                                    <td>{{ $trainingDevelopment->training_name }}</td>
                                    <td>{{ $trainingDevelopment->training_duration }}</td>
                                    <td>
                                        {{ $trainingDevelopment->id_card_no }}
                                    </td>
                                    <td>
                                        {{-- <a href="{{ route('training_development_edit', $trainingDevelopment->id) }}"
                                        class="btn btn-outline-primary"><i class="fas fa-edit"></i> Edit</a>
                                        <a href="{{ route('training_development_delete', $trainingDevelopment->id) }}"
                                            class="btn btn-outline-danger"><i class="fas fa-trash"></i> Delete</a> --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#id_card_no').select2({
                allowClear: true,
            });


        });
    </script>


</x-backend.layouts.master>