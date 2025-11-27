<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApproverUser extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'approver_users';
}
