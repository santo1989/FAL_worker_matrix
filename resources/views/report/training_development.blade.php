<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Training & Development
    </x-slot>
    <div class="container pt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Training & Development
                    </div>
                    <form action="{{ route('training_development_store') }}" method="POST">
                        @csrf 
                        @method('POST')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="training_date">Training Date</label>
                                    <input type="date" name="training_date" id="training_date" class="form-control" placeholder="Enter Training Date" required value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="training_name">Training Title</label>
                                    <textarea name="training_name" id="training_name" class="form-control" placeholder="Enter Training Title" required ></textarea>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="training_duration">Training Duration</label>
                                    <input type="number" name="training_duration" id="training_duration"
                                        class="form-control" placeholder="Enter Training Duration">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="id_card_no">Training Perticipent ID Card No</label>
                                    <select name="id_card_no[]" id="id_card_no" class="form-control" multiple required>
                                        @php
                                            $current_year = date('Y');
                                            $workerEntries = \App\Models\WorkerEntry::where(
                                                'examination_date',
                                                'like',
                                                $current_year . '%',
                                            )->get();
                                        @endphp
                                        @foreach ($workerEntries as $workerEntry)
                                            <option value="{{ $workerEntry->id_card_no }}">
                                                {{ $workerEntry->id_card_no }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('home') }}" class="btn btn-outline-danger"><i
                                class="fas fa-times"></i> Cancel</a>
                        <button type="submit" class="btn btn-outline-success"><i class="fas fa-save"></i> Save</button>
                    </div>
                </form>
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
