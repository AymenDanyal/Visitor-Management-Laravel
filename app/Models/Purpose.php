<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function visitors()
    {
        return $this->belongsToMany(Visitor::class, 'visitor_purposes');
    }
    
    public function checkIns()
    {
        return $this->hasMany(CheckIn::class, 'purpose_of_visit');
    }
    
}
