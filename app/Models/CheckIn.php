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
        'check_out_time'
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    public function gatekeeper()
    {
        return $this->belongsTo(User::class, 'gatekeeper_id');
    }
}
