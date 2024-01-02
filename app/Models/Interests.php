<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interests extends Model
{
    use HasFactory;

    protected $table = 'interests';

    protected $fillable = [
        'user_id',
        'interest',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
