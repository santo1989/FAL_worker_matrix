<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Migrated Workers List
    </x-slot>
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h4>Migrated Workers List</h4>
                <div>
                    <a href="{{ route('migrate-worker-lists.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Single Migration
                    </a>
                    <a href="{{ route('migrate-worker-lists.bulk.create') }}" class="btn btn-success">
                        <i class="fas fa-users"></i> Bulk Migration
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Search and Filters -->
            <form method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Search ID or Name..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="migration_reason" class="form-control">
                            <option value="">All Reasons</option>
                            <option value="resigned" {{ request('migration_reason') == 'resigned' ? 'selected' : '' }}>
                                Resigned</option>
                            <option value="terminated"
                                {{ request('migration_reason') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                            <option value="retired" {{ request('migration_reason') == 'retired' ? 'selected' : '' }}>
                                Retired</option>
                            <option value="transferred"
                                {{ request('migration_reason') == 'transferred' ? 'selected' : '' }}>Transferred
                            </option>
                            <option value="inactive" {{ request('migration_reason') == 'inactive' ? 'selected' : '' }}>
                                Inactive</option>
                            <option value="other" {{ request('migration_reason') == 'other' ? 'selected' : '' }}>Other
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="month" name="migrate_month" class="form-control"
                            value="{{ request('migrate_month') }}" placeholder="Migration Month">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}"
                            placeholder="From Date">
                    </div>
                    <div class="col-md-2">
                        <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}"
                            placeholder="To Date">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-info">Filter</button>
                        <a href="{{ route('migrate-worker-lists.index') }}" class="btn btn-secondary mt-1">Reset</a>
                    </div>
                </div>
            </form>
            <!-- Migration List Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID Card No</th>
                            <th>Employee Name</th>
                            <th>Migration Reason</th>
                            <th>Migration Date</th>
                            <th>Last Working Date</th>
                            <th>Service Length</th>
                            <th>Last Salary</th>
                            <th>Migrated By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        @forelse($migrateWorkerLists as $migration)
                            <tr>
                                <td>{{ ($migrateWorkerLists->currentPage() - 1) * $migrateWorkerLists->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $migration->id_card_no }}</td>
                                <td>{{ $migration->employee_name_english }}</td>
                                <td>
                                    <span
                                        class="badge badge-{{ $migration->migration_reason == 'resigned' ? 'primary' : ($migration->migration_reason == 'terminated' ? 'danger' : ($migration->migration_reason == 'retired' ? 'info' : 'warning')) }}">
                                        {{ ucfirst($migration->migration_reason) }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($migration->migration_date)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($migration->last_working_date)->format('d M Y') }}</td>
                                <td>{{ $migration->service_length }}</td>
                                <td>{{ $migration->last_salary ? number_format($migration->last_salary, 2) : 'N/A' }}
                                </td>
                                <td>{{ $migration->data_entry_by }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ !empty($migration->original_worker_entry_id) ? route('mwlshow', ['id' => $migration->original_worker_entry_id]) : '#' }}"
                                            class="btn btn-info btn-sm {{ empty($migration->original_worker_entry_id) ? 'disabled' : '' }}"
                                            title="{{ !empty($migration->original_worker_entry_id) ? 'View Full Report' : 'ID not available' }}">
                                            <i class="fas fa-file-alt"></i> Report
                                        </a>
                                        <a href="{{ !empty($migration->original_worker_entry_id) ? route('mwledit', ['id' => $migration->original_worker_entry_id]) : '#' }}"
                                            class="btn btn-warning btn-sm {{ empty($migration->original_worker_entry_id) ? 'disabled' : '' }}"
                                            title="{{ !empty($migration->original_worker_entry_id) ? 'Edit Migration Details' : 'ID not available' }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ !empty($migration->original_worker_entry_id) ? route('mwlDestroy', ['id' => $migration->original_worker_entry_id]) : '#' }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-danger btn-sm {{ empty($migration->original_worker_entry_id) ? 'disabled' : '' }}"
                                                title="{{ !empty($migration->original_worker_entry_id) ? 'Delete Migration Record' : 'ID not available' }}"
                                                onclick="return confirm('Are you sure you want to delete this migration record? This action cannot be undone.')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center">No migration records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $migrateWorkerLists->links() }}
            </div>
        </div>
    </div>
    
        <script>
            // Auto-submit form when month changes for better UX
            document.addEventListener('DOMContentLoaded', function() {
                const migrateMonth = document.querySelector('input[name="migrate_month"]');
                if (migrateMonth) {
                    migrateMonth.addEventListener('change', function() {
                        this.form.submit();
                    });
                }
            });
        </script>
</x-backend.layouts.master>