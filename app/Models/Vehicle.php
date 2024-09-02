<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'number_plate',
        'model',
        'make'
    ];

    public function visitors()
    {
        return $this->belongsToMany(Visitor::class, 'visitor_vehicles');
    }
}
