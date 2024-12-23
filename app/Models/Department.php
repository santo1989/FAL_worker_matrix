<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function designations()
    {
        return $this->hasMany(Designation::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function kra()
    {
        return $this->belongsTo(Kra::class);
    }

    public function kpi()
    {
        return $this->belongsTo(Kpi::class);
    }

    public function costControl()
    {
        return $this->belongsTo(CostControl::class);
    }

    

    
}
