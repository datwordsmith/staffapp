<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeachingExperience extends Model
{
    use HasFactory;

    protected $table = 'teaching_experience';

    protected $fillable = [
        'user_id',
        'course_code',
        'course_title',
        'credit_unit',
        'lectures',
        'semester',
        'year',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
