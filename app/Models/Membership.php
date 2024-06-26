<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $table = 'membership';

    protected $fillable = [
        'user_id',
        'society',
        'class',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
