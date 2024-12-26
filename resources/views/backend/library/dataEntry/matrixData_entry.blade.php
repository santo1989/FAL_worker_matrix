<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Operator Assessment Sheet-4
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Operator Assessment Sheet-Operation Entry </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('workerEntries.index') }}">Operator Assessment Sheet-4</a>
            </li>
            <li class="breadcrumb-item active">Operator Assessment Sheet-4</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>


    <x-backend.layouts.elements.errors />

    <form action="{{ route('matrixData_store') }}" method="post" enctype="multipart/form-data">
        <div class="pb-3">
            @csrf
            <table class="table table-bordered  table-hover">
                <thead>
                    <tr>
                        <th scope="col">SL</th>
                        <th scope="col">Operation Type</th>
                        <th scope="col">Machine Type</th>
                        <th scope="col">Operation Name</th>
                        <th scope="col">SMV</th>
                        <th scope="col">Target</th>
                        <th scope="col">Avg Cycles</th>
                        <th scope="col">Capacity</th>
                        <th scope="col">Production (Self)</th>
                        <th scope="col">Line Output</th>
                        <th scope="col">Efficiency</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($operationEntry as $oe)
                        {{-- @dd($operationEntry ) --}}
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ strtoupper($oe->sewing_process_type) }}</td>
                            <td>
                                {{-- @php
                                    $machineType = App\Models\SewingProcessList::where(
                                        'id',
                                        $oe->sewing_process_list_id,
                                    )
                                        ->pluck('machine_type')
                                        ->first();
                                @endphp
                                @if ($machineType = 'LSM')
                                    LOCK STITCH MACHINE
                                @elseif ($machineType == 'FLM')
                                    FLAT LOCK MACHINE
                                @elseif ($machineType = 'OLM')
                                    OVER LOCK MACHINE
                                @elseif ($machineType = 'NM')
                                    NORMAL MACHINES
                                @else
                                    SPECIAL MACHINES
                                @endif --}}
                                @php
                                    $machineType = App\Models\SewingProcessList::where(
                                        'id',
                                        $oe->sewing_process_list_id,
                                    )->first();
                                    // dd($machineType);
                                @endphp
                                {{ $machineType->machine_type }}

                                {{-- @if ($machineType == 'DNL')
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
                                @endif --}}
                            </td>
                            <td> {{ ucwords($oe->sewing_process_name) }}</td>
                            <td>
                                @php
                                    $smv = App\Models\SewingProcessList::where('id', $oe->sewing_process_list_id)
                                        ->pluck('smv')
                                        ->first();

                                    if ($oe->smv == null) {
                                        $smv = number_format($smv, 2);
                                    } else {
                                        $smv = number_format($oe->smv, 2);
                                    }
                                @endphp

                                <input type="text" name="smv[]" value="{{ $smv }}"
                                    class="form-control smv-input" readonly>

                            </td>
                            <td>
                                @php
                                    $standard_capacity = App\Models\SewingProcessList::where(
                                        'id',
                                        $oe->sewing_process_list_id,
                                    )
                                        ->pluck('standard_capacity')
                                        ->first();

                                    if ($oe->target == null) {
                                        $target = number_format($standard_capacity, 0);
                                    } else {
                                        $target = number_format($oe->target, 0);
                                    }
                                @endphp

                                <input type="text" name="target[]" value="{{ $target }}"
                                    class="form-control target-input" readonly>
                            </td>
                            <td>
                                <input type="text" name="sewing_process_avg_cycles[]"
                                    value="{{ number_format($oe->sewing_process_avg_cycles, 2) }}"
                                    class="form-control avg-cycles-input" readonly>
                            </td>

                            <td>
                                @php
                                    if ($oe->sewing_process_avg_cycles !== null) {
                                        $capacity = 60 / $oe->sewing_process_avg_cycles;

                                        $fractionalPart = $capacity - floor($capacity);

                                        if ($fractionalPart >= 0.5) {
                                            $roundedCapacity = ceil($capacity); // Round up if fractional part is >= 0.5
                                        } else {
                                            $roundedCapacity = floor($capacity); // Round down otherwise
                                        }
                                    } else {
                                        $roundedCapacity = ''; // Provide a default value when sewing_process_avg_cycles is null
                                    }
                                @endphp
                                <input type="text" name="capacity[]" id="capacity" value="{{ $roundedCapacity }}"
                                    class="form-control capacity-input" readonly>
                            </td>

                            <td>
                                @php
                                    if ($oe->self_production == null) {
                                        $self_production = '';
                                    } else {
                                        $self_production = number_format($oe->self_production, 0);
                                    }
                                @endphp
                                <input type="text" name="production_self[]" value="{{ $self_production }}"
                                    class="form-control production-self-input">
                                {{-- @if ($oe->self_production == null)
                                    <input type="text" name="production_self[]"  
                                        class="form-control production-self-input">
                                @else
                                    <input type="text" name="production_self[]" value="{{  round($oe->self_production) }} "
                                        class="form-control production-self-input" readonly>
                                    @endif --}}
                            </td>
                            <td>
                                @php
                                    if ($oe->achive_production == null) {
                                        $achive_production = '';
                                    } else {
                                        $achive_production = number_format($oe->achive_production, 0);
                                    }
                                @endphp

                                <input type="text" name="production_achive[]" value="{{ $achive_production }} "
                                    class="form-control production-achive-input">
                                {{-- <input type="text" name="production_achive[]" value="{{  number_format($oe->achive_production,0)??'' }}"
                                    class="form-control production-achive-input"> --}}
                            </td>
                            <td>
                                <input type="text" name="efficiency[]"
                                    value="{{ number_format($oe->efficiency, 2) }}"
                                    class="form-control efficiency-input" readonly>
                            </td>
                            <input type="hidden" name="worker_id" value="{{ $oe->worker_entry_id }}">
                            <input type="hidden" name="operation_id[]" value="{{ $oe->id }}">
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <section class="content">
            <table class="table table-borderless">
                {{-- <tr>
                    <th>Team Work</th>
                    <td>


                        <link rel="stylesheet"
                            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

                        <style>
                            .rating {

                                border: none;
                                float: left;
                            }

                            .rating>label {
                                color: #90A0A3;
                                float: right;
                            }

                            /* Define the CSS for the star ratings */
                            .rating>label:before {
                                /* margin: 5px; */
                                font-size: 1.5em;
                                font-family: 'Font Awesome 5 Free';
                                /* Define Font Awesome font family */
                                content: "\f005";
                                /* Unicode for filled star icon */
                                display: inline-block;
                            }

                            .rating>input {
                                display: none;
                            }

                            .rating>input:checked~label:before,
                            .rating:not(:checked)>label:hover:before,
                            .rating:not(:checked)>label:hover~label:before {
                                color: #F79426;
                            }

                            .rating>input:checked+label:hover:before,
                            .rating>input:checked~label:hover:before,
                            .rating>label:hover~input:checked~label:before,
                            .rating>input:checked~label:hover~label:before {
                                color: #FECE31;
                            }
                        </style>

                        <div class="rating">
                            <input type="radio" id="star5" name="rating" value="5"
                                {{ $oe->rating == 5 ? 'checked' : '' }}>
                            <label class="star" for="star5" title="Awesome" aria-hidden="true"></label>
                            <input type="radio" id="star4" name="rating" value="4"
                                {{ $oe->rating == 4 ? 'checked' : '' }}>
                            <label class="star" for="star4" title="Great" aria-hidden="true"></label>
                            <input type="radio" id="star3" name="rating" value="3"
                                {{ $oe->rating == 3 ? 'checked' : '' }}>
                            <label class="star" for="star3" title="Very good" aria-hidden="true"></label>
                            <input type="radio" id="star2" name="rating" value="2"
                                {{ $oe->rating == 2 ? 'checked' : '' }}>
                            <label class="star" for="star2" title="Good" aria-hidden="true"></label>
                            <input type="radio" id="star1" name="rating" value="1"
                                {{ $oe->rating == 1 ? 'checked' : '' }}>
                            <label class="star" for="star1" title="Bad" aria-hidden="true"></label>
                        </div>


                    </td>
                </tr> --}}
<tr>
    <th>Team Work</th>
    <td>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <style>
            .rating {
                border: none;
                float: left;
            }

            .rating>label {
                color: #90A0A3;
                float: right;
            }

            .rating>label:before {
                font-size: 1.5em;
                font-family: 'Font Awesome 5 Free';
                content: "\f005";
                display: inline-block;
            }

            .rating>input {
                display: none;
            }

            .rating>input:checked~label:before,
            .rating:not(:checked)>label:hover:before,
            .rating:not(:checked)>label:hover~label:before {
                color: #F79426;
            }

            .rating>input:checked+label:hover:before,
            .rating>input:checked~label:hover:before,
            .rating>label:hover~input:checked~label:before,
            .rating>input:checked~label:hover~label:before {
                color: #FECE31;
            }
        </style>

        <div class="rating">
            <input type="radio" id="team5" name="team_rating" value="5" {{ $oe->team_rating == 5 ? 'checked' : '' }}>
            <label class="star" for="team5" title="Awesome"></label>
            <input type="radio" id="team4" name="team_rating" value="4" {{ $oe->team_rating == 4 ? 'checked' : '' }}>
            <label class="star" for="team4" title="Great"></label>
            <input type="radio" id="team3" name="team_rating" value="3" {{ $oe->team_rating == 3 ? 'checked' : '' }}>
            <label class="star" for="team3" title="Very good"></label>
            <input type="radio" id="team2" name="team_rating" value="2" {{ $oe->team_rating == 2 ? 'checked' : '' }}>
            <label class="star" for="team2" title="Good"></label>
            <input type="radio" id="team1" name="team_rating" value="1" {{ $oe->team_rating == 1 ? 'checked' : '' }}>
            <label class="star" for="team1" title="Bad"></label>
        </div>
    </td>
</tr>

<tr>
    <th>Disciplinary Approach/Behavior</th>
    <td>
        <div class="rating">
            <input type="radio" id="discipline5" name="perception_about_size" value="5" {{ $oe->perception_about_size == 5 ? 'checked' : '' }}>
            <label class="star" for="discipline5" title="Excellent"></label>
            <input type="radio" id="discipline4" name="perception_about_size" value="4" {{ $oe->perception_about_size == 4 ? 'checked' : '' }}>
            <label class="star" for="discipline4" title="Very Good"></label>
            <input type="radio" id="discipline3" name="perception_about_size" value="3" {{ $oe->perception_about_size == 3 ? 'checked' : '' }}>
            <label class="star" for="discipline3" title="Good"></label>
            <input type="radio" id="discipline2" name="perception_about_size" value="2" {{ $oe->perception_about_size == 2 ? 'checked' : '' }}>
            <label class="star" for="discipline2" title="Fair"></label>
            <input type="radio" id="discipline1" name="perception_about_size" value="1" {{ $oe->perception_about_size == 1 ? 'checked' : '' }}>
            <label class="star" for="discipline1" title="Poor"></label>
        </div>
    </td>
</tr>

                {{-- <tr>
                    <th>Necessity of Helper</th>

                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Yes" id="flexCheckDefault"
                                name="necessity_of_helper" @if ($oe->necessity_of_helper == 'Yes') checked @endif>
                            <label class="form-check-label" for="flexCheckDefault">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="No"
                                id="flexCheckChecked"name="necessity_of_helper"
                                @if ($oe->necessity_of_helper == 'No') checked @endif>
                            <label class="form-check-label" for="flexCheckChecked">
                                No
                            </label>
                        </div>
                    </td>
                </tr> 
                <tr>
                    <th>Perception About Size</th>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Good" id="flexCheckDefault"
                                name="perception_about_size"@if ($oe->perception_about_size == 'Good') checked @endif>
                            <label class="form-check-label" for="flexCheckDefault">
                                Good
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Average" id="flexCheckChecked"
                                name="perception_about_size" @if ($oe->perception_about_size == 'Average') checked @endif>
                            <label class="form-check-label" for="flexCheckChecked">
                                Average
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="Not Satisfactory"
                                id="flexCheckDefault"
                                name="perception_about_size"@if ($oe->perception_about_size == 'Not Satisfactory') checked @endif>
                            <label class="form-check-label" for="flexCheckDefault">
                                Not Satisfactory
                            </label>
                        </div>
                    </td>--}}
                </tr>



            </table>
        </section>

        <a type="button" class="btn btn-lg btn-outline-info" href="{{ route('workerEntries.index') }}">Cancel</a>
        <x-backend.form.saveButton>Save</x-backend.form.saveButton>

    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        // $(document).ready(function() {
        //     // Attach an input event listener to each SMV input field
        //     $('.smv-input').on('input', function() {
        //         // Get the SMV value entered by the user
        //         var smv = parseFloat($(this).val());

        //         // Check if smv is a valid number
        //         if (!isNaN(smv) && smv > 0) {
        //             // Calculate the target value based on SMV
        //             var target = 60 / smv;

        //             // Round the target value using floor or ceiling
        //             var roundedTarget = (target % 1 >= 0.5) ? Math.ceil(target) : Math.floor(target);

        //             // Update the corresponding target input field
        //             $(this).closest('tr').find('.target-input').val(roundedTarget);
        //         } else {
        //             // If the input is invalid, clear the target input field
        //             $(this).closest('tr').find('.target-input').val('');
        //         }
        //     });
        // });


        // $(document).ready(function() {
        //     // Attach an input event listener to each production-achive input field
        //     $('.production-achive-input').on('input', function() {
        //         // Get the target value for this row
        //         var target = parseFloat($(this).closest('tr').find('[name="target[]"]').val());

        //         // Get the production-achive value entered by the user
        //         var production_achive = parseFloat($(this).val());

        //         // Get the capacity value for this row
        //         var capacity = parseFloat($(this).closest('tr').find('[name="capacity[]"]').val());

        //         // Check if production_achive is a valid number and target is a positive number
        //         if (!isNaN(production_achive) && production_achive >= 0 && !isNaN(target) && target > 0) {
        //             // Calculate the efficiency value based on production_achive and target
        //             var efficiency = (production_achive / target) * 100;

        //             // Update the corresponding efficiency input field
        //             $(this).closest('tr').find('.efficiency-input').val(efficiency.toFixed(2));
        //         } else {
        //             // If the input is invalid, clear the efficiency input field
        //             $(this).closest('tr').find('.efficiency-input').val('');
        //         }

        //         // // Check if capacity is a valid number and target is a positive number
        //         // if (!isNaN(capacity) && capacity > 0 && !isNaN(target) && target > 0) {
        //         //     // Calculate the efficiency value based on production_achive and target
        //         //     var efficiency = (capacity / target) * 100;

        //         //     // Update the corresponding efficiency input field
        //         //     $(this).closest('tr').find('.efficiency-input').val(efficiency.toFixed(2));
        //         // } else {
        //         //     // If the input is invalid, clear the efficiency input field
        //         //     $(this).closest('tr').find('.efficiency-input').val('');
        //         // }
        //     });
        // });

        $(document).ready(function() {
            // Attach an input event listener to each SMV input field
            $('.smv-input').on('input', function() {
                // Get the SMV value directly from the value attribute
                var smv = parseFloat($(this).attr('value')); // Reading value attribute directly

                // Check if smv is a valid number
                if (!isNaN(smv) && smv > 0) {
                    // Calculate the target value based on SMV
                    var target = 60 / smv;

                    // Round the target value using floor or ceiling
                    var roundedTarget = (target % 1 >= 0.5) ? Math.ceil(target) : Math.floor(target);

                    // Update the corresponding target input field
                    $(this).closest('tr').find('.target-input').val(roundedTarget);
                } else {
                    // If the input is invalid, clear the target input field
                    $(this).closest('tr').find('.target-input').val('');
                }
            });


            // Attach input event listeners to capacity and target input fields
            $('.capacity-input, .target-input').on('input', function() {
                // Get the capacity value for this row
                var capacity = parseFloat($(this).closest('tr').find('.capacity-input').val());

                // Get the target value for this row
                var target = parseFloat($(this).closest('tr').find('.target-input').val());

                // Check if capacity and target are valid numbers
                if (!isNaN(capacity) && capacity > 0 && !isNaN(target) && target > 0) {
                    // Calculate the efficiency value
                    var efficiency = (capacity / target) * 100;

                    // Update the corresponding efficiency input field
                    $(this).closest('tr').find('.efficiency-input').val(efficiency.toFixed(2));
                } else {
                    // If the input is invalid, clear the efficiency input field
                    $(this).closest('tr').find('.efficiency-input').val('');
                }
            });

            // Optional: If the capacity or target changes programmatically, re-trigger the calculation
            $('.capacity-input, .target-input').trigger('input');
        });
    </script>
</x-backend.layouts.master>
