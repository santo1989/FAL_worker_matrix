<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Worker perfomance Management Softwear from NTG, MIS Department" />
    <meta name="author" content="Md. Hasibul Islam Santo, MIS, NTG" />
    <title>Migrated Worker Report - {{ $migrateWorkerList->employee_name_english }}</title> 

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">

    <!-- font-awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

    <!-- Bootstrap core icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <style>
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            opacity: 0.5;
        }

        .user-info {
            position: fixed;
            bottom: 0;
            left: 30px;
            color: #6c757d;
            opacity: 0.5;
            font-size: 0.5rem;
        }

        .migration-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
    </style>
</head>

<body class="sb-nav-fixed">

    <section class="container pt-3" id="printableArea">
        <!-- Migration Badge -->
        <div class="migration-badge">
            <span class="badge badge-danger p-2">
                <i class="fas fa-archive"></i> MIGRATED WORKER
            </span>
        </div>

        <div class="col-md-12 text-center">
            <!-- card  1 start -->
            <div class="card mb-6">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 text-right">
                            <img src="{{ asset('images/assets/logo.png') }}" class="rounded-circle" width="150"
                                alt="{{ $workerEntry->name ?? 'Worker' }}">
                        </div>
                        <div class="col-sm-8 text-left">
                            <h1 class="text-dark text-bold">Fashion Asia Limited (FAL)</h1><br>
                            <h6 style="font-size:0.7rem;">Holding No 4/2 A, Plot 49 &
                                57
                                135 Gopalpur Munnu Nagar, Tongi, Gazipur Bangladesh</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h5 class="text-center text-bold">Operator Assessment Sheet</h5>
    
        <!-- Migration Info Alert -->
        <div class="alert alert-info">
            <strong>Migration Information:</strong> 
            This worker was migrated on <strong>{{ $migrateWorkerList->migration_date->format('d M Y') }}</strong> 
            due to <strong>{{ ucfirst($migrateWorkerList->migration_reason) }}</strong>. 
            Last working date was <strong>{{ $migrateWorkerList->last_working_date->format('d M Y') }}</strong>.
        </div>

        <section class="content pb-3">
            <div class="card mt-1">
                <div class="card-body">
                    <table class="table table-borderless ">
                        <tr>
                            <th>Assessment Date</th>
                            <td>
                                {{ isset($workerEntry->examination_date) ? \Carbon\Carbon::parse($workerEntry->examination_date)->format('d-M-Y') : 'No Data Found' }}
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
                            <td>{{ isset($workerEntry->joining_date) ? \Carbon\Carbon::parse($workerEntry->joining_date)->format('d-M-Y') : 'No Data Found' }}
                            </td>
                            </td>
                            <th>Service Length</th>
                            <td>
                                {{ $migrateWorkerList->service_length ?? 'No Data found' }}
                            </td>

                        </tr>
                        <tr>
                            <th>Present Grade</th>
                            <td>{{ $workerEntry->present_grade ?? 'No Data Found' }}</td>
                            <th>Recommended Grade</th>
                            <td>{{ $workerEntry->recomanded_grade ?? 'No Data Found' }}</td>
                        </tr>
                        <tr>
                            <th>Last Salary</th>
                            <td>{{ $migrateWorkerList->last_salary ? number_format($migrateWorkerList->last_salary, 2) : 'No Data Found' }}</td>
                            <th>Migration Reason</th>
                            <td><span class="badge badge-primary">{{ ucfirst($migrateWorkerList->migration_reason) }}</span></td>
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
                        <th scope="col">Efficiency</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=0 @endphp
                    @foreach ($sewingProcessEntries as $sewingProcessEntry)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>
                                {{ ucwords($sewingProcessEntry->sewing_process_type ?? 'No Data Found') }} :
                                {{ ucwords($sewingProcessEntry->sewing_process_name ?? 'No Data Found') }}
                            </td>
                            <td>
                                {{ isset($sewingProcessEntry->smv) ? number_format($sewingProcessEntry->smv, 2) : 'No Data Found' }}
                            </td>
                            <td>
                                {{ isset($sewingProcessEntry->target) ? number_format($sewingProcessEntry->target, 0) : 'No Data Found' }}
                            </td>

                            <td>
                                {{ isset($sewingProcessEntry->sewing_process_avg_cycles) ? number_format($sewingProcessEntry->sewing_process_avg_cycles, 2) : 'No Data Found' }}
                            </td>
                            <td>
                                {{ isset($sewingProcessEntry->capacity) ? number_format($sewingProcessEntry->capacity, 0) : 'No Data Found' }}
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
            @if($sewingProcessEntries->count() > 0)
                @php $firstProcess = $sewingProcessEntries->first(); @endphp
                <table class="table table-borderless">
                    <tr>
                        <th>Perception About Size</th>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="sizeCheckbox" 
                                    {{ !empty($firstProcess->perception_about_size) ? 'checked' : '' }} disabled>
                                <label class="custom-control-label"
                                    for="sizeCheckbox">{{ $firstProcess->perception_about_size ?? 'Not Marked Yet' }}</label>
                            </div>
                        </td>
                    </tr>
                </table>

                <div class="row pb-1 pt-3">
                    <div class="col-sm-6 text-left">
                        @php
                            $operantBy = $firstProcess->worker_name ?? 'N/A';
                            $operantDate = $firstProcess->updated_at ?? now();
                            $operantBy = $operantBy . ' ( Date: ' . \Carbon\Carbon::parse($operantDate)->format('d-m-Y') . ')';
                        @endphp
                        {{ $operantBy ?? '' }}
                        <br>
                        ======================
                        <br>
                        Operator Signature
                    </div>
                    <div class="col-sm-6 text-right">
                        @php
                            $recomandedBy = $firstProcess->dataEntryBy ?? 'N/A';
                            $recomandedtDate = $firstProcess->dataEntryDate ?? now();
                            $recomandedBy = $recomandedBy . ' ( Date: ' . \Carbon\Carbon::parse($recomandedtDate)->format('d-m-Y') . ')';
                        @endphp
                        {{ $recomandedBy ?? '' }}
                        <br>
                        ======================
                        <br>
                        Recommended By
                    </div>
                </div>
            @endif
        </section>
        <hr>
        <section class="content ">
            <h6 class="text-bold pb-2">Relevant Skill</h6>
            <div class="row pb-2 pt-1">
                <div class="col-sm-6 pb-2">
                    1. Skill on Machine : 
                    @foreach ($sewingProcessEntries as $sewingProcessEntry)
                        {{ ucwords($sewingProcessEntry->sewing_process_name) ?? 'No Data Found' }},
                    @endforeach
                </div>
                <div class="col-sm-6 pb-2">
                    2. Curiosity to Learn : 
                    @foreach ($curiosity_to_lern as $sewingProcessEntry)
                        {{ ucwords($sewingProcessEntry->sewing_process_name) ?? 'No Data Found' }},
                    @endforeach
                </div>
            </div>
            <h6 class="text-bold pb-2">Supervisor's Comment</h6>
            <div class="row pb-2 pt-1">
                <div class="col-sm-12 pb-2">
    @php
        $team_rating = isset($sewingProcessEntries[0]->rating) 
            ? min($sewingProcessEntries[0]->rating, 10) 
            : 0;
    @endphp
    <tr>
        <th>Team Work</th>
        <td>
            @for ($i = 0; $i < $team_rating; $i++)
                <i class="bi bi-star-fill text-warning" style="font-size: 1rem;"></i>
            @endfor
        </td>
    </tr>
    &nbsp; &nbsp;
    @php
        $Disciplinary = isset($sewingProcessEntries[0]->perception_about_size) 
            ? min($sewingProcessEntries[0]->perception_about_size, 10) 
            : 0;
    @endphp
    <tr>
        <th>Disciplinary Approach/Behavior</th>
        <td>
            @for ($i = 0; $i < $Disciplinary; $i++)
                <i class="bi bi-star-fill text-warning" style="font-size: 1rem;"></i>
            @endfor
        </td>
    </tr>
</div>

            </div>
            <hr>
            <section class="content">
                <h6 class="text-bold pb-2 text-center">HR</h6>
                <table class="table table-borderless">
                    <tr>
                        <th>Disciplinary Problems</th>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="disciplinaryCheckbox" 
                                    {{ $disciplinaryProblems->count() > 0 ? 'checked' : '' }} disabled>
                                @if ($disciplinaryProblems->count() > 0)
                                    <label class="custom-control-label" for="disciplinaryCheckbox">Yes</label> <br>
                                    @foreach($disciplinaryProblems as $problem)
                                        <small>{{ $problem->disciplinary_problem_description ?? 'No description' }}</small><br>
                                    @endforeach
                                @else
                                    <label class="custom-control-label" for="disciplinaryCheckbox">No</label>
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
                @php
                    $i = 0;
                @endphp
                @if ($trainingDevelopments->count() > 0)
                    <table class="table table-bordered table-hover text-center">
                        <thead>
                            <tr>
                                <th>SL No</th>
                                <th>Training Date</th>
                                <th>Training Title</th>
                                <th>Training Duration</th>
                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($trainingDevelopments as $trainingDevelopmentEntry)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ isset($trainingDevelopmentEntry->training_date) ? \Carbon\Carbon::parse($trainingDevelopmentEntry->training_date)->format('d-M-Y') : 'N/A' }}
                                    </td>
                                    <td>{{ $trainingDevelopmentEntry->training_name ?? 'No Data Found' }}</td>
                                    <td>{{ $trainingDevelopmentEntry->training_duration ?? 'No Data Found' }}</td>
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
                        {{ $migrateWorkerList->notes ?? 'No additional notes.' }}
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

        <!-- Migration Footer -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="alert alert-secondary text-center">
                    <small>
                        <strong>Migration Record ID:</strong> {{ $migrateWorkerList->id }} | 
                        <strong>Migrated By:</strong> {{ $migrateWorkerList->data_entry_by }} | 
                        <strong>Migration Date:</strong> {{ $migrateWorkerList->migration_date->format('d M Y') }}
                    </small>
                </div>
            </div>
        </div>
    </section>

    <section class="content pt-4 pb-3">
        <div class="text-center">
            <a href="{{ route('migrate-worker-lists.index') }}" class="btn btn-outline-secondary btn-sm">Back to Migration List</a>
            <input class="btn btn-outline-secondary btn-sm" type="button" onclick="printDiv('printableArea')" value="Print" />
            
            @can('edit_migration')
            <a href="{{ route('migrate-worker-lists.edit', $migrateWorkerList) }}" class="btn btn-outline-warning btn-sm">
                <i class="fas fa-edit"></i> Edit Migration
            </a>
            @endcan
        </div>
    </section>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>

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

</body>

</html>