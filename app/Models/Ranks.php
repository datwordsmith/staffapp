<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranks extends Model
{
    use HasFactory;

    protected $table = 'ranks';

    protected $fillable = [
        'category',
        'rank',
    ];

    public function profile()
    {
        return $this->hasMany(Profile::class);
    }
}
