<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalQualification extends Model
{
    use HasFactory;

    protected $table = 'additional_qualifications';

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
