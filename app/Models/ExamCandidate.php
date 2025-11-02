<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamCandidate extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'exam_passed' => 'boolean',
        'result_data' => 'array'
    ];

    public function processEntries()
    {
        return $this->hasMany(ExamProcessEntry::class);
    }

    public function cycleLogs()
    {
        return $this->hasMany(ExamCycleLog::class);
    }

    protected static function booted()
    {
        static::deleting(function ($candidate) {
            // Delete cycle logs attached to process entries
            foreach ($candidate->processEntries as $entry) {
                $entry->cycleLogs()->delete();
            }

            // Delete process entries
            $candidate->processEntries()->delete();

            // Delete any cycle logs directly attached to candidate (if any)
            $candidate->cycleLogs()->delete();
        });
    }
}
