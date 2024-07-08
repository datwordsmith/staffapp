<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AperAcceptance extends Model
{
    use HasFactory;

    protected $table = 'aper_acceptance';

    protected $fillable = [
        'aper_id',
        'staff_id',
        'status_id',
        'note',
    ];

    public function aper()
    {
        return $this->belongsTo(APER::class);
    }

    public function staff()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(AperStatus::class);
    }
}
