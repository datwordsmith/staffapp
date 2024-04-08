<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversityAdministration extends Model
{
    use HasFactory;

    protected $table = 'university_administration';

    protected $fillable = [
        'user_id',
        'duty',
        'experience',
        'commending_officer',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
