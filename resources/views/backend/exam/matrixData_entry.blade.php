<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Operator Assessment Sheet-4
    </x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Operator Assessment Sheet-Operation Entry </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('exam.index') }}">Exam</a>
            </li>
            <li class="breadcrumb-item active">Operator Assessment Sheet-4</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>


    <x-backend.layouts.elements.errors />

    <form action="{{ route('exam.matrixData_store') }}" method="post" enctype="multipart/form-data">
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
                        <th scope="col">Efficiency</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($entries as $oe)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ strtoupper($oe->sewing_process_type) }}</td>
                            <td>
                                @php
                                    $machineType = App\Models\SewingProcessList::where(
                                        'id',
                                        $oe->sewing_process_list_id,
                                    )->first();
                                @endphp
                                {{ $machineType->machine_type ?? '' }}
                            </td>
                            <td> {{ ucwords($oe->sewing_process_name) }}</td>
                            <td>
                                @php
                                    $smv = App\Models\SewingProcessList::where('id', $oe->sewing_process_list_id)
                                        ->pluck('smv')
                                        ->first();

                                    if ($oe->smv == null) {
                                        $smv = number_format($smv ?? 0, 2);
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
                                        $target = number_format($standard_capacity ?? 0, 0);
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
                                            $roundedCapacity = ceil($capacity);
                                        } else {
                                            $roundedCapacity = floor($capacity);
                                        }
                                    } else {
                                        $roundedCapacity = '';
                                    }
                                @endphp
                                <input type="text" name="capacity[]" id="capacity" value="{{ $roundedCapacity }}"
                                    class="form-control capacity-input" readonly>
                            </td>

                            <input type="hidden" name="production_self[]" value="{{ $oe->self_production ?? '' }}"
                                class="form-control production-self-input">
                            <input type="hidden" name="production_achive[]" value="{{ $oe->achive_production ?? '' }}"
                                class="form-control production-achive-input">

                            <td>
                                <input type="text" name="efficiency[]"
                                    value="{{ number_format($oe->efficiency, 2) }}"
                                    class="form-control efficiency-input" readonly>
                            </td>
                            <input type="hidden" name="candidate_id"
                                value="{{ $oe->exam_candidate_id ?? $candidate->id }}">
                            <input type="hidden" name="operation_id[]" value="{{ $oe->id }}">
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <section class="content">
            <table class="table table-borderless">
                <tr>
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
                        </style>

                        <div class="rating">
                            <input type="radio" id="team5" name="team_rating" value="5"
                                {{ $entries[0]->team_rating ?? '' == 5 ? 'checked' : '' }}>
                            <label class="star" for="team5" title="Awesome"></label>
                            <input type="radio" id="team4" name="team_rating" value="4"
                                {{ $entries[0]->team_rating ?? '' == 4 ? 'checked' : '' }}>
                            <label class="star" for="team4" title="Great"></label>
                            <input type="radio" id="team3" name="team_rating" value="3"
                                {{ $entries[0]->team_rating ?? '' == 3 ? 'checked' : '' }}>
                            <label class="star" for="team3" title="Very good"></label>
                            <input type="radio" id="team2" name="team_rating" value="2"
                                {{ $entries[0]->team_rating ?? '' == 2 ? 'checked' : '' }}>
                            <label class="star" for="team2" title="Good"></label>
                            <input type="radio" id="team1" name="team_rating" value="1"
                                {{ $entries[0]->team_rating ?? '' == 1 ? 'checked' : '' }}>
                            <label class="star" for="team1" title="Bad"></label>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th>Disciplinary Approach/Behavior</th>
                    <td>
                        <div class="rating">
                            <input type="radio" id="discipline5" name="perception_about_size" value="5"
                                {{ $entries[0]->perception_about_size ?? '' == 5 ? 'checked' : '' }}>
                            <label class="star" for="discipline5" title="Excellent"></label>
                            <input type="radio" id="discipline4" name="perception_about_size" value="4"
                                {{ $entries[0]->perception_about_size ?? '' == 4 ? 'checked' : '' }}>
                            <label class="star" for="discipline4" title="Very Good"></label>
                            <input type="radio" id="discipline3" name="perception_about_size" value="3"
                                {{ $entries[0]->perception_about_size ?? '' == 3 ? 'checked' : '' }}>
                            <label class="star" for="discipline3" title="Good"></label>
                            <input type="radio" id="discipline2" name="perception_about_size" value="2"
                                {{ $entries[0]->perception_about_size ?? '' == 2 ? 'checked' : '' }}>
                            <label class="star" for="discipline2" title="Fair"></label>
                            <input type="radio" id="discipline1" name="perception_about_size" value="1"
                                {{ $entries[0]->perception_about_size ?? '' == 1 ? 'checked' : '' }}>
                            <label class="star" for="discipline1" title="Poor"></label>
                        </div>
                    </td>
                </tr>
            </table>
        </section>

        <a type="button" class="btn btn-lg btn-outline-info" href="{{ route('exam.index') }}">Cancel</a>
        <x-backend.form.saveButton id="save-button">Save</x-backend.form.saveButton>

    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Attach an input event listener to each SMV input field
            $('.smv-input').on('input', function() {
                var smv = parseFloat($(this).attr('value'));
                if (!isNaN(smv) && smv > 0) {
                    var target = 60 / smv;
                    var roundedTarget = (target % 1 >= 0.5) ? Math.ceil(target) : Math.floor(target);
                    $(this).closest('tr').find('.target-input').val(roundedTarget);
                } else {
                    $(this).closest('tr').find('.target-input').val('');
                }
            });

            $('.capacity-input, .target-input').on('input', function() {
                var capacity = parseFloat($(this).closest('tr').find('.capacity-input').val());
                var target = parseFloat($(this).closest('tr').find('.target-input').val());
                if (!isNaN(capacity) && capacity > 0 && !isNaN(target) && target > 0) {
                    var efficiency = (capacity / target) * 100;
                    $(this).closest('tr').find('.efficiency-input').val(efficiency.toFixed(2));
                } else {
                    $(this).closest('tr').find('.efficiency-input').val('');
                }
            });

            $('.capacity-input, .target-input').trigger('input');

            $('#save-button').on('click', function() {
                $('button').not(this).hide();
            });
        });
    </script>
</x-backend.layouts.master>
