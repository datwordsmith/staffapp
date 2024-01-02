<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class socialPlatform extends Model
{
    use HasFactory;

    protected $table = 'social_platforms';

    protected $fillable = [
        'name',
        'icon',
    ];

    public function socialMedia()
    {
        return $this->hasMany(socialMedia::class);
    }
}
