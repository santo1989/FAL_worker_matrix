<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Operator Assessment Sheet-2
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Operator Assessment Sheet-Process Entry </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('exam.index') }}">Exam</a>
            </li>
            <li class="breadcrumb-item active">Operator Assessment Sheet-Process Entry</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>


    <x-backend.layouts.elements.errors />
    <form action="{{ route('exam.process_type_search') }}" method="post" enctype="multipart/form-data" id="myForm">
        <div class="pb-3">
            @csrf
            <!-- Change radio buttons to checkboxes for multiple selection -->
            <div class="form-group col-md-12 col-sm-12">
                <label for="process_type">Process Type</label>
                <br>
                @php
                    $sewingProcessEntries = [];
                    if (isset($candidate)) {
                        $sewingProcessEntries = App\Models\ExamProcessEntry::where('exam_candidate_id', $candidate->id)
                            ->distinct()
                            ->pluck('sewing_process_type')
                            ->toArray();
                    }
                @endphp
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="process_type[]" id="inlineRadio1"
                        value="normal" @if (in_array('normal', $sewingProcessEntries)) checked @endif>
                    <label class="form-check-label" for="inlineRadio1">Normal Process</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="process_type[]" id="inlineRadio2"
                        value="semi-critical" @if (in_array('semi-critical', $sewingProcessEntries)) checked @endif>
                    <label class="form-check-label" for="inlineRadio2">Semi-Critical Process</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="process_type[]" id="inlineRadio3"
                        value="critical" @if (in_array('critical', $sewingProcessEntries)) checked @endif>
                    <label class="form-check-label" for="inlineRadio3">Critical Process</label>
                </div>
                <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                <button type="submit" class="btn btn-outline-info">Search</button>
            </div>


        </div>
    </form>

    @isset($groupedProcesses)

        <form action="{{ route('exam.process_entry') }}" method="post" enctype="multipart/form-data">
            <div class="row pb-3">
                @csrf

                <div class="form-group col-md-12 col-sm-12">
                    @foreach ($groupedProcesses as $processType => $machineTypes)
                        <h3 class="text-center">{{ strtoupper($processType) }}</h3>
                        <div class="row">
                            @foreach ($machineTypes as $machineType => $sewingProcesses)
                                <div class="col-md-3">
                                    <h4 class="text-center">
                                        @if ($machineType == 'DNL')
                                            Double Needle Lock Stitch Machine
                                        @elseif($machineType == 'SND')
                                            Single Needle Lock Stitch Machine
                                        @elseif($machineType == 'OL')
                                            Over Lock Machine
                                        @elseif($machineType == 'F/L')
                                            Flat Lock Machine
                                        @elseif($machineType == 'KNS')
                                            Multi Needle Chain Stitch Machine/ Kanchai Machine
                                        @elseif($machineType == 'F/L/KNS')
                                            Flat Lock Machine/Multi Needle Chain Stitch Machine/ Kanchai Machine
                                        @elseif($machineType == 'BS')
                                            Button Stitch Machine
                                        @elseif($machineType == 'BH')
                                            Button Hole Machine
                                        @elseif($machineType == 'BTK')
                                            Bartack Machine
                                        @endif


                                    </h4>
                                    @foreach ($sewingProcesses as $sewingProcess)
                                        <div class="row m-1">
                                            <label class="card form-check-label col-md-12 col-sm-12 m-1">
                                                <input class="form-check-input" type="checkbox"
                                                    name="sewing_process_lists_id[]" id="checkbox_{{ $sewingProcess->id }}"
                                                    value="{{ $sewingProcess->id }}"
                                                    @php
$ExamProcessEntry = App\Models\ExamProcessEntry::where('exam_candidate_id', $candidate->id)->where('sewing_process_list_id', $sewingProcess->id)->get();
                                                        if ($ExamProcessEntry->count() > 0) {
                                                            echo 'checked';
                                                        } @endphp>{{ $sewingProcess->id }}
                                                .
                                                {{ ucwords($sewingProcess->process_name) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endforeach


                </div>
            </div>

            <br>


            <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">


            <a type="button" class="btn btn-lg btn-outline-info" href="{{ route('exam.index') }}">Cancel</a>
            <x-backend.form.saveButton>Save</x-backend.form.saveButton>

        </form>
    @endisset
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Update JavaScript validation -->
    <script>
        document.getElementById('myForm').addEventListener('submit', function(event) {
            var checkboxes = document.querySelectorAll('input[name="process_type[]"]:checked');

            if (checkboxes.length === 0) {
                alert('Please select at least one process type before submitting.');
                event.preventDefault();
            }
        });
    </script>
</x-backend.layouts.master>
