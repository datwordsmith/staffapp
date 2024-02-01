<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publications extends Model
{
    use HasFactory;

    protected $table = 'publications';

    protected $fillable = [
        'user_id',
        'publication',
        'url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
