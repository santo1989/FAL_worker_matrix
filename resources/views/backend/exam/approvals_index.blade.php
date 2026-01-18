<x-backend.layouts.master>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Pending Approvals</h4>
            <div>
                <a href="{{ route('exam.index') }}" class="btn btn-outline-secondary btn-sm">Back to Exams</a>
            </div>
        </div>

        <div class="card-body">
            <form id="filterForm" method="GET" action="{{ route('exam.approvals.index') }}" class="row g-2 mb-3">
                <div class="col-auto">
                    <select name="type" class="form-select form-select-sm">
                        <option value="">All Types</option>
                        <option value="agreed" {{ request('type') == 'agreed' ? 'selected' : '' }}>Agreed</option>
                        <option value="negotiation" {{ request('type') == 'negotiation' ? 'selected' : '' }}>Negotiation
                        </option>
                    </select>
                </div>
                <div class="col-auto">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                        </option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                        </option>
                    </select>
                </div>
                <!--date range filter-->
                <div class="col-auto">
                    <input type="date" name="from_date" class="form-control form-control-sm"
                        value="{{ request('from_date') }}" placeholder="From Date">
                </div>
                <div class="col-auto">
                    <input type="date" name="to_date" class="form-control form-control-sm"
                        value="{{ request('to_date') }}" placeholder="To Date">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-outline-primary">Filter</button>
                    <a href="{{ route('exam.approvals.index') }}" class="btn btn-sm btn-outline-secondary ms-1">Reset</a>
                </div>
            </form>

            <form id="bulkForm" method="POST" action="{{ route('exam.approvals.bulk_approve') }}">
                @csrf

                <div class="mb-2">
                    @can('approve', \App\Models\ExamApproval::class)
                        <button type="submit" class="btn btn-primary btn-sm">Bulk Approve Selected</button>
                        <button type="button" id="bulkRejectBtn" class="btn btn-danger btn-sm ms-2">Bulk Reject
                            Selected</button>
                    @endcan
                    @if (strtolower(optional(auth()->user()->role)->name ?? '') === 'admin')
                        <button type="button" id="bulkDeleteBtn" class="btn btn-outline-secondary btn-sm ms-2">Bulk
                            Delete Selected</button>
                    @endif
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>
                                    @can('approve', \App\Models\ExamApproval::class)
                                        <input type="checkbox" id="select_all">
                                    @endcan
                                </th>
                                <th>#</th>
                                <th>Candidate</th>
                                <th>Type</th>
                                <th>Recommended Salary</th>
                                <th>Requested Salary</th>
                                <th>Status</th>
                                <th>Requested By</th>
                                <th>Requested At</th>
                                <th>Approved By</th>
                                <th>Approved At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($approvals as $a)
                                <tr>
                                    <td>
                                        @can('approve', \App\Models\ExamApproval::class)
                                            @if ($a->status === 'pending')
                                                <input type="checkbox" name="approval_ids[]" value="{{ $a->id }}">
                                            @else
                                                -
                                            @endif
                                        @endcan
                                    </td>
                                    <td>{{ $a->id }}</td>
                                    <td>
                                        <a href="{{ route('exam.show', $a->exam_candidate_id) }}"
                                            class="btn btn-outline-primary">{{ $a->exam_candidate_id }}
                                            - {{ $a->candidate->name ?? 'N/A' }}</a>
                                    </td>
                                    <td>{{ ucfirst($a->type) }}</td>
                                    <td>
                                        @php
                                            $salaryRecommended = $a->recommended_salary ?? null;
                                            if ($salaryRecommended === null) {
                                                $resultData = $a->candidate->result_data ?? null;
                                                $salaryCandidate =
                                                    is_array($resultData) && array_key_exists('salary_range', $resultData)
                                                        ? $resultData['salary_range']
                                                        : null;
                                                $salaryRecommended = $salaryCandidate;
                                            }

                                            if (is_array($salaryRecommended)) {
                                                $nums = array_values(array_filter($salaryRecommended, 'is_numeric'));
                                                if (count($nums) === 2) {
                                                    $salaryRecommended = $nums[0] . ' - ' . $nums[1];
                                                } elseif (count($nums) > 0) {
                                                    $salaryRecommended = round(array_sum($nums) / count($nums), 2);
                                                } else {
                                                    $salaryRecommended = json_encode($salaryRecommended);
                                                }
                                            }

                                            // make sure it's a string for safe echo
                                            if (is_array($salaryRecommended) || is_object($salaryRecommended)) {
                                                $salaryRecommended = json_encode($salaryRecommended);
                                            }
                                        @endphp
                                        {{ $salaryRecommended ?? 'N/A' }}
                                    </td>
                                    @php
                                        $salarySource = $a->requested_salary ?? null;
                                        if ($salarySource === null) {
                                            $resultData = $a->candidate->result_data ?? null;
                                            $salaryCandidate =
                                                is_array($resultData) && array_key_exists('salary_range', $resultData)
                                                    ? $resultData['salary_range']
                                                    : null;
                                            $salarySource = $salaryCandidate;
                                        }

                                        if (is_array($salarySource)) {
                                            $nums = array_values(array_filter($salarySource, 'is_numeric'));
                                            if (count($nums) === 2) {
                                                $salarySource = $nums[0] . ' - ' . $nums[1];
                                            } elseif (count($nums) > 0) {
                                                $salarySource = round(array_sum($nums) / count($nums), 2);
                                            } else {
                                                $salarySource = json_encode($salarySource);
                                            }
                                        }

                                        // make sure it's a string for safe echo
                                        if (is_array($salarySource) || is_object($salarySource)) {
                                            $salarySource = json_encode($salarySource);
                                        }
                                    @endphp
                                    <td>{{ $salarySource ?? 'N/A' }}</td>
                                    <td>
                                        @if ($a->status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif ($a->status === 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $reqName = $a->requester->name ?? '-';
                                            if (is_array($reqName) || is_object($reqName)) {
                                                $reqName = json_encode($reqName);
                                            }
                                        @endphp
                                        {{ $reqName }}
                                    </td>
                                    <td>
                                        @php
                                            $created = $a->created_at;
                                            if (is_object($created) && method_exists($created, 'toDateTimeString')) {
                                                $created = $created->toDateTimeString();
                                            } elseif (is_array($created)) {
                                                $created = json_encode($created);
                                            }
                                        @endphp
                                        {{ $created }}
                                    </td>
                                    <td>
                                        @php
                                            $approved = $a->approved_at ? $a->approver->name ?? '-' : '-';
                                            if (is_array($approved) || is_object($approved)) {
                                                $approved = json_encode($approved);
                                            }
                                        @endphp
                                        {{ $approved }}
                                    </td>
                                    <td>
                                        @php
                                            $approvedAt = $a->approved_at;
                                            if (is_object($approvedAt) && method_exists($approvedAt, 'toDateTimeString')) {
                                                $approvedAt = $approvedAt->toDateTimeString();
                                            } elseif (is_array($approvedAt)) {
                                                $approvedAt = json_encode($approvedAt);
                                            }
                                        @endphp
                                        {{ $approvedAt }}
                                    </td>
                                    <td>
                                        @if ($a->status === 'pending')
                                            @can('approve', $a)
                                                {{-- <button type="button" class="btn btn-sm btn-success approve-btn"
                                                    data-url="{{ route('exam.approvals.approve', $a->id) }}">Approve</button>
                                                <button type="button" class="btn btn-sm btn-danger reject-btn ms-1"
                                                    data-url="{{ route('exam.approvals.reject', $a->id) }}">Reject</button> --}}
                                            @endcan
                                            @if (strtolower(optional(auth()->user()->role)->name ?? '') === 'admin')
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary delete-approval-btn ms-1"
                                                    data-url="{{ route('exam.approvals.destroy', $a->id) }}">Delete</button>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div></div>
                    <div>
                        {{ $approvals->links() }}
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function() {
            const selectAll = document.getElementById('select_all');
            selectAll && selectAll.addEventListener('change', function() {
                document.querySelectorAll('input[name="approval_ids[]"]').forEach(function(cb) {
                    cb.checked = selectAll.checked;
                });
            });

            const bulkRejectBtn = document.getElementById('bulkRejectBtn');
            bulkRejectBtn && bulkRejectBtn.addEventListener('click', function() {
                const form = document.getElementById('bulkForm');
                form.action = '{{ route('exam.approvals.bulk_reject') }}';
                form.submit();
            });
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            bulkDeleteBtn && bulkDeleteBtn.addEventListener('click', function() {
                if (!confirm('Are you sure you want to delete selected approvals? This cannot be undone.'))
                    return;
                const form = document.getElementById('bulkForm');
                form.action = '{{ route('exam.approvals.bulk_delete') }}';
                form.submit();
            });
        })();
    </script>

    <script>
        (function() {
            const csrf = document.querySelector('meta[name="csrf-token"]') ? document.querySelector(
                'meta[name="csrf-token"]').getAttribute('content') : '{{ csrf_token() }}';

            function sendAction(url, method) {
                return fetch(url, {
                    method: method,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    }
                }).then(function(res) {
                    if (!res.ok) throw new Error('Network response was not ok');
                    return res.json().catch(() => ({}));
                });
            }

            // Approve buttons
            document.querySelectorAll('.approve-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    if (!confirm('Approve this request?')) return;
                    const url = btn.getAttribute('data-url');
                    sendAction(url, 'POST')
                        .then(function() {
                            location.reload();
                        })
                        .catch(function(err) {
                            alert('Approve failed: ' + err.message);
                        });
                });
            });

            // Reject buttons
            document.querySelectorAll('.reject-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    if (!confirm('Reject this request?')) return;
                    const url = btn.getAttribute('data-url');
                    sendAction(url, 'POST')
                        .then(function() {
                            location.reload();
                        })
                        .catch(function(err) {
                            alert('Reject failed: ' + err.message);
                        });
                });
            });

            // Delete approval (admin)
            document.querySelectorAll('.delete-approval-btn').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    if (!confirm('Delete this approval?')) return;
                    const url = btn.getAttribute('data-url');
                    sendAction(url, 'DELETE')
                        .then(function() {
                            location.reload();
                        })
                        .catch(function(err) {
                            alert('Delete failed: ' + err.message);
                        });
                });
            });
        })();
    </script>

</x-backend.layouts.master>
