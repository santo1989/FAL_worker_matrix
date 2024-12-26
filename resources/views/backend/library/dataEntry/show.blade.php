<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Worker perfomance Management Softwear from NTG, MIS Department" />
    <meta name="author" content="Md. Hasibul Islam Santo, MIS, NTG" />
    <title> {{ $pageTitle ?? 'WorkerMatrix' }} </title>

    <!-- <link href="css/styles.css" rel="stylesheet" /> -->

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- bootstrap 5 cdn  -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>


    <!-- font-awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

    <!-- Bootstrap core icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />



    <!-- sweetalert2 cdn-->

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- DataTable -->

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />

    <!-- Custom CSS -->

    <link href="{{ asset('ui/backend/css/styles.css') }}" rel="stylesheet" />

    <!-- Push Notification -->

    <script src="{{ asset('js/push.min.js') }}"></script>

</head>

<body class="sb-nav-fixed">

    <x-backend.layouts.partials.top_bar />


    {{-- <x-backend.layouts.master> 
    <x-slot name="pageTitle">
        Operator Assessment System
    </x-slot>

     <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> List of Sewing Processes </x-slot>

            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('sewingProcessList.index') }}">List of Sewing Processes</a></li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot> --}}
    <section class="content pt-4">
    </section>
    <section class="container pt-3">
        <div class="col-md-12 text-center">
            {{-- card  1 start --}}
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <img src="{{ asset('images/assets/logo.png') }}" class="rounded-circle" width="150"
                                alt="{{ $workerEntry->name }}">
                        </div>
                        <div class="col-sm-9 ">
                            <h1 class="text-dark text-bold">Northern Tosrifa Group.</h1><br> Holding No 4/2 A, Plot 49 &
                            57
                            135 Gopalpur Munnu Nagar, Tongi, Gazipur Bangladesh
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="content pb-3">
            <div class="card mt-1">
                <div class="card-body">
                    <table class="table table-borderless ">
                        <tr>
                            <th>Assessment Date</th>
                            <td>
                                {{ \Carbon\Carbon::parse($workerEntry->examination_date)->format('d-M-Y') ?? 'No Data Found' }}
                            </td>
                            <th>ID No</th>
                            <td>{{ $workerEntry->id_card_no ?? 'No Data Found' }}</td>
                        </tr>
                        <tr>
                            <th>Operator Name</th>
                            <td>{{ $workerEntry->employee_name_english ?? 'No Data Found' }}</td>
                            <th>Designation</th>
                            <td>{{ $workerEntry->designation_name ?? 'No Data Found' }}</td>
                        </tr>

                        <tr>
                            <th>Joining Date</th>
                            <td>{{ \Carbon\Carbon::parse($workerEntry->joining_date)->format('d-M-Y') ?? 'No Data Found' }}
                            </td>
                            </td>
                            <th>Service Length</th>
                            <td>
                                {{ \Carbon\Carbon::parse($workerEntry->joining_date)->diffForHumans() ?? 'No Data found' }}
                            </td>

                        </tr>
                        <tr>
                            <th>Present Grade</th>
                            <td>{{ $workerEntry->present_grade ?? 'No Data Found' }}</td>
                            <th>Recommended Grade</th>
                            <td>{{ $workerEntry->recomanded_grade ?? 'No Data Found' }}</td>
                        </tr>
                        </tr>
                    </table>
                </div>
            </div>

        </section>

        <section class="content">
            <table class="table table-success table-striped table-hover table-bordered border-success">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Operation Versatility</th>
                        <th scope="col">SMV</th>
                        <th scope="col">Target</th>
                        <th scope="col">Capacity</th>
                        <th scope="col">Production</th>
                        <th scope="col">Line Output</th>
                        <th scope="col">Cycle Log History</th>
                        <th scope="col">Efficiency</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=0 @endphp
                    @foreach ($sewingProcessEntries as $sewingProcessEntry)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>
                                {{ ucwords($sewingProcessEntry->sewing_process_type) ?? 'No Data Found' }} :
                                {{ ucwords($sewingProcessEntry->sewing_process_name) ?? 'No Data Found' }}
                            </td>
                            <td>
                                {{ isset($sewingProcessEntry->smv) ? number_format($sewingProcessEntry->smv, 2) : 'No Data Found' }}
                            </td>
                            <td>
                                {{ number_format($sewingProcessEntry->target, 0) ?? 'No Data Found' }}
                            </td>
                            <td>
                                {{ number_format($sewingProcessEntry->capacity, 0) ?? 'No Data Found' }}
                            </td>
                            <td>
                                {{ number_format($sewingProcessEntry->self_production, 0) ?? 'No Data Found' }}
                            </td>
                            <td>
                                {{ number_format($sewingProcessEntry->achive_production, 0) ?? 'No Data Found' }}
                            </td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop{{ $sewingProcessEntry->sewing_process_list_id }}">
                                    Cycle Log <i class="fas fa-eye"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade"
                                    id="staticBackdrop{{ $sewingProcessEntry->sewing_process_list_id }}"
                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel{{ $sewingProcessEntry->sewing_process_list_id }}"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header text-center">
                                                <h5 class="modal-title"
                                                    id="staticBackdropLabel{{ $sewingProcessEntry->sewing_process_list_id }}">
                                                    Cycle Log</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <table
                                                    class="table table-success table-striped table-hover table-bordered border-success">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Cycle Start</th>
                                                            <th scope="col">Cycle End</th>
                                                            <th scope="col">Duration</th>
                                                            <th scope="col">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody
                                                        id="cycleLogTableBody{{ $sewingProcessEntry->sewing_process_list_id }}">
                                                        <!-- Data will be dynamically populated here -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    // JavaScript code to populate the modal dynamically
                                    $(document).ready(function() {
                                        $('.btn-outline-info').click(function() {
                                            var sewingProcessListId = $(this).data('sewing-process-list-id');

                                            // Clear the existing table rows
                                            $('#cycleLogTableBody{{ $sewingProcessEntry->sewing_process_list_id }}').empty();

                                            // Populate the table with data based on sewingProcessListId
                                            @foreach ($cycleListLogs as $cycleListLogDetail)
                                                @if ($cycleListLogDetail->sewing_process_list_id == $sewingProcessEntry->sewing_process_list_id)
                                                    var row = '<tr>' +
                                                        '<td>{{ $cycleListLogDetail->start_time }}</td>' +
                                                        '<td>{{ $cycleListLogDetail->end_time }}</td>' +
                                                        '<td>{{ isset($cycleListLogDetail->duration) ? number_format($cycleListLogDetail->duration, 2) : 'No Data Found' }}</td>' +
                                                        '<td>{{ $cycleListLogDetail->rejectDataStatus == 1 ? 'Rejected' : 'Accept' }}</td>' +
                                                        '</tr>';
                                                    $('#cycleLogTableBody{{ $sewingProcessEntry->sewing_process_list_id }}').append(
                                                        row);
                                                @endif
                                            @endforeach
                                        });
                                    });
                                </script>

                            </td>
                            <td>
                                {{ isset($sewingProcessEntry->efficiency) ? number_format($sewingProcessEntry->efficiency, 2) : 'No Data Found' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </section>
        <section class="content">
            <table class="table table-borderless">
                @php
                    $team_rating = $sewingProcessEntries[0]['rating'];
                    // dd($rating);
                @endphp
                <tr>
                    <th>Team Work</th>
                    <td>

                        @for ($i = 0; $i < $team_rating; $i++)
                            <i class="bi bi-star-fill text-warning" style="font-size: 1.5rem;"></i>
                        @endfor
                    </td>
                </tr>
                 @php
                    $Disciplinary = $sewingProcessEntries[0]['perception_about_size'];
                    // dd($Disciplinary);
                @endphp
                <tr>
                    <th>Disciplinary Approach/Behavior</th>
                    <td>

                        @for ($i = 0; $i < $Disciplinary; $i++)
                            <i class="bi bi-star-fill text-warning" style="font-size: 1.5rem;"></i>
                        @endfor
                    </td>
                </tr>
                {{-- <tr>
                    <th>Necessity of Helper</th>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="sizeCheckbox" checked disabled>
                            <label class="custom-control-label"
                                for="sizeCheckbox">{{ $sewingProcessEntry->necessity_of_helper ?? '' }}</label>

                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Perception About Size</th>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="sizeCheckbox" checked disabled>
                            <label class="custom-control-label"
                                for="sizeCheckbox">{{ $sewingProcessEntry->perception_about_size ?? 'Not Marked Yet' }}</label>

                        </div>
                    </td>
                </tr> --}}
                @php
                    $disciplinary_problems = DB::table('disciplinary_problems')
                        ->where('worker_entry_id', $workerEntry->id)
                        ->where('examination_date', $workerEntry->examination_date)
                        ->get();
                    // dd($disciplinary_problems);
                @endphp
                <tr>
                    <th>Disciplinary Problems</th>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="sizeCheckbox" checked disabled>
                            @if ($disciplinary_problems->count() > 0)
                                <label class="custom-control-label" for="sizeCheckbox">Yes</label> <br>
                                {{ $disciplinary_problems[0]->disciplinary_problem_description }}
                            @else
                                <label class="custom-control-label" for="sizeCheckbox">No</label>
                            @endif

                        </div>
                    </td>
                </tr>
            </table>
        </section>
        <section class="content">

            <table class="table table-info table-striped table-hover table-bordered border-info text-center">
                <thead>
                    <tr>
                        <th>SL No</th>
                        <th>Training Date</th>
                        <th>Trining Title</th>
                        <th>Trining Duration</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                        $trainingDevelopmentEntries = DB::table('training_developments')
                            ->where('id_card_no', $workerEntry->id_card_no)
                            ->where('examination_date', $workerEntry->examination_date)
                            ->get();
                    @endphp
                    @forelse ($trainingDevelopmentEntries as $trainingDevelopmentEntry)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{{ Carbon\Carbon::parse($trainingDevelopmentEntry->training_date)->format('d-M-Y') }}
                            </td>
                            <td>{{ $trainingDevelopmentEntry->training_name }}</td>
                            <td>{{ $trainingDevelopmentEntry->training_duration }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No Training Data Found</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </section>
        <a href="{{ route('workerEntries.index') }}" class="btn btn-outline-secondary">Back</a>
    </section>
    {{-- </x-backend.layouts.master> --}}
    {{-- 
@foreach ($sewingProcessEntries as $sewingProcessEntry)
    <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="staticBackdropLabel">Cycle Log</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <table class="table table-success table-striped table-hover table-bordered border-success">
                    <thead>
                        <tr>
                            <th scope="col">Cycle Start</th>
                            <th scope="col">Cycle End</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody id="cycleLogTableBody">
                        <!-- Data will be dynamically populated here -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
<script>
    // JavaScript code to populate the modal dynamically
    $(document).ready(function () {
        $('.btn-outline-info').click(function () {
            var sewingProcessListId = $(this).data('sewing-process-list-id');

            // Clear the existing table rows
            $('#cycleLogTableBody').empty();

            // Populate the table with data based on sewingProcessListId
            @foreach ($cycleListLogs as $cycleListLogDetail)
                @if ($cycleListLogDetail->sewing_process_list_id == $sewingProcessEntry->sewing_process_list_id)
                    var row = '<tr>' +
                        '<td>{{ $cycleListLogDetail->start_time }}</td>' +
                        '<td>{{ $cycleListLogDetail->end_time }}</td>' +
                        '<td>{{ $cycleListLogDetail->duration }}</td>' +
                        '<td>{{ $cycleListLogDetail->rejectDataStatus == 1 ? "Rejected" : "" }}</td>' +
                        '</tr>';
                    $('#cycleLogTableBody').append(row);
                @endif
            @endforeach
        });
    });
</script> --}}
    <!-- Core theme JS-->
    <script src="{{ asset('ui/backend/js/scripts.js') }}"></script>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>



    <!-- DataTable JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{ asset('ui/backend/js/datatables-simple-demo.js') }}"></script>

    <!-- Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

</body>

</html>
