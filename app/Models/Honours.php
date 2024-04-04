<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Honours extends Model
{
    use HasFactory;

    protected $table = 'honours';

    protected $fillable = [
        'user_id',
        'award',
        'awarding_body',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
