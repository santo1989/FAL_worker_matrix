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
                <div class="col-auto">
                    <button class="btn btn-sm btn-outline-primary">Filter</button>
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
                                <th>Requested Salary</th>
                                <th>Status</th>
                                <th>Requested By</th>
                                <th>Requested At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($approvals as $a)
                                <tr>
                                    <td>
                                        @can('approve', \App\Models\ExamApproval::class)
                                        @if($a->status === 'pending')
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
                                        @if ($a->status === 'pending')
                                            @can('approve', $a)
                                                <form method="POST" action="{{ route('exam.approvals.approve', $a->id) }}"
                                                    style="display:inline-block">
                                                    @csrf
                                                    <button class="btn btn-sm btn-success">Approve</button>
                                                </form>
                                                <form method="POST" action="{{ route('exam.approvals.reject', $a->id) }}"
                                                    style="display:inline-block; margin-left:6px">
                                                    @csrf
                                                    <button class="btn btn-sm btn-danger">Reject</button>
                                                </form>
                                            @endcan
                                            @if (strtolower(optional(auth()->user()->role)->name ?? '') === 'admin')
                                                <form method="POST"
                                                    action="{{ route('exam.approvals.destroy', $a->id) }}"
                                                    style="display:inline-block; margin-left:6px">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-secondary"
                                                        onclick="return confirm('Delete this approval?')">Delete</button>
                                                </form>
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

</x-backend.layouts.master>
