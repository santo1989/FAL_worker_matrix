<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Bulk Migrate Workers
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4>Bulk Migrate Workers</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('migrate-worker-lists.bulk.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="worker_entries">Select Workers *</label>
                            <select name="worker_entries[]" id="worker_entries" class="form-control select2" multiple required style="width: 100%;">
                                @foreach($workers as $worker)
                                <option value="{{ $worker->id }}">
                                    {{ $worker->id_card_no }} - {{ $worker->employee_name_english }} 
                                    ({{ $worker->designation_name }} - {{ $worker->present_grade }})
                                </option>
                                @endforeach
                            </select>
                            @error('worker_entries')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="migration_reason">Migration Reason *</label>
                            <select name="migration_reason" id="migration_reason" class="form-control" required>
                                <option value="">Select Reason</option>
                                <option value="resigned" {{ old('migration_reason') == 'resigned' ? 'selected' : '' }}>Resigned</option>
                                <option value="terminated" {{ old('migration_reason') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                                <option value="retired" {{ old('migration_reason') == 'retired' ? 'selected' : '' }}>Retired</option>
                                <option value="transferred" {{ old('migration_reason') == 'transferred' ? 'selected' : '' }}>Transferred</option>
                                <option value="inactive" {{ old('migration_reason') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="other" {{ old('migration_reason') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('migration_reason')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="migration_date">Migration Date *</label>
                            <input type="date" name="migration_date" id="migration_date" 
                                   class="form-control" value="{{ old('migration_date', date('Y-m-d')) }}" required>
                            @error('migration_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="last_working_date">Last Working Date *</label>
                            <input type="date" name="last_working_date" id="last_working_date" 
                                   class="form-control" value="{{ old('last_working_date', date('Y-m-d')) }}" required>
                            @error('last_working_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="3" 
                              placeholder="Additional notes about bulk migration...">{{ old('notes') }}</textarea>
                    @error('notes')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="alert alert-warning">
                    <strong>Warning:</strong> This action will permanently move all selected workers' data to migration storage and delete original records from the system. This action cannot be undone.
                </div>

                <div class="form-group text-right">
                    <a href="{{ route('migrate-worker-lists.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary" id="bulkMigrateBtn" onclick="return confirmBulkMigration()">
                        <i class="fas fa-users-slash"></i> Migrate Selected Workers
                    </button>
                </div>
            </form>
        </div>
    </div>

    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    

    
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#worker_entries').select2({
                placeholder: "Select multiple workers",
                allowClear: true
            });

            // Set max dates to today
            var today = new Date().toISOString().split('T')[0];
            $('#migration_date').attr('max', today);
            $('#last_working_date').attr('max', today);
        });

        function confirmBulkMigration() {
            var selectedCount = $('#worker_entries').val().length;
            if (selectedCount === 0) {
                alert('Please select at least one worker to migrate.');
                return false;
            }
            
            return confirm('Are you sure you want to migrate ' + selectedCount + ' workers? All original records will be permanently deleted.');
        }
    </script> 
</x-backend.layouts.master>