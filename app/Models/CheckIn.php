<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    use HasFactory;
    protected $fillable = [
        'visitor_id',
        'gatekeeper_id',
        'check_in_time',
        'check_out_time',
        'purpose_of_visit', 
        'department', 
        'department_person_name',
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }
    public function purposes()
    {
        return $this->belongsTo(Purpose::class,'purpose_of_visit');
    }
    public function departments()
    {
        return $this->belongsTo(Department::class,'department');
    }

    public function gatekeeper()
    {
        return $this->belongsTo(User::class, 'gatekeeper_id');
    }
}
