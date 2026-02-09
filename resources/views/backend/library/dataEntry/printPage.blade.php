<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Worker perfomance Management Softwear from NTG, MIS Department" />
    <meta name="author" content="Md. Hasibul Islam Santo, MIS, NTG" />
    <title> {{ $pageTitle ?? 'WorkerMatrix' }} </title>

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

<body>

    <section class="container pb-2 pt-2" id="printableArea">

        <!-- card  1 start -->
        <div class="card mt-1">
            <div class="card-body">
                <div class="row">

                    <div class="col-sm-4 text-right">
                        <img src="{{ asset('images/assets/logo.png') }}" class="rounded-circle" width="150"
                            alt="{{ $workerEntry->name }}">
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

        <h5 class="text-center text-bold">Operator Assessment Sheet</h5>

        <section class="content pb-2 pt-2">
            <div class="card mt-1">
                <div class="card-body">
                    <table class="table table-borderless ">
                        <tr>
                            <th>Assessment Date</th>
                            <td>
                                {{ \Carbon\Carbon::parse($workerEntry->examination_date)->format('d-M-Y') ?? ' ' }}
                            </td>
                            <th>Joining Date</th>
                            <td>
                            </td>

                        </tr>

                        <tr>
                            <th>Operator Name</th>
                            <td>{{ $workerEntry->employee_name_english ?? ' ' }}</td>
                            <th>ID No / NID / Birth Reg No</th>
                            <td>
                                {{ $workerEntry->id_card_no ?? ' ' }}
                                @if(!empty($workerEntry->nid))
                                    / {{ $workerEntry->nid }}
                                @endif
                            </td>

                        </tr>
                        <tr>
                            <th>Floor</th>
                            <td>
                                {{ $workerEntry->floor ?? ' ' }}
                            </td>
                            <th>Line</th>
                            <td>{{ $workerEntry->line ?? ' ' }}</td>
                        </tr>
                        <tr>
                            <th>Designation</th>
                            <td>{{ $workerEntry->designation_name ?? ' ' }}</td>
                            <th>Mobile</th>
                            <td>{{ $workerEntry->mobile ?? ' ' }}</td>
                        </tr>

                        <tr rowspan="6">
                            <th>Father Name</th>
                            <td>
                                <span id="print_father_name">{{ $workerEntry->father_name ?? ' ' }}</span>
                            </td>

                        </tr>
                        <tr rowspan="6">
                            <th>Husband Name</th>
                            <td>
                                <span id="print_husband_name">{{ $workerEntry->husband_name ?? ' ' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Present Address</th>
                            <td colspan="3">
                                <span id="print_present_address">{{ $workerEntry->present_address ?? ' ' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Permanent Address</th>
                            <td colspan="3">
                                <span id="print_permanent_address">{{ $workerEntry->permanent_address ?? ' ' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Grade</th>
                            <td class="text-bold">{{ $workerEntry->recomanded_grade ?? ' ' }}</td>

                            <th>Salary</th>
                            <td class="text-bold">{{ number_format($workerEntry->recomanded_salary, decimals: 0) }} TK
                            </td>

                        </tr>
                        </tr>
                    </table>
                </div>
            </div>

        </section>

        <section class="content">
            <table class="table table-bordered table-hover pb-2 pt-2">
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
                                {{ ucwords($sewingProcessEntry->sewing_process_type) ?? ' ' }} :
                                {{ ucwords($sewingProcessEntry->sewing_process_name) ?? ' ' }}
                            </td>
                            <td>
                                {{ isset($sewingProcessEntry->smv) ? number_format($sewingProcessEntry->smv, 2) : ' ' }}
                            </td>
                            <td>
                                {{ number_format($sewingProcessEntry->target, 0) ?? ' ' }}
                            </td>

                            <td>
                                {{ isset($sewingProcessEntry->sewing_process_avg_cycles) ? number_format($sewingProcessEntry->sewing_process_avg_cycles, 2) : ' ' }}
                            </td>
                            <td>
                                {{ number_format($sewingProcessEntry->capacity, 0) ?? ' ' }}
                            </td>
                            <td>
                                {{ isset($sewingProcessEntry->efficiency) ? number_format($sewingProcessEntry->efficiency, 2) : ' ' }}
                                %
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </section>
        <!-- hr section -->
        <section class="content pb-2 pt-2">


            <div class="row pb-1 pt-3">
                <div class="col-sm-2 text-left">
                    <br>
                    <br>
                    <br>
                    ======================
                    <br>
                    Operator Signature
                </div>
                <!--IE manager, HR manager & GM sir-->
                <div class="col-sm-10 text-right">
                    <div class="row">
                        <div class="col-sm-4 text-center">
                            <br>
                            <br>
                            <br>
                            ======================
                            <br>
                            IE Manager
                        </div>
                        <div class="col-sm-4 text-center">
                            <br>
                            <br>
                            <br>
                            ======================
                            <br>
                            HR Manager
                        </div>
                        <div class="col-sm-4 text-center">
                            <br>
                            <br>
                            <br>
                            ======================
                            <br>
                            General Manager
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </section>
    <section class="content pt-4 pb-3">
        <div class="text-center">
            <a href="{{ route('workerEntries.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
            @if (Auth::user()->role && (Auth::user()->role->name == 'HR' || Auth::user()->role->name == 'Admin'))
                <button type="button" class="btn btn-outline-primary btn-sm no-print" data-toggle="modal"
                    data-target="#personalInfoModal">
                    Update Personal Info
                </button>
            @endif
            <input class="btn btn-outline-secondary btn-sm" type="button" onclick="printDiv('printableArea')"
                value="Print" />
        </div>
    </section>

    @if (Auth::user()->role && (Auth::user()->role->name == 'HR' || Auth::user()->role->name == 'Admin'))
        <div class="modal fade" id="personalInfoModal" tabindex="-1" role="dialog"
            aria-labelledby="personalInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form id="personalInfoForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="personalInfoModalLabel">Update Personal Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="modal_father_name">Father Name</label>
                                    <input type="text" name="father_name" id="modal_father_name" class="form-control"
                                        placeholder="Enter Father Name">
                                </div>

                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="modal_husband_name">Husband Name</label>
                                    <input type="text" name="husband_name" id="modal_husband_name" class="form-control"
                                        placeholder="Enter Husband Name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="modal_present_address">Present Address</label>
                                <textarea name="present_address" id="modal_present_address" class="form-control" rows="3"
                                    placeholder="Enter Present Address"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="modal_permanent_address">Permanent Address</label>
                                <textarea name="permanent_address" id="modal_permanent_address" class="form-control" rows="3"
                                    placeholder="Enter Permanent Address"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

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

        @media print {
            .no-print {
                display: none !important;
            }
        }
    </style>

</body>
<script>
    @if (Auth::user()->role && (Auth::user()->role->name == 'HR' || Auth::user()->role->name == 'Admin'))
        $('#personalInfoModal').on('show.bs.modal', function() {
            $('#modal_father_name').val($('#print_father_name').text().trim());
            $('#modal_husband_name').val($('#print_husband_name').text().trim());
            $('#modal_present_address').val($('#print_present_address').text().trim());
            $('#modal_permanent_address').val($('#print_permanent_address').text().trim());
        });

        $('#personalInfoForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('workerEntries.update', ['workerEntry' => $workerEntry->id]) }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: 'PUT',
                    father_name: $('#modal_father_name').val(),
                    husband_name: $('#modal_husband_name').val(),
                    present_address: $('#modal_present_address').val(),
                    permanent_address: $('#modal_permanent_address').val()
                },
                success: function(response) {
                    if (response && response.data) {
                        $('#print_father_name').text(response.data.father_name || ' ');
                        $('#print_husband_name').text(response.data.husband_name || ' ');
                        $('#print_present_address').text(response.data.present_address || ' ');
                        $('#print_permanent_address').text(response.data.permanent_address || ' ');
                    }
                    $('#personalInfoModal').modal('hide');
                    if (window.Swal) {
                        Swal.fire('Saved', 'Personal information updated.', 'success');
                    }
                },
                error: function(xhr) {
                    if (window.Swal) {
                        const message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Update failed.';
                        Swal.fire('Error', message, 'error');
                    }
                }
            });
        });
    @endif

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
