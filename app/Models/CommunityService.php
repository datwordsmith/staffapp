<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunityService extends Model
{
    use HasFactory;

    protected $table = 'community_service';

    protected $fillable = [
        'user_id',
        'duty',
        'experience',
        'commending_officer',
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
