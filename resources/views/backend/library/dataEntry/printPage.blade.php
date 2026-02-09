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
                                @if (!empty($workerEntry->nid))
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
                            <th>Husband / Wife Name</th>
                            <td>
                                <span id="print_husband_name">{{ $workerEntry->husband_name ?? ' ' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Present Address</th>
                            <td colspan="3">
                                @php
                                    $presentAddressData = json_decode($workerEntry->present_address ?? '', true);
                                    $presentIsJson = is_array($presentAddressData);
                                @endphp
                                <span id="print_present_address">
                                    @if ($presentIsJson)
                                        Division: {{ $presentAddressData['division'] ?? '-' }},
                                        District: {{ $presentAddressData['district'] ?? '-' }},
                                        Upazila/Thana:
                                        {{ $presentAddressData['upazila'] ?? ($presentAddressData['thana'] ?? '-') }},
                                        Post Office / Village / Road:
                                        {{ $presentAddressData['address'] ?? ($presentAddressData['post_office'] ?? '-') }}
                                    @else
                                        {{ $workerEntry->present_address ?? ' ' }}
                                    @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Permanent Address</th>
                            <td colspan="3">
                                @php
                                    $permanentAddressData = json_decode($workerEntry->permanent_address ?? '', true);
                                    $permanentIsJson = is_array($permanentAddressData);
                                @endphp
                                <span id="print_permanent_address">
                                    @if ($permanentIsJson)
                                        Division: {{ $permanentAddressData['division'] ?? '-' }},
                                        District: {{ $permanentAddressData['district'] ?? '-' }},
                                        Upazila/Thana:
                                        {{ $permanentAddressData['upazila'] ?? ($permanentAddressData['thana'] ?? '-') }},
                                        Post Office / Village / Road:
                                        {{ $permanentAddressData['address'] ?? ($permanentAddressData['post_office'] ?? '-') }}
                                    @else
                                        {{ $workerEntry->permanent_address ?? ' ' }}
                                    @endif
                                </span>
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
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <form id="personalInfoForm">
                        <div class="modal-header">
                            <h5 class="modal-title" id="personalInfoModalLabel">Update Personal Information</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
                            <div class="form-row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="modal_assessment_date"><strong>Assessment Date</strong></label>
                                    <input type="text" name="assessment_date" id="modal_assessment_date"
                                        class="form-control" placeholder="Assessment Date" readonly>
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="modal_joining_date"><strong>Joining Date</strong></label>
                                    <input type="date" name="joining_date" id="modal_joining_date"
                                        class="form-control" placeholder="Enter Joining Date">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="modal_employee_name"><strong>Operator Name</strong></label>
                                    <input type="text" name="employee_name_english" id="modal_employee_name"
                                        class="form-control" placeholder="Enter Operator Name">
                                </div>

                                <div class="form-group col-md-3 col-sm-12">
                                    <label for="modal_grade"><strong>Grade</strong></label>
                                    <input type="text" name="recomanded_grade" id="modal_grade"
                                        class="form-control" placeholder="Enter Grade" readonly>
                                </div>
                                <div class="form-group col-md-3 col-sm-12">
                                    <label for="modal_salary"><strong>Salary (TK)</strong></label>
                                    <input type="number" name="recomanded_salary" id="modal_salary"
                                        class="form-control" placeholder="Enter Salary" step="0.01" readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="modal_id_card_no"><strong>ID Card No</strong></label>
                                    <input type="text" name="id_card_no" id="modal_id_card_no"
                                        class="form-control" placeholder="Enter ID Card No">
                                </div>
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="modal_nid"><strong>NID / Birth Reg No</strong></label>
                                    <input type="text" name="nid" id="modal_nid" class="form-control"
                                        placeholder="Enter NID" readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3 col-sm-12">
                                    <label for="modal_floor"><strong>Floor</strong></label>
                                    <select name="floor" id="modal_floor" class="form-control">
                                        <option value="">Select Floor</option>
                                        <option value="1st Floor">1st Floor</option>
                                        <option value="2nd Floor">2nd Floor</option>
                                        <option value="3rd Floor">3rd Floor</option>
                                        <option value="4th Floor">4th Floor</option>
                                        <option value="5th Floor">5th Floor</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-sm-12">
                                    <label for="modal_line"><strong>Line</strong></label>
                                    <input type="text" name="line" id="modal_line" class="form-control"
                                        placeholder="Enter Line">
                                </div>
                                <div class="form-group col-md-3 col-sm-12">
                                    <label for="modal_designation"><strong>Designation</strong></label>
                                    <select name="designation_name" id="modal_designation" class="form-control">
                                        <option value="">Select Designation</option>
                                        <option value="Line Leader">Line Leader</option>
                                        <option value="JSMO">JSMO</option>
                                        <option value="OSMO">OSMO</option>
                                        <option value="SMO">SMO</option>
                                        <option value="SSMO">SSMO</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3 col-sm-12">
                                    <label for="modal_mobile"><strong>Mobile</strong></label>
                                    <input type="text" name="mobile" id="modal_mobile" class="form-control"
                                        placeholder="Enter Mobile">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="modal_father_name"><strong>Father Name</strong></label>
                                    <input type="text" name="father_name" id="modal_father_name"
                                        class="form-control" placeholder="Enter Father Name">
                                </div>

                                <div class="form-group col-md-6 col-sm-12">
                                    <label for="modal_husband_name"><strong>Husband / Wife Name</strong></label>
                                    <input type="text" name="husband_name" id="modal_husband_name"
                                        class="form-control" placeholder="Enter Husband / Wife Name">
                                </div>
                            </div>

                            <div class="form-group">
                                <label><strong>Present Address</strong></label>
                                <div class="alert alert-info mb-3" id="present_address_display"
                                    style="display:none;">
                                    <strong>Current Address:</strong><br>
                                    <span id="present_address_display_text"></span>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <label for="present_division" class="form-label">Division:</label>
                                        <select id="present_division" name="present_division" class="form-control"
                                            onchange="populatePresentDistricts()">
                                            <option value="">-- Select Division --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="present_district" class="form-label">District:</label>
                                        <select id="present_district" name="present_district" class="form-control"
                                            onchange="populatePresentUpazilas()" disabled>
                                            <option value="">-- Select District --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="present_upazila" class="form-label">Upazila/Thana:</label>
                                        <select id="present_upazila" name="present_upazila" class="form-control"
                                            disabled>
                                            <option value="">-- Select Upazila/Thana --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="present_address_text" class="form-label">Post Office / Village /
                                            Road:</label>
                                        <input type="text" id="present_address_text" name="present_address_text"
                                            class="form-control"
                                            placeholder="Enter Post Office, Village, Road/Street">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><strong>Permanent Address</strong></label>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="same_as_present_address">
                                    <label class="form-check-label" for="same_as_present_address">
                                        Same as Present Address
                                    </label>
                                </div>
                                <div class="alert alert-info mb-3" id="permanent_address_display"
                                    style="display:none;">
                                    <strong>Current Address:</strong><br>
                                    <span id="permanent_address_display_text"></span>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12">
                                        <label for="permanent_division" class="form-label">Division:</label>
                                        <select id="permanent_division" name="permanent_division"
                                            class="form-control" onchange="populatePermanentDistricts()">
                                            <option value="">-- Select Division --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="permanent_district" class="form-label">District:</label>
                                        <select id="permanent_district" name="permanent_district"
                                            class="form-control" onchange="populatePermanentUpazilas()" disabled>
                                            <option value="">-- Select District --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <label for="permanent_upazila" class="form-label">Upazila/Thana:</label>
                                        <select id="permanent_upazila" name="permanent_upazila" class="form-control"
                                            disabled>
                                            <option value="">-- Select Upazila/Thana --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6 col-sm-12">
                                        <label for="permanent_address_text" class="form-label">Post Office / Village /
                                            Road:</label>
                                        <input type="text" id="permanent_address_text"
                                            name="permanent_address_text" class="form-control"
                                            placeholder="Enter Post Office, Village, Road/Street">
                                    </div>
                                </div>
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

        /* Modal form fields styling */
        .modal-body .form-group {
            margin-bottom: 1rem;
        }

        .modal-body .form-control {
            display: block;
            width: 100%;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .modal-body .form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
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
        // Bangladesh Location Data
        const locationData = {
            "Dhaka Division": {
                "Narsingdi": ["Sadar Upazila", "Monohardi Upazila", "Shibpur Upazila", "Palash Upazila",
                    "Belabo Upazila", "Raipura Upazila"
                ],
                "Narayanganj": ["Sadar Upazila", "Bandar Upazila", "Sonargaon Upazila", "Araihazar Upazila",
                    "Rupganj Upazila"
                ],
                "Munshiganj": ["Sadar Upazila", "Tongibari Upazila", "Louhajang Upazila", "Sreenagar Upazila",
                    "Sirajdikhan Upazila", "Gazaria Upazila"
                ],
                "Gazipur": ["Sadar Upazila", "Tongi Upazila", "Kaliganj Upazila", "Kaliakair Upazila",
                    "Kapasia Upazila", "Sreepur Upazila"
                ],
                "Manikganj": ["Sadar Upazila", "Singair Upazila", "Daulatpur Upazila", "Harirampur Upazila",
                    "Ghior Upazila", "Shibalaya Upazila", "Saturia Upazila"
                ],
                "Dhaka": ["Kotwali Thana", "Mohammadpur Thana", "Lalbagh Thana", "Sutrapur Thana",
                    "Motijheel Thana", "Demra Thana", "Sabujbag Thana", "Mirpur Thana", "Gulshan Thana",
                    "Uttara Thana", "Pallabi Thana", "Cantonment Thana", "Dhanmondi Thana", "Tejgaon Thana",
                    "Ramna Thana", "Keraniganj Upazila", "Dohar Upazila", "Nawabganj Upazila", "Savar Upazila",
                    "Dhamrai Upazila"
                ],
                "Faridpur": ["Sadar Upazila", "Boalmari Upazila", "Sadarpur Upazila", "Char Bhadrasan Upazila",
                    "Bhanga Upazila", "Nagarkanda Upazila", "Madhukhali Upazila", "Alfadanga Upazila",
                    "Saltha Upazila"
                ],
                "Rajbari": ["Sadar Upazila", "Pangsha Upazila", "Goalanda Upazila", "Kalukhali Upazila",
                    "Baliakandi Upazila"
                ],
                "Gopalganj": ["Sadar Upazila", "Kashiani Upazila", "Tungipara Upazila", "Muksudpur Upazila",
                    "Kotalipara Upazila"
                ],
                "Madaripur": ["Sadar Upazila", "Kalkini Upazila", "Rajoir Upazila", "Shibchar Upazila"],
                "Shariatpur": ["Sadar Upazila", "Damudya Upazila", "Naria Upazila", "Zajira Upazila",
                    "Bhedarganj Upazila", "Gosairhat Upazila"
                ]
            },
            "Barisal Division": {
                "Barguna": ["Sadar Upazila", "Amtali Upazila", "Betagi Upazila", "Taltali Upazila",
                    "Patharghata Upazila", "Bamna Upazila"
                ],
                "Bhola": ["Sadar Upazila", "Daulatkhan Upazila", "Lalmohan Upazila", "Monpura Upazila",
                    "Charfasson Upazila", "Tazumuddin Upazila", "Borhanuddin Upazila"
                ],
                "Jhalokati": ["Sadar Upazila", "Nalchity Upazila", "Rajapur Upazila", "Kathalia Upazila"],
                "Barisal": ["Sadar Upazila", "Muladi Upazila", "Gournadi Upazila", "Agailjhara Upazila",
                    "Hijla Upazila", "Uzirpur Upazila", "Mehendiganj Upazila", "Babuganj Upazila",
                    "Bakerganj Upazila", "Banaripara Upazila"
                ],
                "Patuakhali": ["Sadar Upazila", "Galachipa Upazila", "Kalapara Upazila", "Dashmina Upazila",
                    "Bauphal Upazila", "Rangabali Upazila", "Dumki Upazila", "Mirzaganj Upazila"
                ],
                "Pirojpur": ["Sadar Upazila", "Mathbaria Upazila", "Nazirpur Upazila", "Nesarabad Upazila",
                    "Zianagar Upazila", "Kawkhali Upazila", "Bhandaria Upazila"
                ]
            },
            "Khulna Division": {
                "Khulna": ["Sadar Thana", "Sonadanga Thana", "Daulatpur Thana", "Phultala Upazila",
                    "Dumuria Upazila", "Terokhada Upazila", "Dighalia Upazila", "Rupsha Upazila",
                    "Batiaghata Upazila", "Dacope Upazila", "Koyra Upazila"
                ],
                "Narail": ["Sadar Upazila", "Kalia Upazila", "Lohagara Upazila"],
                "Magura": ["Sadar Upazila", "Sreepur Upazila", "Shalikha Upazila", "Mohammadpur Upazila"],
                "Satkhira": ["Sadar Upazila", "Shyamnagar Upazila", "Assasuni Upazila", "Tala Upazila",
                    "Kaliganj Upazila", "Kalaroa Upazila", "Debhatta Upazila"
                ],
                "Bagerhat": ["Sadar Upazila", "Kachua Upazila", "Rampal Upazila", "Sarankhola Upazila",
                    "Morelganj Upazila", "Mollahat Upazila", "Chitalmari Upazila", "Fakirhat Upazila",
                    "Mongla Upazila"
                ],
                "Jhenaidah": ["Sadar Upazila", "Kaliganj Upazila", "KotChandpur Upazila", "Harinakunda Upazila",
                    "Shailkupa Upazila", "Maheshpur Upazila"
                ],
                "Jashore": ["Sadar Upazila", "Keshabpur Upazila", "Jhikargachha Upazila", "Manirampur Upazila",
                    "Bagherpara Upazila", "Chaugachha Upazila", "Sharsha Upazila", "Abhaynagar Upazila"
                ],
                "Meherpur": ["Sadar Upazila", "Gangni Upazila", "Mujibnagar Upazila"],
                "Chuadanga": ["Sadar Upazila", "Jibannagar Upazila", "Damurhuda Upazila", "Alamdanga Upazila"],
                "Kushtia": ["Sadar Upazila", "Kumarkhali Upazila", "Daulatpur Upazila", "Bheramara Upazila",
                    "Khoksa Upazila", "Mirpur Upazila"
                ]
            },
            "Sylhet Division": {
                "Sylhet": ["Sadar Upazila", "Gopalganj Upazila", "Beanibazar Upazila", "Zakiganj Upazila",
                    "Companiganj Upazila", "Jaintiapur Upazila", "Dakshin Surma Upazila", "Fenchuganj Upazila",
                    "Bishwanath Upazila", "Balaganj Upazila", "Gowainghat Upazila", "Kanaighat Upazila"
                ],
                "Sunamganj": ["Sadar Upazila", "Jamalganj Upazila", "Jagannathpur Upazila", "Sulla Upazila",
                    "Dharampasha Upazila", "Bishwamvarpur Upazila", "South Sunamganj Upazila", "Chatak Upazila",
                    "Dowarabazar Upazila", "Derai Upazila", "Tahirpurr Upazila"
                ],
                "Moulvibazar": ["Sadar Upazila", "Rajnagar Upazila", "Kulaura Upazila", "Juri Upazila",
                    "Barlekha Upazila", "Kamalganj Upazila", "Sreemangal Upazila"
                ],
                "Habiganj": ["Sadar Upazila", "Bahubal Upazila", "Lakhai Upazila", "Nabiganj Upazila",
                    "Chunarughat Upazila", "Madhabpur Upazila", "Baniachong Upazila", "Ajmiriganj Upazila"
                ]
            },
            "Mymensingh Division": {
                "Tangail": ["Sadar Upazila", "Delduar Upazila", "Mirzapur Upazila", "Bhuapur Upazila",
                    "Ghatail Upazila", "Basail Upazila", "Nagarpur Upazila", "Kalihati Upazila",
                    "Sakhipur Upazila", "Gopalpur Upazila", "Dhanbari Upazila", "Madhupur Upazila"
                ],
                "Kishoreganj": ["Sadar Upazila", "Hossainpur Upazila", "Karimganj Upazila", "Pakundia Upazila",
                    "Nikli Upazila", "Bajitpur Upazila", "Kuliarchar Upazila", "Bhairab Upazila",
                    "Mithamain Upazila", "Itna Upazila", "Katiadi Upazila", "Austagram Upazila",
                    "Tarail Upazila"
                ],
                "Netrokona": ["Sadar Upazila", "Atpara Upazila", "Barhatta Upazila", "Mohanganj Upazila",
                    "Kalmakanda Upazila", "Durgapur Upazila", "Madan Upazila", "Kendua Upazila",
                    "Purbadhala Upazila", "Khaliajuri Upazila"
                ],
                "Jamalpur": ["Sadar Upazila", "Islampur Upazila", "Dewanganj Upazila", "Sarishabari Upazila",
                    "Madarganj Upazila", "Bokshiganj Upazila", "Melandaha Upazila"
                ],
                "Sherpur": ["Sadar Upazila", "Nakla Upazila", "Nalitabari Upazila", "Jhenaigati Upazila",
                    "Sreebardi Upazila"
                ],
                "Mymensingh": ["Sadar Upazila", "Muktagachha Upazila", "Phulbaria Upazila", "Bhaluka Upazila",
                    "Trishal Upazila", "Gaffargaon Upazila", "Nandail Upazila", "Ishwarganj Upazila",
                    "Dhobaura Upazila", "Gauripur Upazila", "Phulpur Upazila", "Haluaghat Upazila",
                    "Tarakanda Upazila"
                ]
            },
            "Chattogram Division": {
                "Noakhali": ["Sadar Upazila", "Begumganj Upazila", "Companiganj Upazila", "Subarnachar Upazila",
                    "Sonaimuri Upazila", "Chatkhil Upazila", "Senbagh Upazila", "Kabirhat Upazila",
                    "Hatiya Upazila"
                ],
                "Feni": ["Sadar Upazila", "Daganbhuiyan Upazila", "Fulgazi Upazila", "Parshuram Upazila",
                    "Chhagalnaiya Upazila", "Sonagazi Upazila"
                ],
                "Lakshmipur": ["Sadar Upazila", "Raipur Upazila", "Ramgati Upazila", "Ramganj Upazila",
                    "Kamalnagar Upazila"
                ],
                "Chandpur": ["Sadar Upazila", "Matlab South Upazila", "Faridganj Upazila", "Hajiganj Upazila",
                    "Haimchar Upazila", "Matlab North Upazila", "Kachua Upazila", "Shahrasti Upazila"
                ],
                "Brahmanbaria": ["Sadar Upazila", "Sarail Upazila", "Kasba Upazila", "Bancharampur Upazila",
                    "Nabinagar Upazila", "Bijoynagar Upazila", "Ashuganj Upazila", "Akhaura Upazila",
                    "Nasirnagar Upazila"
                ],
                "Cumilla": ["Sadar Adarsha Upazila", "Sadar South Upazila", "Brahmanpara Upazila",
                    "Daudkandi Upazila", "Burichang Upazila", "Chauddagram Upazila", "Laksam Upazila",
                    "Monoharganj Upazila", "Meghna Upazila", "Homna Upazila", "Titas Upazila",
                    "Nangalkot Upazila", "Muradnagar Upazila", "Barura Upazila", "Chandina Upazila",
                    "Debidwar Upazila"
                ],
                "Chattogram": ["Kotwali Thana", "Panchlaish Thana", "Chandgaon Thana", "Bandar Thana",
                    "Pahartali Thana", "Double Mooring Thana", "Anwara Upazila", "Patiya Upazila",
                    "Boalkhali Upazila", "Satkania Upazila", "Chandanaish Upazila", "Banshkhali Upazila",
                    "Lohagara Upazila", "Sandwip Upazila", "Hathazari Upazila", "Mirsharai Upazila",
                    "Fatikchhari Upazila", "Rangunia Upazila", "Sitakunda Upazila", "Raozan Upazila"
                ],
                "Cox's Bazar": ["Sadar Upazila", "Maheshkhali Upazila", "Kutubdia Upazila", "Teknaf Upazila",
                    "Ramu Upazila", "Ukhiya Upazila", "Chakaria Upazila", "Pekua Upazila"
                ],
                "Khagrachhari": ["Sadar Upazila", "Panchhari Upazila", "Mahalchhari Upazila", "Dighinala Upazila",
                    "Matiranga Upazila", "Lakshmichhari Upazila", "Manikchhari Upazila", "Ramgarh Upazila"
                ],
                "Bandarban": ["Sadar Upazila", "Thanchi Upazila", "Ruma Upazila", "Rowangchhari Upazila",
                    "Alikadam Upazila", "Lama Upazila", "Naikhongchhari Upazila"
                ],
                "Rangamati": ["Sadar Upazila", "Barkal Upazila", "Langadu Upazila", "Baghaichhari Upazila",
                    "Naniarchar Upazila", "Kawkhali Upazila", "Rajastali Upazila", "Belaichhari Upazila",
                    "Juraichhari Upazila", "Kaptai Upazila"
                ]
            },
            "Rajshahi Division": {
                "Bogura": ["Sadar Upazila", "Shajahanpur Upazila", "Sariakandi Upazila", "Shibganj Upazila",
                    "Gabtali Upazila", "Dhunat Upazila", "Sonatala Upazila", "Dupchanchia Upazila",
                    "Adamdighi Upazila", "Nandigram Upazila", "Sherpur Upazila", "Kahaloo Upazila"
                ],
                "Pabna": ["Sadar Upazila", "Atgharia Upazila", "Ishwardi Upazila", "Bera Upazila",
                    "Santhia Upazila", "Sujanagar Upazila", "Chatmohar Upazila", "Bhangura Upazila",
                    "Faridpur Upazila"
                ],
                "Rajshahi": ["Paba Upazila", "Puthia Upazila", "Charghat Upazila", "Tanore Upazila",
                    "Baghmara Upazila", "Bagha Upazila", "Mohanpur Upazila", "Godagari Upazila",
                    "Durgapur Upazila", "Boalia Thana", "Rajpara Thana"
                ],
                "Natore": ["Sadar Upazila", "Singra Upazila", "Bagatipara Upazila", "Baraigram Upazila",
                    "Gurudaspur Upazila", "Lalpur Upazila", "Naldanga Upazila"
                ],
                "Chapainawabganj": ["Sadar Upazila", "Shibganj Upazila", "Gomastapur Upazila", "Nachole Upazila",
                    "Bholahat Upazila"
                ],
                "Naogaon": ["Sadar Upazila", "Raninagar Upazila", "Atrai Upazila", "Niamatpur Upazila",
                    "Porsha Upazila", "Sapahar Upazila", "Manda Upazila", "Dhamoirhat Upazila",
                    "Badalgachhi Upazila", "Patnitala Upazila", "Mohadevpur Upazila"
                ],
                "Joypurhat": ["Sadar Upazila", "Akkelpur Upazila", "Kalai Upazila", "Panchbibi Upazila",
                    "Khetlal Upazila"
                ],
                "Sirajganj": ["Sadar Upazila", "Kamarkhanda Upazila", "Belkuchi Upazila", "Kazipur Upazila",
                    "Chauhali Upazila", "Shahjadpur Upazila", "Tarash Upazila", "Ullahpara Upazila",
                    "Raiganj Upazila"
                ]
            },
            "Rangpur Division": {
                "Nilphamari": ["Sadar Upazila", "Dimla Upazila", "Jaldhaka Upazila", "Domar Upazila",
                    "Kishoreganj Upazila", "Saidpur Upazila"
                ],
                "Thakurgaon": ["Sadar Upazila", "Baliadangi Upazila", "Pirganj Upazila", "Haripur Upazila",
                    "Ranisankail Upazila"
                ],
                "Gaibandha": ["Sadar Upazila", "Gobindaganj Upazila", "Phulchhari Upazila", "Saghata Upazila",
                    "Sundarganj Upazila", "Palashbari Upazila", "Sadullapur Upazila"
                ],
                "Lalmonirhat": ["Sadar Upazila", "Aditmari Upazila", "Hatibandha Upazila", "Kaliganj Upazila",
                    "Patgram Upazila"
                ],
                "Kurigram": ["Sadar Upazila", "Rowmari Upazila", "Rajibpur Upazila", "Chilmari Upazila",
                    "Ulipur Upazila", "Rajarhat Upazila", "Phulbari Upazila", "Nageswari Upazila",
                    "Bhurungamari Upazila"
                ],
                "Dinajpur": ["Sadar Upazila", "Parbatipur Upazila", "Phulbari Upazila", "Birampur Upazila",
                    "Hakimpur Upazila", "Nawabganj Upazila", "Ghoraghat Upazila", "Bochaganj Upazila",
                    "Biral Upazila", "Kaharole Upazila", "Birganj Upazila", "Khansama Upazila",
                    "Chirirbandar Upazila"
                ],
                "Rangpur": ["Sadar Upazila", "Gangachara Upazila", "Badarganj Upazila", "Taraganj Upazila",
                    "Kaunia Upazila", "Pirgachha Upazila", "Mithapukur Upazila", "Pirganj Upazila"
                ],
                "Panchagarh": ["Sadar Upazila", "Atwari Upazila", "Boda Upazila", "Debiganj Upazila",
                    "Tetulia Upazila"
                ]
            }
        };

        // Initialize divisions for both present and permanent address
        function initializeDivisions() {
            const presentDiv = document.getElementById('present_division');
            const permanentDiv = document.getElementById('permanent_division');

            for (let div in locationData) {
                const option1 = document.createElement('option');
                option1.value = div;
                option1.textContent = div;
                presentDiv.appendChild(option1);

                const option2 = document.createElement('option');
                option2.value = div;
                option2.textContent = div;
                permanentDiv.appendChild(option2);
            }
        }

        // Present Address Functions
        function populatePresentDistricts() {
            const districtSelect = document.getElementById('present_district');
            const upazilaSelect = document.getElementById('present_upazila');
            districtSelect.innerHTML = '<option value="">-- Select District --</option>';
            upazilaSelect.innerHTML = '<option value="">-- Select Upazila/Thana --</option>';
            districtSelect.disabled = true;
            upazilaSelect.disabled = true;

            const selectedDiv = document.getElementById('present_division').value;
            if (selectedDiv) {
                districtSelect.disabled = false;
                for (let dist in locationData[selectedDiv]) {
                    const option = document.createElement('option');
                    option.value = dist;
                    option.textContent = dist;
                    districtSelect.appendChild(option);
                }
            }
        }

        function populatePresentUpazilas() {
            const upazilaSelect = document.getElementById('present_upazila');
            upazilaSelect.innerHTML = '<option value="">-- Select Upazila/Thana --</option>';
            upazilaSelect.disabled = true;

            const selectedDiv = document.getElementById('present_division').value;
            const selectedDist = document.getElementById('present_district').value;
            if (selectedDist) {
                upazilaSelect.disabled = false;
                locationData[selectedDiv][selectedDist].forEach(upazila => {
                    const option = document.createElement('option');
                    option.value = upazila;
                    option.textContent = upazila;
                    upazilaSelect.appendChild(option);
                });
            }
        }

        // Permanent Address Functions
        function populatePermanentDistricts() {
            const districtSelect = document.getElementById('permanent_district');
            const upazilaSelect = document.getElementById('permanent_upazila');
            districtSelect.innerHTML = '<option value="">-- Select District --</option>';
            upazilaSelect.innerHTML = '<option value="">-- Select Upazila/Thana --</option>';
            districtSelect.disabled = true;
            upazilaSelect.disabled = true;

            const selectedDiv = document.getElementById('permanent_division').value;
            if (selectedDiv) {
                districtSelect.disabled = false;
                for (let dist in locationData[selectedDiv]) {
                    const option = document.createElement('option');
                    option.value = dist;
                    option.textContent = dist;
                    districtSelect.appendChild(option);
                }
            }
        }

        function populatePermanentUpazilas() {
            const upazilaSelect = document.getElementById('permanent_upazila');
            upazilaSelect.innerHTML = '<option value="">-- Select Upazila/Thana --</option>';
            upazilaSelect.disabled = true;

            const selectedDiv = document.getElementById('permanent_division').value;
            const selectedDist = document.getElementById('permanent_district').value;
            if (selectedDist) {
                upazilaSelect.disabled = false;
                locationData[selectedDiv][selectedDist].forEach(upazila => {
                    const option = document.createElement('option');
                    option.value = upazila;
                    option.textContent = upazila;
                    upazilaSelect.appendChild(option);
                });
            }
        }

        function copyPresentToPermanent() {
            $('#permanent_division').val($('#present_division').val());
            populatePermanentDistricts();
            $('#permanent_district').val($('#present_district').val());
            populatePermanentUpazilas();
            $('#permanent_upazila').val($('#present_upazila').val());
            $('#permanent_address_text').val($('#present_address_text').val());
        }

        // Initialize divisions when the modal is shown
        $('#personalInfoModal').on('show.bs.modal', function() {
            initializeDivisions();

            // Populate all fields with current data
            $('#modal_assessment_date').val(
                "{{ \Carbon\Carbon::parse($workerEntry->examination_date)->format('d-M-Y') ?? ' ' }}");
            $('#modal_employee_name').val("{{ $workerEntry->employee_name_english ?? '' }}");
            $('#modal_id_card_no').val("{{ $workerEntry->id_card_no ?? '' }}");
            $('#modal_nid').val("{{ $workerEntry->nid ?? '' }}");
            $('#modal_floor').val("{{ $workerEntry->floor ?? '' }}");
            $('#modal_line').val("{{ $workerEntry->line ?? '' }}");
            $('#modal_designation').val("{{ $workerEntry->designation_name ?? '' }}");
            $('#modal_mobile').val("{{ $workerEntry->mobile ?? '' }}");
            $('#modal_father_name').val("{{ $workerEntry->father_name ?? '' }}");
            $('#modal_husband_name').val("{{ $workerEntry->husband_name ?? '' }}");
            $('#modal_grade').val("{{ $workerEntry->recomanded_grade ?? '' }}");
            $('#modal_salary').val("{{ $workerEntry->recomanded_salary ?? '' }}");
            $('#modal_joining_date').val("{{ $workerEntry->joining_date ?? '' }}");

            // Parse and populate address fields (JSON format)
            function parseAddressJson(raw) {
                if (!raw) {
                    return {
                        division: '',
                        district: '',
                        upazila: '',
                        address: ''
                    };
                }
                if (typeof raw === 'object') {
                    return {
                        division: raw.division || '',
                        district: raw.district || '',
                        upazila: raw.upazila || raw.thana || '',
                        address: raw.address || raw.post_office || ''
                    };
                }
                try {
                    var parsed = JSON.parse(raw);
                    return {
                        division: parsed.division || '',
                        district: parsed.district || '',
                        upazila: parsed.upazila || parsed.thana || '',
                        address: parsed.address || parsed.post_office || ''
                    };
                } catch (e) {
                    return {
                        division: '',
                        district: '',
                        upazila: '',
                        address: ''
                    };
                }
            }

            var presentAddressRaw = @json($workerEntry->present_address ?? '');
            var permanentAddressRaw = @json($workerEntry->permanent_address ?? '');
            var presentAddressData = parseAddressJson(presentAddressRaw);
            var permanentAddressData = parseAddressJson(permanentAddressRaw);

            // Display current present address
            if (presentAddressData.division || presentAddressData.district || presentAddressData.upazila ||
                presentAddressData.address) {
                var presentAddressDisplay =
                    'Division: ' + (presentAddressData.division || '') + ', ' +
                    'District: ' + (presentAddressData.district || '') + ', ' +
                    'Upazila/Thana: ' + (presentAddressData.upazila || '') + ', ' +
                    'Post Office / Village / Road: ' + (presentAddressData.address || '');
                $('#present_address_display_text').text(presentAddressDisplay);
                $('#present_address_display').show();
            } else {
                $('#present_address_display').hide();
            }

            // Display current permanent address
            if (permanentAddressData.division || permanentAddressData.district || permanentAddressData
                .upazila || permanentAddressData.address) {
                var permanentAddressDisplay =
                    'Division: ' + (permanentAddressData.division || '') + ', ' +
                    'District: ' + (permanentAddressData.district || '') + ', ' +
                    'Upazila/Thana: ' + (permanentAddressData.upazila || '') + ', ' +
                    'Post Office / Village / Road: ' + (permanentAddressData.address || '');
                $('#permanent_address_display_text').text(permanentAddressDisplay);
                $('#permanent_address_display').show();
            } else {
                $('#permanent_address_display').hide();
            }

            $('#present_division').val(presentAddressData.division);
            populatePresentDistricts();
            $('#present_district').val(presentAddressData.district);
            populatePresentUpazilas();
            $('#present_upazila').val(presentAddressData.upazila);
            $('#present_address_text').val(presentAddressData.address);

            $('#permanent_division').val(permanentAddressData.division);
            populatePermanentDistricts();
            $('#permanent_district').val(permanentAddressData.district);
            populatePermanentUpazilas();
            $('#permanent_upazila').val(permanentAddressData.upazila);
            $('#permanent_address_text').val(permanentAddressData.address);

            $('#same_as_present_address').prop('checked', false);
        });

        $('#same_as_present_address').on('change', function() {
            if (this.checked) {
                copyPresentToPermanent();
            }
        });

        $('#present_division, #present_district, #present_upazila, #present_address_text').on('change keyup',
    function() {
            if ($('#same_as_present_address').is(':checked')) {
                copyPresentToPermanent();
            }
        });

        $('#personalInfoForm').on('submit', function(e) {
            e.preventDefault();

            // Build JSON address fields
            var presentAddress = JSON.stringify({
                division: $('#present_division').val(),
                district: $('#present_district').val(),
                upazila: $('#present_upazila').val(),
                address: $('#present_address_text').val()
            });

            var permanentAddress = JSON.stringify({
                division: $('#permanent_division').val(),
                district: $('#permanent_district').val(),
                upazila: $('#permanent_upazila').val(),
                address: $('#permanent_address_text').val()
            });

            $.ajax({
                url: "{{ route('workerEntries.update', ['workerEntry' => $workerEntry->id]) }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    _method: 'PUT',
                    employee_name_english: $('#modal_employee_name').val(),
                    id_card_no: $('#modal_id_card_no').val(),
                    nid: $('#modal_nid').val(),
                    floor: $('#modal_floor').val(),
                    line: $('#modal_line').val(),
                    designation_name: $('#modal_designation').val(),
                    mobile: $('#modal_mobile').val(),
                    father_name: $('#modal_father_name').val(),
                    husband_name: $('#modal_husband_name').val(),
                    present_address: presentAddress,
                    permanent_address: permanentAddress,
                    recomanded_grade: $('#modal_grade').val(),
                    recomanded_salary: $('#modal_salary').val(),
                    joining_date: $('#modal_joining_date').val()
                },
                success: function(response) {
                    if (response && response.data) {
                        // Update all displayed fields with the response data
                        location.reload();
                    }
                    $('#personalInfoModal').modal('hide');
                    if (window.Swal) {
                        Swal.fire('Saved', 'Personal information updated.', 'success');
                    }
                },
                error: function(xhr) {
                    if (window.Swal) {
                        const message = xhr.responseJSON && xhr.responseJSON.message ? xhr
                            .responseJSON.message : 'Update failed.';
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
