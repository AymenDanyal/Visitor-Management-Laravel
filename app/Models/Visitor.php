<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'phone', 
        'cnic_front_image', 
        'cnic_back_image', 
        'user_image', 
        'purpose_of_visit', 
        'department', 
        'department_person_name', 
        'organization_name', 
        'vehicle_number', 
        'comments'
    ];

    public function purposes()
    {
        return $this->belongsToMany(Purpose::class, 'visitor_purposes');
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'visitor_departments');
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class, 'visitor_vehicles');
    }

    public function checkIns()
    {
        return $this->hasMany(CheckIn::class);
    }
}

