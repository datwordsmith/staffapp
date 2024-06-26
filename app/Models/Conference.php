<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    use HasFactory;

    protected $table = 'conferences';

    protected $fillable = [
        'user_id',
        'conference',
        'location',
        'paper_presented',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
