<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerSewingProcessEntry extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function workerEntry()
    {
        return $this->belongsTo(WorkerEntry::class);
    }

    public function sewingProcessList()
    {
        return $this->belongsTo(SewingProcessList::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
