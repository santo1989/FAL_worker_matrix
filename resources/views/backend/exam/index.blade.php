<x-backend.layouts.master>

    <x-slot name="pageTitle">Exam Candidate List</x-slot>

    <x-slot name='breadCrumb'>
        <x-backend.layouts.elements.breadcrumb>
            <x-slot name="pageHeader"> Exam Candidate List </x-slot>
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Exam Candidate List</li>
        </x-backend.layouts.elements.breadcrumb>
    </x-slot>

    <section class="content">
        <div class="container-fluid">
            @if (is_null($candidates) || $candidates->isEmpty())
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-danger"><strong>No Exam Candidates found.</strong></h1>
                        @can('Admin')
                            <a href="{{ route('exam.create') }}" class="btn btn-primary mt-3">Create Candidate</a>
                        @endcan
                        <a type="button" class="btn btn-secondary mt-3" href="{{ route('exam.index') }}">Reload
                            Page</a>
                    </div>
                </div>
            @else
                @if (session('message'))
                    <div class="alert alert-success">
                        <span class="close" data-dismiss="alert">&times;</span>
                        <strong>{{ session('message') }}</strong>
                    </div>
                @endif

                <div class="card" style="overflow-x: auto;">
                    <div class="card-header">
                        <form method="GET" action="{{ route('exam.index') }}" id="examFilterForm">
                            @php
                                // Get process list for filters (use actual column names)
                                $processData = DB::table('sewing_process_lists')
                                    ->select('process_type', 'process_name')
                                    ->distinct()
                                    ->get();
                            @endphp

                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label class="form-label">Process Type</label>
                                    <select name="process_type" class="form-control select2">
                                        <option value="">All</option>
                                        @foreach ($processData->unique('process_type') as $item)
                                            <option value="{{ $item->process_type }}"
                                                {{ request('process_type') == $item->process_type ? 'selected' : '' }}>
                                                {{ $item->process_type }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Process Name</label>
                                    <select name="process_name" class="form-control select2">
                                        <option value="">All</option>
                                        @foreach ($processData->unique('process_name') as $item)
                                            <option value="{{ $item->process_name }}"
                                                {{ request('process_name') == $item->process_name ? 'selected' : '' }}>
                                                {{ $item->process_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label">Passed</label>
                                    <select name="exam_passed" class="form-control">
                                        <option value="">All</option>
                                        <option value="1" {{ request('exam_passed') === '1' ? 'selected' : '' }}>
                                            Yes</option>
                                        <option value="0" {{ request('exam_passed') === '0' ? 'selected' : '' }}>
                                            No</option>
                                    </select>
                                </div>
                                <!--search by NID or Name-->
                                <div class="col-md-2">
                                    <label class="form-label">Search by NID or Name</label>
                                    <input type="text" name="search" class="form-control"
                                        value="{{ request('search') }}" placeholder="Enter NID or Name">
                                </div>


                                <div class="col-md-2 text-end mt-4">
                                    <button type="submit" class="btn btn-outline-info btn-sm"><i
                                            class="fa fa-search"></i> Search</button>
                                    <a href="{{ route('exam.index') }}" class="btn btn-outline-danger btn-sm"><i
                                            class="fa fa-refresh"></i> Reset</a>

                                    <a href="{{ route('exam.create') }}" class="btn btn-primary btn-sm">Start New
                                        Candidate Exam</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Sl#</th>
                                    <th>ID</th>
                                    <th>NID</th>
                                    <th>Name</th>
                                    <th>Exam Date</th>
                                    <th>Processes</th>
                                    <th>Result Grade</th>
                                    <th>Passed</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $sl = 0; @endphp
                                @foreach ($candidates as $cand)
                                    @php
                                        // fetch process entries for this candidate
                                        $entries = DB::table('exam_process_entries')
                                            ->where('exam_candidate_id', $cand->id)
                                            ->get();

                                        // derive a compact grade from stored result_data if available
                                        $result = null;
                                        if (!empty($cand->result_data)) {
                                            // result_data may already be decoded (array) or stored as JSON string
                                            if (is_string($cand->result_data)) {
                                                $resultArr = json_decode($cand->result_data, true);
                                            } elseif (is_array($cand->result_data)) {
                                                $resultArr = $cand->result_data;
                                            } else {
                                                $resultArr = null;
                                            }

                                            if (is_array($resultArr)) {
                                                $result = $resultArr['grade'] ?? null;
                                            }
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ ++$sl }}</td>
                                        <td>{{ $cand->id }}</td>
                                        <td>{{ $cand->nid }}</td>
                                        <td>{{ $cand->name }}</td>
                                        <td>{{ $cand->examination_date }}</td>
                                        <td>
                                            <ol>
                                                @foreach ($entries as $e)
                                                    <li>{{ ucwords($e->sewing_process_name) }}
                                                        ({{ $e->sewing_process_type }})
                                                    </li>
                                                @endforeach
                                            </ol>
                                        </td>
                                        <td>{{ $result ?? '-' }}</td>
                                        <td>{{ $cand->exam_passed ? 'Yes' : 'No' }}</td>
                                        <td>
                                            @php
                                                // fetch latest approval for this candidate and check promoted state
                                                $approval = \App\Models\ExamApproval::where(
                                                    'exam_candidate_id',
                                                    $cand->id,
                                                )
                                                    ->latest()
                                                    ->first();
                                                $isPromoted = $approval && $approval->status === 'approved';
                                                $isDisagreed = $approval && $approval->type === 'disagree';
                                                $canPromote = $cand->exam_passed && !$isPromoted && !$isDisagreed;

                                                // find worker entry if already promoted (match by id_card_no -> nid)
                                                $worker = null;
                                                if ($isPromoted) {
                                                    $worker = \App\Models\WorkerEntry::where('id_card_no', $cand->nid)
                                                        ->latest()
                                                        ->first();
                                                }
                                            @endphp

                                            @if ($isPromoted)
                                                <a href="{{ route('exam.show', $cand->id) }}"
                                                    class="btn btn-sm btn-secondary">Show</a>
                                                @if ($worker)
                                                    <a href="{{ route('workerEntries.show', $worker->id) }}"
                                                        class="btn btn-sm btn-success">View Worker</a>
                                                @else
                                                    <span class="badge bg-success ms-2">Promoted</span>
                                                @endif
                                            @elseif ($isDisagreed)
                                                <a href="{{ route('exam.show', $cand->id) }}"
                                                    class="btn btn-sm btn-secondary">Show</a>
                                                <span class="badge bg-danger ms-2">Disagreed
                                                    @php
                                                        $maxSalary =
                                                            $approval->requested_salary ??
                                                            ($approval->recommended_salary ?? 'N/A');
                                                    @endphp
                                                    (Max Salary: {{ $maxSalary }} TK)</span>
                                            @elseif (!$cand->exam_passed)
                                                <a href="{{ route('exam.show', $cand->id) }}"
                                                    class="btn btn-sm btn-secondary">Show</a>
                                                {{-- @can('Admin')
                                                    <form method="POST" action="{{ route('exam.destroy', $cand->id) }}"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Delete candidate and all related exam data?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                @endcan --}}
                                            @else
                                                <a href="{{ route('exam.show', $cand->id) }}"
                                                    class="btn btn-sm btn-secondary">Show</a>
                                                <a href="{{ route('exam.process_entry_form', $cand->id) }}"
                                                    class="btn btn-sm btn-info">Process</a>
                                                <a href="{{ route('exam.cyclesData_entry_form', $cand->id) }}"
                                                    class="btn btn-sm btn-warning">Cycles</a>
                                                <a href="{{ route('exam.matrixData_entry_form', $cand->id) }}"
                                                    class="btn btn-sm btn-success">Matrix</a>
                                                @if ($canPromote)
                                                    @can('create', \App\Models\ExamApproval::class)
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#promoteModal-{{ $cand->id }}">Promote to
                                                            Worker</button>
                                                    @endcan
                                                @endif
                                            @endif

                                            <!-- Promote to Worker Modal -->
                                            @if ($result && $cand->exam_passed)
                                                <div class="modal fade" id="promoteModal-{{ $cand->id }}"
                                                    tabindex="-1"
                                                    aria-labelledby="promoteModalLabel-{{ $cand->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="promoteModalLabel">Promote
                                                                    {{ $cand->name }} to Worker</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form method="POST"
                                                                action="{{ route('exam.request_add_to_worker', $cand->id) }}">
                                                                @csrf
                                                                @php
                                                                    // Compute recommended numeric salary for JS and hidden input
                                                                    $recommendedNumeric = null;
                                                                    $rec = $cand->result_data['salary_range'] ?? null;
                                                                    if ($rec) {
                                                                        if (is_array($rec)) {
                                                                            $nums = array_values(
                                                                                array_filter($rec, 'is_numeric'),
                                                                            );
                                                                            if (!empty($nums)) {
                                                                                $recommendedNumeric = round(
                                                                                    array_sum($nums) / count($nums),
                                                                                    2,
                                                                                );
                                                                            }
                                                                        } elseif (is_numeric($rec)) {
                                                                            $recommendedNumeric = round($rec, 2);
                                                                        }
                                                                    }
                                                                    // Prepare a display string for the modal recommended salary
                                                                    if (isset($rec)) {
                                                                        if (is_array($rec)) {
                                                                            $nums2 = array_values(
                                                                                array_filter($rec, 'is_numeric'),
                                                                            );
                                                                            if (count($nums2) === 2) {
                                                                                $modalRecDisplay =
                                                                                    $nums2[0] . ' - ' . $nums2[1];
                                                                            } elseif (count($nums2) > 0) {
                                                                                $modalRecDisplay = round(
                                                                                    array_sum($nums2) / count($nums2),
                                                                                    2,
                                                                                );
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

                                                                <input type="hidden" name="hidden_requested_salary"
                                                                    id="hidden_requested_salary_{{ $cand->id }}"
                                                                    value="{{ $recommendedNumeric ?? '' }}">
                                                                <div class="modal-body">
                                                                    <p><strong>Grade:</strong>
                                                                        {{ $cand->result_data['grade'] }}</p>
                                                                    <p><strong>Recommended Salary:</strong>
                                                                        {{ $modalRecDisplay }} TK</p>

                                                                    <div class="form-group col-md-6 col-sm-12">
                                                                        <label
                                                                            for="floor_{{ $cand->id }}">Floor</label>
                                                                        @php
                                                                            $selectedFloor = optional($worker)->floor;
                                                                        @endphp
                                                                        <select name="floor"
                                                                            id="floor_{{ $cand->id }}"
                                                                            class="form-control" required>
                                                                            <option value="">Select Floor
                                                                            </option>
                                                                            <option value="1st Floor"
                                                                                {{ $selectedFloor === '1st Floor' ? 'selected' : '' }}>
                                                                                1st Floor</option>
                                                                            <option value="2nd Floor"
                                                                                {{ $selectedFloor === '2nd Floor' ? 'selected' : '' }}>
                                                                                2nd Floor</option>
                                                                            <option value="3rd Floor"
                                                                                {{ $selectedFloor === '3rd Floor' ? 'selected' : '' }}>
                                                                                3rd Floor</option>
                                                                            <option value="4th Floor"
                                                                                {{ $selectedFloor === '4th Floor' ? 'selected' : '' }}>
                                                                                4th Floor</option>
                                                                            <option value="5th Floor"
                                                                                {{ $selectedFloor === '5th Floor' ? 'selected' : '' }}>
                                                                                5th Floor</option>
                                                                        </select>

                                                                    </div>
                                                                    <br>
                                                                    <!-- line -->
                                                                    <div class="form-group col-md-6 col-sm-12">
                                                                        <label
                                                                            for="line_{{ $cand->id }}">Line</label>
                                                                        <input type="text" name="line"
                                                                            id="line_{{ $cand->id }}"
                                                                            class="form-control" required
                                                                            placeholder="Enter Line"
                                                                            value="{{ optional($worker)->line ?? '' }}">
                                                                    </div>
                                                                    <br>


                                                                    <div class="mb-3">
                                                                        <label class="form-label">Choose action</label>
                                                                        <div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input"
                                                                                    type="radio" name="type"
                                                                                    id="type_agreed_{{ $cand->id }}"
                                                                                    value="agreed" checked>
                                                                                <label class="form-check-label"
                                                                                    for="type_agreed_{{ $cand->id }}">Agree
                                                                                    with
                                                                                    recommended
                                                                                    salary</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input"
                                                                                    type="radio" name="type"
                                                                                    id="type_negotiation_{{ $cand->id }}"
                                                                                    value="negotiation">
                                                                                <label class="form-check-label"
                                                                                    for="type_negotiation_{{ $cand->id }}">Negotiate
                                                                                    salary</label>
                                                                            </div>
                                                                            <!-- Special Case for Add any salary input -->
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input"
                                                                                    type="radio" name="type"
                                                                                    id="type_Special_Case_salary_{{ $cand->id }}"
                                                                                    value="Special_Case_salary">
                                                                                <label class="form-check-label"
                                                                                    for="type_Special_Case_salary_{{ $cand->id }}">Special
                                                                                    Case Salary</label>
                                                                            </div>
                                                                            <!-- Disagree Case for no approval need and Promote to Worker Button not show, shows red dissagree with max salary badge  -->
                                                                            <div class="form-check form-check-inline">
                                                                                <input class="form-check-input"
                                                                                    type="radio" name="type"
                                                                                    id="type_disagree_{{ $cand->id }}"
                                                                                    value="disagree">
                                                                                <label class="form-check-label"
                                                                                    for="type_disagree_{{ $cand->id }}">Disagree</label>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    <div class="mb-3 d-none"
                                                                        id="negotiation_input_wrapper_{{ $cand->id }}">
                                                                        <label for="requested_salary"
                                                                            class="form-label">Negotiated Salary
                                                                            (TK)</label>

                                                                        @php
                                                                            // compute max allowed negotiated salary = floor(recommended + 3%)
                                                                            $rec =
                                                                                $cand->result_data['salary_range'] ??
                                                                                null;
                                                                            $recNumeric = $recommendedNumeric ?? null;
                                                                            $maxNegotiated = null;
                                                                            if (is_numeric($recNumeric)) {
                                                                                $maxNegotiated = (int) floor(
                                                                                    $recNumeric + $recNumeric * 0.03,
                                                                                );
                                                                            }
                                                                            if (is_array($rec)) {
                                                                                $nums = array_values(
                                                                                    array_filter($rec, 'is_numeric'),
                                                                                );
                                                                                if (count($nums) === 2) {
                                                                                    $recDisplay =
                                                                                        $nums[0] . ' - ' . $nums[1];
                                                                                } elseif (count($nums) > 0) {
                                                                                    $recDisplay = round(
                                                                                        array_sum($nums) / count($nums),
                                                                                        2,
                                                                                    );
                                                                                } else {
                                                                                    $recDisplay = json_encode($rec);
                                                                                }
                                                                            } else {
                                                                                $recDisplay = $rec ?? 'N/A';
                                                                            }
                                                                        @endphp
                                                                        <div class="form-text">Recommended:
                                                                            {{ $recDisplay }} TK</div>
                                                                        @if ($maxNegotiated)
                                                                            <div class="form-text text-muted">Max
                                                                                allowed negotiated salary:
                                                                                {{ $maxNegotiated }} TK</div>
                                                                        @endif
                                                                        <input type="number" step="0.01"
                                                                            class="form-control"
                                                                            name="requested_salary"
                                                                            id="requested_salary_{{ $cand->id }}"
                                                                            placeholder="Enter negotiated salary"
                                                                            max="{{ $maxNegotiated }}">
                                                                    </div>
                                                                    <div class="mb-3 d-none"
                                                                        id="Special_Case_input_wrapper_{{ $cand->id }}">
                                                                        <label
                                                                            for="Special_Case_salary_{{ $cand->id }}"
                                                                            class="form-label">Special Case Salary
                                                                            (TK)</label>
                                                                        <input type="number" step="0.01"
                                                                            class="form-control"
                                                                            name="Special_Case_salary"
                                                                            id="Special_Case_salary_{{ $cand->id }}"
                                                                            placeholder="Enter Special Case salary">
                                                                        <label
                                                                            for="Special_Case_reason_{{ $cand->id }}"
                                                                            class="form-label mt-2">Reason for Special
                                                                            Case Salary</label>
                                                                        <input type="text"
                                                                            class="form-control mt-2"
                                                                            name="Special_Case_reason"
                                                                            id="Special_Case_reason_{{ $cand->id }}"
                                                                            placeholder="Enter reason for Special Case salary">
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Submit for
                                                                        Approval</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @can('Admin')
                                                <form method="POST" action="{{ route('exam.destroy', $cand->id) }}"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Delete candidate and all related exam data?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center mt-3">
                            {{ $candidates->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Initialize all promote modals using delegated logic
                        document.querySelectorAll('[id^="promoteModal-"]').forEach(function(modalEl) {
                            var id = modalEl.id.replace('promoteModal-', '');
                            var agreed = document.getElementById('type_agreed_' + id);
                            var neg = document.getElementById('type_negotiation_' + id);
                            var wrapper = document.getElementById('negotiation_input_wrapper_' + id);
                            var hiddenSalary = document.getElementById('hidden_requested_salary_' + id);
                            var negotiationInput = document.getElementById('requested_salary_' + id);
                            var specialCase = document.getElementById('type_Special_Case_salary_' + id);
                            var specialCaseWrapper = document.getElementById('Special_Case_input_wrapper_' + id);
                            var specialCaseInput = document.getElementById('Special_Case_salary_' + id);

                            // derive recommended numeric from hidden input initial value
                            var recommendedNumeric = (hiddenSalary && hiddenSalary.value !== '') ? hiddenSalary.value :
                                null;

                            function toggle() {
                                if (neg && neg.checked) {
                                    wrapper && wrapper.classList.remove('d-none');
                                    specialCaseWrapper && specialCaseWrapper.classList.add('d-none');
                                    if (hiddenSalary && negotiationInput) {
                                        // clamp negotiation input to max if provided
                                        try {
                                            var max = negotiationInput.getAttribute('max');
                                            if (max && negotiationInput.value !== '') {
                                                var num = parseFloat(negotiationInput.value);
                                                var maxNum = parseFloat(max);
                                                if (!isNaN(num) && !isNaN(maxNum) && num > maxNum) {
                                                    negotiationInput.value = maxNum;
                                                }
                                            }
                                        } catch (e) {}
                                        hiddenSalary.value = negotiationInput.value || '';
                                    }
                                    return;
                                }

                                if (specialCase && specialCase.checked) {
                                    specialCaseWrapper && specialCaseWrapper.classList.remove('d-none');
                                    wrapper && wrapper.classList.add('d-none');
                                    if (hiddenSalary) {
                                        hiddenSalary.value = specialCaseInput ? specialCaseInput.value || '' : '';
                                    }
                                    return;
                                }

                                wrapper && wrapper.classList.add('d-none');
                                specialCaseWrapper && specialCaseWrapper.classList.add('d-none');
                                if (hiddenSalary) {
                                    hiddenSalary.value = (recommendedNumeric !== null) ? recommendedNumeric : '';
                                }
                            }

                            if (neg && negotiationInput) {
                                // attach single input listener to clamp and update hidden salary
                                negotiationInput.addEventListener('input', function() {
                                    try {
                                        var max = this.getAttribute('max');
                                        if (max && this.value !== '') {
                                            var num = parseFloat(this.value);
                                            var maxNum = parseFloat(max);
                                            if (!isNaN(num) && !isNaN(maxNum) && num > maxNum) {
                                                this.value = maxNum;
                                            }
                                        }
                                    } catch (e) {}

                                    if (neg.checked && hiddenSalary) {
                                        hiddenSalary.value = this.value || '';
                                    }
                                });

                                // initialize hidden salary value from negotiation input (clamped)
                                try {
                                    var maxInit = negotiationInput.getAttribute('max');
                                    if (maxInit && negotiationInput.value !== '') {
                                        var n = parseFloat(negotiationInput.value);
                                        var m = parseFloat(maxInit);
                                        if (!isNaN(n) && !isNaN(m) && n > m) {
                                            negotiationInput.value = m;
                                        }
                                    }
                                } catch (e) {}
                                hiddenSalary.value = negotiationInput.value || '';
                            }

                            // update hidden when special case salary changes
                            if (specialCaseInput) {
                                specialCaseInput.addEventListener('input', function() {
                                    if (specialCase && specialCase.checked && hiddenSalary) {
                                        hiddenSalary.value = this.value || '';
                                    }
                                });
                            }

                            agreed && agreed.addEventListener && agreed.addEventListener('change', toggle);
                            neg && neg.addEventListener && neg.addEventListener('change', toggle);
                            specialCase && specialCase.addEventListener && specialCase.addEventListener('change',
                                toggle);

                            // initialize state when modal is shown (cover cases where modal opened later)
                            modalEl.addEventListener('show.bs.modal', function() {
                                // recompute recommended in case value changed in DOM
                                recommendedNumeric = (hiddenSalary && hiddenSalary.value !== '') ? hiddenSalary
                                    .value : recommendedNumeric;
                                toggle();
                            });

                            // Initialize immediately for currently-rendered modals
                            toggle();
                        });
                    });
                </script>
        </div>
        </div>
        @endif
        </div>
    </section>

</x-backend.layouts.master>
