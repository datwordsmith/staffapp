<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentAppointment extends Model
{
    use HasFactory;

    protected $table = 'current_appointment';

    protected $fillable = [
        'user_id',
        'rank_id',
        'grade_step',
        'current_appointment',
        'confirmation'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rank()
    {
        return $this->belongsTo(Ranks::class);
    }
}
