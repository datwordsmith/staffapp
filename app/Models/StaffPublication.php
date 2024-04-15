<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffPublication extends Model
{
    use HasFactory;

    protected $table = 'staff_publications';

    protected $fillable = [
        'user_id',
        'title',
        'authors',
        'year',
        'journal',
        'journal_volume',
        'doi',
        'abstract',
        'abstractFileName',
        'evidence',
        'evidenceFileName',
        'category_id',
        'details',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(PublicationCategory::class);
    }
}
