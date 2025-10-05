<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MigrateWorkerList extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_worker_entry_id',
        'worker_entry_data',
        'sewing_process_entries_data',
        'cycle_list_logs_data',
        'training_developments_data',
        'disciplinary_problems_data',
        'id_card_no',
        'employee_name_english',
        'migration_reason',
        'migration_date',
        'last_working_date',
        'service_length',
        'last_salary',
        'migrate_month',
        'data_entry_by',
        'user_id',
        'notes'
    ];

    protected $casts = [
        'worker_entry_data' => 'array',
        'sewing_process_entries_data' => 'array',
        'cycle_list_logs_data' => 'array',
        'training_developments_data' => 'array',
        'disciplinary_problems_data' => 'array',
        'migration_date' => 'date',
        'last_working_date' => 'date',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for formatted data
    public function getWorkerEntryAttribute()
    {
        return (object) $this->worker_entry_data;
    }

    public function getSewingProcessEntriesAttribute()
    {
        return collect($this->sewing_process_entries_data)->map(function ($item) {
            return (object) $item;
        });
    }

    public function getCycleListLogsAttribute()
    {
        return collect($this->cycle_list_logs_data)->map(function ($item) {
            return (object) $item;
        });
    }

    public function getTrainingDevelopmentsAttribute()
    {
        return collect($this->training_developments_data)->map(function ($item) {
            return (object) $item;
        });
    }

    public function getDisciplinaryProblemsAttribute()
    {
        return collect($this->disciplinary_problems_data)->map(function ($item) {
            return (object) $item;
        });
    }

    // Scopes for filtering
    public function scopeByReason($query, $reason)
    {
        return $query->where('migration_reason', $reason);
    }

    public function scopeByMonth($query, $month)
    {
        return $query->where('migrate_month', $month);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('id_card_no', 'like', "%{$search}%")
            ->orWhere('employee_name_english', 'like', "%{$search}%");
    }
}
