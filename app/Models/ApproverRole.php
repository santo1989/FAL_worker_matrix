<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproverRole extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'approver_roles';
}
