<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class socialMedia extends Model
{
    use HasFactory;

    protected $table = 'social_media';

    protected $fillable = [
        'user_id',
        'socialPlatform_id',
        'url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function socialPlatform()
    {
        return $this->belongsTo(socialPlatform::class);
    }
}
