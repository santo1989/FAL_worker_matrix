<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Migrate Worker
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4>Migrate Single Worker</h4>
        </div>
        <!--Success Message Start-->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <!--Error Message Start-->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <!--Error/Success Message Start-->
        <div class="card-body">
            <form action="{{ route('migrate-worker-lists.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="worker_entry_id">Select Worker *</label>
                            <select name="worker_entry_id" id="worker_entry_id" class="form-control select2" required>
                                <option value="">Select Worker</option>
                                @foreach ($workers as $worker)
                                    <option value="{{ $worker->id }}" data-salary="{{ $worker->salary }}">
                                        {{ $worker->id_card_no }} - {{ $worker->employee_name_english }}
                                        ({{ $worker->designation_name }} - {{ $worker->present_grade }})
                                    </option>
                                @endforeach
                            </select>
                            @error('worker_entry_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="migration_reason">Migration Reason *</label>
                            <select name="migration_reason" id="migration_reason" class="form-control" required>
                                <option value="">Select Reason</option>
                                <option value="resigned" {{ old('migration_reason') == 'resigned' ? 'selected' : '' }}>
                                    Resigned</option>
                                <option value="terminated"
                                    {{ old('migration_reason') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                                <option value="retired" {{ old('migration_reason') == 'retired' ? 'selected' : '' }}>
                                    Retired</option>
                                <option value="transferred"
                                    {{ old('migration_reason') == 'transferred' ? 'selected' : '' }}>Transferred
                                </option>
                                <option value="inactive" {{ old('migration_reason') == 'inactive' ? 'selected' : '' }}>
                                    Inactive</option>
                                <option value="other" {{ old('migration_reason') == 'other' ? 'selected' : '' }}>Other
                                </option>
                            </select>
                            @error('migration_reason')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="migration_date">Migration Date *</label>
                            <input type="date" name="migration_date" id="migration_date" class="form-control"
                                value="{{ old('migration_date', date('Y-m-d')) }}" required>
                            @error('migration_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="last_working_date">Last Working Date *</label>
                            <input type="date" name="last_working_date" id="last_working_date" class="form-control"
                                value="{{ old('last_working_date', date('Y-m-d')) }}" required>
                            @error('last_working_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="last_salary">Last Salary</label>
                            <input type="number" step="0.01" name="last_salary" id="last_salary"
                                class="form-control" value="{{ old('last_salary') }}"
                                placeholder="Auto-fill from worker data">
                            <small class="form-text text-muted">Leave empty to use worker's current salary</small>
                            @error('last_salary')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="3"
                        placeholder="Additional notes about migration...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="alert alert-warning">
                    <strong>Warning:</strong> This action will permanently move all worker data to migration storage and
                    delete original records from the system. This action cannot be undone.
                </div>

                <div class="form-group text-right">
                    <a href="{{ route('migrate-worker-lists.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary"
                        onclick="return confirm('Are you sure you want to migrate this worker? All original records will be deleted.')">
                        <i class="fas fa-user-slash"></i> Migrate Worker
                    </button>
                </div>
            </form>
        </div>
    </div>


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Select Worker",
                allowClear: true
            });

            // Auto-fill last salary when worker is selected
            $('#worker_entry_id').change(function() {
                var selectedOption = $(this).find('option:selected');
                var salary = selectedOption.data('salary');
                if (salary && !$('#last_salary').val()) {
                    $('#last_salary').val(salary);
                }
            });

            // Set max dates to today
            var today = new Date().toISOString().split('T')[0];
            $('#migration_date').attr('max', today);
            $('#last_working_date').attr('max', today);
        });
    </script>
</x-backend.layouts.master>
