<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletedResearch extends Model
{
    use HasFactory;

    protected $table = 'completed_researches';

    protected $fillable = [
        'user_id',
        'topic',
        'publication_number',
        'summary',
        'findings',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
