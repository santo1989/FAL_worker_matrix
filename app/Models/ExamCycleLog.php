<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamCycleLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function candidate()
    {
        return $this->belongsTo(ExamCandidate::class);
    }

    public function processEntry()
    {
        return $this->belongsTo(ExamProcessEntry::class);
    }
}
