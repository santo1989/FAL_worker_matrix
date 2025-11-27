<x-backend.layouts.master>

    <x-slot name="pageTitle">Exam Candidate Details</x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Exam Candidate Details </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('exam.index') }}">Exam Candidates</a></li>
            <li class="breadcrumb-item active">Details</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4>Candidate #{{ $candidate->id }} - {{ $candidate->name }}</h4>
                    <div class="float-end">
                        <a href="{{ route('exam.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
                        <a href="{{ route('exam.process_entry_form', $candidate->id) }}"
                            class="btn btn-info btn-sm">Edit Processes</a>
                        <a href="{{ route('exam.cyclesData_entry_form', $candidate->id) }}"
                            class="btn btn-warning btn-sm">Cycles</a>
                        <a href="{{ route('exam.matrixData_entry_form', $candidate->id) }}"
                            class="btn btn-success btn-sm">Matrix</a>
                        @php
                            $canPromote =
                                $candidate->exam_passed &&
                                (!isset($approval) || ($approval && $approval->status !== 'approved'));
                        @endphp
                        @if ($canPromote)
                            @can('create', \App\Models\ExamApproval::class)
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#promoteModal">Promote to Worker</button>
                            @endcan
                        @else
                            @if (isset($approval) && $approval->status === 'approved')
                                <span class="badge bg-success">Promoted</span>
                            @elseif (isset($approval) && $approval->status === 'pending')
                                <span class="badge bg-warning">Promotion Pending</span>
                                @if (isset($approval) && $approval->status === 'pending')
                                    @can('approve', $approval)
                                        <div class="mt-2">
                                            <form method="POST"
                                                action="{{ route('exam.approvals.approve', $approval->id) }}"
                                                style="display:inline-block">
                                                @csrf
                                                <button class="btn btn-sm btn-success">Approve</button>
                                            </form>
                                            <form method="POST"
                                                action="{{ route('exam.approvals.reject', $approval->id) }}"
                                                style="display:inline-block; margin-left:8px;">
                                                @csrf
                                                <button class="btn btn-sm btn-danger">Reject</button>
                                            </form>
                                        </div>
                                    @endcan
                                @endif
                            @endif
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>NID:</strong> {{ $candidate->nid }}
                        </div>
                        <div class="col-md-4">
                            <strong>Exam Date:</strong> {{ $candidate->examination_date }}
                        </div>
                        <div class="col-md-4">
                            <strong>Passed:</strong> {{ $candidate->exam_passed ? 'Yes' : 'No' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h5>Result</h5>
                            @if ($result)
                                <div class="badge btn-warning">{{ $result['grade'] }}
                                    <button type="button" class="btn  btn-sm ms-3" data-bs-toggle="modal"
                                        data-bs-target="#gradeModal">
                                        View Grade Details
                                    </button>

                                </div>
                                @if (isset($result['salary_range']))
                                    @php
                                        $rs = $result['salary_range'];
                                        if (is_array($rs)) {
                                            $nums = array_values(array_filter($rs, 'is_numeric'));
                                            if (count($nums) === 2) {
                                                $salaryDisplay = $nums[0] . ' - ' . $nums[1];
                                            } elseif (count($nums) > 0) {
                                                $salaryDisplay = round(array_sum($nums) / count($nums), 2);
                                            } else {
                                                $salaryDisplay = json_encode($rs);
                                            }
                                        } else {
                                            $salaryDisplay = $rs;
                                        }
                                    @endphp
                                    <div class="mt-1"><strong>Recommended Salary:</strong>
                                        {{ $salaryDisplay }} TK
                                    </div>
                                @endif
                            @else
                                <p>No result data yet.</p>
                            @endif
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-md-12">
                            <h5>Process Entries</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Process Type</th>
                                        <th>Process Name</th>
                                        <th>Avg Cycles (min)</th>
                                        <th>SMV</th>
                                        <th>Target</th>
                                        <th>Capacity</th>
                                        <th>Self Prod</th>
                                        <th>Achieved</th>
                                        <th>Efficiency</th>
                                        <th>Cycles Logs</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0; @endphp
                                    @foreach ($entries as $entry)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $entry->sewing_process_type }}</td>
                                            <td>{{ $entry->sewing_process_name }}</td>
                                            <td>{{ $entry->sewing_process_avg_cycles }}</td>
                                            <td>{{ $entry->smv }}</td>
                                            <td>{{ $entry->target }}</td>
                                            <td>{{ $entry->capacity }}</td>
                                            <td>{{ $entry->self_production }}</td>
                                            <td>{{ $entry->achive_production }}</td>
                                            <td>{{ $entry->efficiency }}</td>
                                            <td>
                                                @if ($entry->cycles && $entry->cycles->count())
                                                    <button class="btn btn-sm btn-outline-secondary" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#cycles_{{ $entry->id }}">Show</button>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                        @if ($entry->cycles && $entry->cycles->count())
                                            <tr class="collapse" id="cycles_{{ $entry->id }}">
                                                <td colspan="11">
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Start</th>
                                                                <th>End</th>
                                                                <th>Duration (s)</th>
                                                                <th>Rejected</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($entry->cycles as $ci => $cycle)
                                                                <tr>
                                                                    <td>{{ $ci + 1 }}</td>
                                                                    <td>{{ $cycle->start_time }}</td>
                                                                    <td>{{ $cycle->end_time }}</td>
                                                                    <td>{{ $cycle->duration }}</td>
                                                                    <td>{{ $cycle->rejectDataStatus ? 'Yes' : 'No' }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</x-backend.layouts.master>

<!-- Grade Details Modal -->
@if ($result)
    <div class="modal fade" id="gradeModal" tabindex="-1" aria-labelledby="gradeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gradeModalLabel">Grade Details for {{ $candidate->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">Grade Criteria</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Grade</th>
                                    <th class="text-center">Min MC Run Cap.</th>
                                    <th>Required Process Status</th>
                                    <th class="text-center">Min Process Count</th>
                                    <th class="text-center">Performance Range (Efficiency)</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>A++</td>
                                    <td class="text-center">-</td>
                                    <td>critical</td>
                                    <td class="text-center">All critical</td>
                                    <td class="text-center">&gt;= 90</td>
                                    <td>Must have every critical process</td>
                                </tr>
                                <tr>
                                    <td>A+</td>
                                    <td class="text-center">-</td>
                                    <td>critical</td>
                                    <td class="text-center">3</td>
                                    <td class="text-center">&gt;= 75</td>
                                    <td>High performance on critical ops</td>
                                </tr>
                                <tr>
                                    <td>A</td>
                                    <td class="text-center">-</td>
                                    <td>critical</td>
                                    <td class="text-center">3</td>
                                    <td class="text-center">&gt;= 70</td>
                                    <td>Strong critical performance</td>
                                </tr>
                                <tr>
                                    <td>A+</td>
                                    <td class="text-center">2</td>
                                    <td>normal / semi-critical / critical</td>
                                    <td class="text-center">1</td>
                                    <td class="text-center">&gt;= 75</td>
                                    <td>Multi-machine capability (2)</td>
                                </tr>
                                <tr>
                                    <td>A</td>
                                    <td class="text-center">1</td>
                                    <td>critical</td>
                                    <td class="text-center">1</td>
                                    <td class="text-center">&gt;= 70</td>
                                    <td>Single-machine critical</td>
                                </tr>
                                <tr>
                                    <td>B+</td>
                                    <td class="text-center">-</td>
                                    <td>semi-critical / critical</td>
                                    <td class="text-center">3</td>
                                    <td class="text-center">&gt;= 65</td>
                                    <td>Requires mix of semi & critical</td>
                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td class="text-center">-</td>
                                    <td>semi-critical</td>
                                    <td class="text-center">2</td>
                                    <td class="text-center">&gt;= 60</td>
                                    <td>Moderate semi-critical performance</td>
                                </tr>
                                <tr>
                                    <td>C++</td>
                                    <td class="text-center">-</td>
                                    <td>normal (no semi-critical)</td>
                                    <td class="text-center">3</td>
                                    <td class="text-center">&gt;= 80</td>
                                    <td>High efficiency on normal ops, no semi-critical</td>
                                </tr>
                                <tr>
                                    <td>C++</td>
                                    <td class="text-center">-</td>
                                    <td>normal / semi-critical</td>
                                    <td class="text-center">2</td>
                                    <td class="text-center">&gt;= 80</td>
                                    <td>High normal ops with some semi-critical</td>
                                </tr>
                                <tr>
                                    <td>C+</td>
                                    <td class="text-center">-</td>
                                    <td>normal</td>
                                    <td class="text-center">2</td>
                                    <td class="text-center">70 - 79</td>
                                    <td>Above average normal ops</td>
                                </tr>
                                <tr>
                                    <td>C</td>
                                    <td class="text-center">-</td>
                                    <td>normal</td>
                                    <td class="text-center">2</td>
                                    <td class="text-center">60 - 69</td>
                                    <td>Average normal ops</td>
                                </tr>
                                <tr>
                                    <td>F</td>
                                    <td class="text-center">-</td>
                                    <td>-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">N/A</td>
                                    <td>Default / no matching criteria</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    </div>
@endif

<!-- Promote to Worker Modal -->
@if ($result && $candidate->exam_passed)
    <div class="modal fade" id="promoteModal" tabindex="-1" aria-labelledby="promoteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="promoteModalLabel">Promote {{ $candidate->name }} to Worker</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('exam.request_add_to_worker', $candidate->id) }}">
                    @csrf
                    @php
                        // Compute recommended numeric salary for JS and hidden input
                        $recommendedNumeric = null;
                        $rec = $result['salary_range'] ?? null;
                        if ($rec) {
                            if (is_array($rec)) {
                                $nums = array_values(array_filter($rec, 'is_numeric'));
                                if (!empty($nums)) {
                                    $recommendedNumeric = round(array_sum($nums) / count($nums), 2);
                                }
                            } elseif (is_numeric($rec)) {
                                $recommendedNumeric = round($rec, 2);
                            }
                        }
                        // Prepare a display string for the modal recommended salary
                        if (isset($rec)) {
                            if (is_array($rec)) {
                                $nums2 = array_values(array_filter($rec, 'is_numeric'));
                                if (count($nums2) === 2) {
                                    $modalRecDisplay = $nums2[0] . ' - ' . $nums2[1];
                                } elseif (count($nums2) > 0) {
                                    $modalRecDisplay = round(array_sum($nums2) / count($nums2), 2);
                                } else {
                                    $modalRecDisplay = json_encode($rec);
                                }
                            } else {
                                $modalRecDisplay = $rec;
                            }
                        } else {
                            $modalRecDisplay = 'N/A';
                        }
                    @endphp

                    <input type="hidden" name="hidden_requested_salary" id="hidden_requested_salary"
                        value="{{ $recommendedNumeric ?? '' }}">
                    <div class="modal-body">
                        <p><strong>Grade:</strong> {{ $result['grade'] }}</p>
                        <p><strong>Recommended Salary:</strong> {{ $modalRecDisplay }} TK</p>

                        <div class="mb-3">
                            <label class="form-label">Choose action</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type" id="type_agreed"
                                        value="agreed" checked>
                                    <label class="form-check-label" for="type_agreed">Agree with recommended
                                        salary</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="type"
                                        id="type_negotiation" value="negotiation">
                                    <label class="form-check-label" for="type_negotiation">Negotiate salary</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 d-none" id="negotiation_input_wrapper">
                            <label for="requested_salary" class="form-label">Negotiated Salary (TK)</label>
                            <input type="number" step="0.01" class="form-control" name="requested_salary"
                                id="requested_salary" placeholder="Enter negotiated salary">
                            @php
                                $rec = $result['salary_range'] ?? null;
                                if (is_array($rec)) {
                                    $nums = array_values(array_filter($rec, 'is_numeric'));
                                    if (count($nums) === 2) {
                                        $recDisplay = $nums[0] . ' - ' . $nums[1];
                                    } elseif (count($nums) > 0) {
                                        $recDisplay = round(array_sum($nums) / count($nums), 2);
                                    } else {
                                        $recDisplay = json_encode($rec);
                                    }
                                } else {
                                    $recDisplay = $rec ?? 'N/A';
                                }
                            @endphp
                            <div class="form-text">Recommended: {{ $recDisplay }} TK</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit for Approval</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const agreed = document.getElementById('type_agreed');
            const neg = document.getElementById('type_negotiation');
            const wrapper = document.getElementById('negotiation_input_wrapper');
            const hiddenSalary = document.getElementById('hidden_requested_salary');
            const negotiationInput = document.getElementById('requested_salary');
            const recommendedNumeric = {!! json_encode($recommendedNumeric) !!};

            function toggle() {
                if (neg.checked) {
                    wrapper.classList.remove('d-none');
                    // use negotiation input value (if any)
                    hiddenSalary.value = negotiationInput.value || '';
                } else {
                    wrapper.classList.add('d-none');
                    // agree -> set to recommended numeric (may be empty)
                    hiddenSalary.value = recommendedNumeric !== null ? recommendedNumeric : '';
                }
            }

            // update hidden when negotiation input changes
            negotiationInput && negotiationInput.addEventListener('input', function() {
                if (neg.checked) {
                    hiddenSalary.value = this.value || '';
                }
            });

            agreed.addEventListener('change', toggle);
            neg.addEventListener('change', toggle);

            // initialize on load
            toggle();
        })();
    </script>
@endif
