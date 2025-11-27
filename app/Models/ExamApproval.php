<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamApproval extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function candidate()
    {
        return $this->belongsTo(ExamCandidate::class, 'exam_candidate_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
