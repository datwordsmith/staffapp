<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APER extends Model
{
    use HasFactory;

    protected $table = 'aper';

    protected $fillable = [
        'user_id',
        'status_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(AperStatus::class);
    }
}
