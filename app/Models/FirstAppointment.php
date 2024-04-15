<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FirstAppointment extends Model
{
    use HasFactory;

    protected $table = 'first_appointment';

    protected $fillable = [
        'user_id',
        'post',
        'grade_step',
        'first_appointment',
        'confirmation'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
