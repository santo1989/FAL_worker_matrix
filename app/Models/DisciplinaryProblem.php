<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisciplinaryProblem extends Model
{
    use HasFactory;

    protected $table = 'disciplinary_problems';

    protected $guarded = [];

    public function workerEntry()
    {
        return $this->belongsTo(WorkerEntry::class);
    }

    public function dataEntryBy()
    {
        return $this->belongsTo(User::class, 'dataEntryBy');
    }
}
