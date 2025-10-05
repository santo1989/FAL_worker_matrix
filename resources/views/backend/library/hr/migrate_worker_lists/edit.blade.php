<x-backend.layouts.master>
    <x-slot name="pageTitle">
        Edit Migration Record
    </x-slot>

    <div class="card">
        <div class="card-header">
            <h4>Edit Migration Record - {{ $migrateWorkerList->employee_name_english }}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('mwlupdate', $migrateWorkerList->original_worker_entry_id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>ID Card No:</strong> {{ $migrateWorkerList->id_card_no }}
                    </div>
                    <div class="col-md-6">
                        <strong>Employee Name:</strong> {{ $migrateWorkerList->employee_name_english }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="migration_reason">Migration Reason *</label>
                            <select name="migration_reason" id="migration_reason" class="form-control" required>
                                <option value="resigned" {{ $migrateWorkerList->migration_reason == 'resigned' ? 'selected' : '' }}>Resigned</option>
                                <option value="terminated" {{ $migrateWorkerList->migration_reason == 'terminated' ? 'selected' : '' }}>Terminated</option>
                                <option value="retired" {{ $migrateWorkerList->migration_reason == 'retired' ? 'selected' : '' }}>Retired</option>
                                <option value="transferred" {{ $migrateWorkerList->migration_reason == 'transferred' ? 'selected' : '' }}>Transferred</option>
                                <option value="inactive" {{ $migrateWorkerList->migration_reason == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="other" {{ $migrateWorkerList->migration_reason == 'other' ? 'selected' : '' }}>Other</option>
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
                                   class="form-control" value="{{ old('migration_date', $migrateWorkerList->migration_date->format('Y-m-d')) }}" required>
                            @error('migration_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="last_working_date">Last Working Date *</label>
                            <input type="date" name="last_working_date" id="last_working_date" 
                                   class="form-control" value="{{ old('last_working_date', $migrateWorkerList->last_working_date->format('Y-m-d')) }}" required>
                            @error('last_working_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_salary">Last Salary</label>
                            <input type="number" step="0.01" name="last_salary" id="last_salary" 
                                   class="form-control" value="{{ old('last_salary', $migrateWorkerList->last_salary) }}">
                            @error('last_salary')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Service Length</label>
                            <input type="text" class="form-control" value="{{ $migrateWorkerList->service_length }}" readonly>
                            <small class="form-text text-muted">Automatically calculated</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="3" 
                              placeholder="Additional notes about migration...">{{ old('notes', $migrateWorkerList->notes) }}</textarea>
                    @error('notes')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group text-right">
                    <a href="{{ route('migrate-worker-lists.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Migration Record
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Set max dates to today
            var today = new Date().toISOString().split('T')[0];
            $('#migration_date').attr('max', today);
            $('#last_working_date').attr('max', today);
        });
    </script>
</x-backend.layouts.master>