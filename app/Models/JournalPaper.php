<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalPaper extends Model
{
    use HasFactory;

    protected $table = 'journal_papers';

    protected $fillable = [
        'user_id',
        'title',
        'authors',
        'year',
        'journal',
        'journal_volume',
        'abstract',
        'abstractFileName',
        'evidence',
        'evidenceFileName',
        'isSubmitted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
