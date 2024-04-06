<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreativeWork extends Model
{
    use HasFactory;

    protected $table = 'creative_works';

    protected $fillable = [
        'user_id',
        'title',
        'author',
        'category',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
