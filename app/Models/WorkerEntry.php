<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerEntry extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function workerSewingProcessEntries()
    {
        return $this->hasMany(WorkerSewingProcessEntry::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sewingProcessList()
    {
        return $this->belongsTo(SewingProcessList::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function sewingProcessEntries()
    {
        return $this->hasMany(WorkerSewingProcessEntry::class);
    }

    public function cycleListLogs()
    {
        return $this->hasMany(CycleListLog::class);
    }
    

}
