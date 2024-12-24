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

    {{-- <x-backend.layouts.partials.top_bar /> --}}


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

    <section class="container pt-3" id="printableArea">
        <div class="col-md-12 text-center">
            {{-- card  1 start --}}
            <div class="card mb-6">
                <div class="card-body">
                    <div class="row">

                        <div class="col-sm-4 text-right">
                            <img src="{{ asset('images/assets/logo.png') }}" class="rounded-circle" width="150"
                                alt="{{ $workerEntry->name }}">
                        </div>
                        <div class="col-sm-8 text-left">
                            <h1 class="text-dark text-bold">Northern Tosrifa Group.</h1><br>
                            <h6 style="font-size:0.7rem;">Holding No 4/2 A, Plot 49 &
                                57
                                135 Gopalpur Munnu Nagar, Tongi, Gazipur Bangladesh</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h5 class="text-center text-bold">Operator Assessment Sheet</h5>
        {{-- <div class="row">
            <div class="col-6">
                <div class="col-md-12">
                    <!-- card  1 start -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Date</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $workerEntry->examination_date }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $workerEntry->employee_name_english }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">ID No</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $workerEntry->id_card_no }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Joining Date</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $workerEntry->joining_date }}
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Present Grade</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    {{ $workerEntry->present_grade }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- card  1 end -->

                </div>
            </div>
            <div class="col-6">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center"> 
                                <div class="mt-3">
                                    <p class="text-muted font-size-sm">
                                        Service Length:
                                        {{ \Carbon\Carbon::parse($workerEntry->joining_date)->diffForHumans() ?? 'No Data found' }}
                                    </p>
                                    <p class="text-muted font-size-sm">
                                        Mobile:
                                        {{ $workerEntry->mobile ?? ' ' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-1">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Recommended Grade</h6>
                                <span class="text-secondary">
                                    {{ $workerEntry->recomanded_grade ?? ' ' }}
                                </span> 
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Designation</h6>
                                <span class="text-secondary">
                                    {{ $workerEntry->designation_name ?? 'Junior Operator' }}
                                </span>


                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> --}}
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
            <table class="table table-bordered table-hover pb-2">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Operation Versatility</th>
                        <th scope="col">SMV</th>
                        <th scope="col">Target</th>
                        <th scope="col">Average Cycle</th>
                        <th scope="col">Capacity</th>
                        <th scope="col">Production</th>
                        <th scope="col">Achieve Production</th>
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
                                {{ isset($sewingProcessEntry->sewing_process_avg_cycles) ? number_format($sewingProcessEntry->sewing_process_avg_cycles, 2) : 'No Data Found' }}
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
                                {{ isset($sewingProcessEntry->efficiency) ? number_format($sewingProcessEntry->efficiency, 2) : 'No Data Found' }}
                                %
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </section>
        <!-- hr section -->
        <section class="content pt-2">
            <table class="table table-borderless">

                {{-- <tr>
                    <th>Necessity of Helper</th>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="sizeCheckbox" checked disabled>
                            <label class="custom-control-label"
                                for="sizeCheckbox">{{ $sewingProcessEntry->necessity_of_helper ?? '' }}</label>

                        </div>
                    </td>
                </tr> --}}
                <tr>
                    <th>Perception About Size</th>
                    <td>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="sizeCheckbox" checked disabled>
                            <label class="custom-control-label"
                                for="sizeCheckbox">{{ $sewingProcessEntry->perception_about_size ?? 'Not Marked Yet' }}</label>

                        </div>
                    </td>
                </tr>
            </table>


            <div class="row pb-1 pt-3">
                <div class="col-sm-6 text-left">
                    @php
                        $operantBy = $sewingProcessEntries[0]['worker_name'];
                        $operantDate = $sewingProcessEntries[0]['updated_at'];
                        $operantBy =
                            $operantBy . ' ( Date: ' . carbon\Carbon::parse($operantDate)->format('d-m-Y') . ')';
                    @endphp
                    {{ $operantBy ?? '' }}
                    <br>
                    ======================
                    <br>
                    Operator Signature
                </div>
                <div class="col-sm-6 text-right">
                    @php
                        $recomandedBy = $sewingProcessEntries[0]['dataEntryBy'];
                        $recomandedtDate = $sewingProcessEntries[0]['dataEntryDate'];
                        $recomandedBy =
                            $recomandedBy . ' ( Date: ' . carbon\Carbon::parse($recomandedtDate)->format('d-m-Y') . ')';
                    @endphp
                    {{ $recomandedBy ?? '' }}
                    <br>
                    ======================
                    <br>
                    Recommended By
                </div>
            </div>
        </section>
        <hr>
        <section class="content ">
            <h6 class="text-bold pb-2">Relevant Skill</h6>
            <div class="row pb-2 pt-1">
                <div class="col-sm-6 pb-2">
                    1. Skill on Machine : @foreach ($sewingProcessEntries as $sewingProcessEntry)
                        {{ ucwords($sewingProcessEntry->sewing_process_name) ?? 'No Data Found' }},
                    @endforeach
                </div>
                <div class="col-sm-6 pb-2">
                    2. Curiosity to Learn : @foreach ($curiosity_to_lern as $sewingProcessEntry)
                        {{ ucwords($sewingProcessEntry->sewing_process_name) ?? 'No Data Found' }},
                    @endforeach
                </div>
            </div>
            <h6 class="text-bold pb-2">Supervisor's Comment</h6>
            <div class="row pb-2 pt-1">
                <div class="col-sm-12 pb-2">
                    a. Team Works :
                    @php
                        $rating = $sewingProcessEntries[0]['rating'];
                        // dd($rating);
                    @endphp
                    @for ($i = 0; $i < $rating; $i++)
                        <i class="bi bi-star-fill text-warning" style="font-size: 1.5rem;"></i>
                    @endfor

                </div>
            </div>
            <hr>
            <section class="content">
                <h6 class="text-bold pb-2 text-center">HR</h6>
                <table class="table table-borderless">
                    @php
                        $disciplinary_problems = DB::table('disciplinary_problems')
                            ->where('worker_entry_id', $workerEntry->id)
                            ->where('examination_date', $workerEntry->examination_date)
                            ->get();
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
                @php
                    $i = 0;
                    $trainingDevelopmentEntries = DB::table('training_developments')
                        ->where('id_card_no', $workerEntry->id_card_no)
                        ->where('examination_date', $workerEntry->examination_date)
                        ->get();
                @endphp
                @if ($trainingDevelopmentEntries->count() > 0)



                    <table class="table table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Training Date</th>
                                <th>Trining Title</th>
                                <th>Trining Duration</th>
                            </tr>
                        </thead>
                        <tbody>

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
                @endif
            </section>

            <div class="row pb-2 pt-1">
                <div class="col-sm-12 pb-2">
                    <h6 class="text-bold pb-3">Assessor's Comment :
                        .........................................................................................................................................................................

                    </h6>
                </div>
            </div>
            <div class="row pb-2 pt-1">
                <div class="col-sm-12 pb-2">
                    <h6 class="text-bold pb-2">Note :
                        .........................................................................................................................................................................
                    </h6>
                </div>
            </div>


        </section>
        <div class="row pt-3" style="bottom: 0px;">
            <div class="col-sm-6 text-left pt-3">
                ======================<br>
                Assessed By
            </div>
            <div class="col-sm-6 text-right pt-3">
                ======================<br>
                Approved By
            </div>
        </div>
    </section>
    <section class="content pt-4 pb-3">
        <div class="text-center">
            <a href="{{ route('workerEntries.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
            <input class="btn btn-outline-secondary btn-sm" type="button" onclick="printDiv('printableArea')"
                value="Print" />
        </div>
    </section>
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

    <style>
        /* Watermark */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            opacity: 0.5;
        }

        /* User Information */
        .user-info {
            position: fixed;
            bottom: 0;
            left: 30px;
            color: #6c757d;
            opacity: 0.5;
            font-size: 0.5rem;
        }
    </style>

</body>
<script>
    function printDiv(divName) {
        // Add an event listener for when the page is printed
        window.addEventListener("beforeprint", function() {
            // Create a new paragraph element to hold the message
            var message = document.createElement("p");
            var h6 = document.createElement("h6");
            h6.textContent = "This page is System Generated page, Printed  by  " + "{{ Auth::user()->name }}" +
                " on " + new Date().toLocaleString();
            h6.style.color = "#6c757d"; // set the text color to muted gray
            h6.style.opacity = "0.5"; // set the opacity of the text to 0.5 for a watermark-like effect
            h6.style.fontSize = "0.5rem"; // adjust font size to fit the watermark look
            h6.style.position = "fixed";
            h6.style.bottom = "0"; // position the text at the bottom center of the page
            h6.style.textAlign = "left"; // left align the text
            h6.style.marginLeft = "30px";
            // h6.style.left = "10%";
            // h6.style.transform = "translateX(-50%)"; // horizontally center the text
            message.appendChild(h6);

            // Add the message to the page
            document.body.appendChild(message);


        });

        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>

</html>
