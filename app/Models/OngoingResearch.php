<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OngoingResearch extends Model
{
    use HasFactory;

    protected $table = 'ongoing_researches';

    protected $fillable = [
        'user_id',
        'topic',
        'summary',
        'findings',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
