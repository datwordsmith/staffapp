<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InitialQualification extends Model
{
    use HasFactory;

    protected $table = 'initial_qualifications';

    protected $fillable = [
        'user_id',
        'institution',
        'qualification',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
