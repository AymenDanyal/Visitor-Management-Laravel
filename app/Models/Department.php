<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function visitors()
    {
        return $this->belongsToMany(Visitor::class, 'visitor_departments');
    }
    public function checkIns()
    {
        return $this->hasMany(CheckIn::class, 'department');
    }
}
