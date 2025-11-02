<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamProcessEntry extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function candidate()
    {
        return $this->belongsTo(ExamCandidate::class);
    }

    public function cycleLogs()
    {
        return $this->hasMany(ExamCycleLog::class);
    }
}
