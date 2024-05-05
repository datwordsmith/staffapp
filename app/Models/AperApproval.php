<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AperApproval extends Model
{
    use HasFactory;

    protected $table = 'aper_approval';

    protected $fillable = [
        'aper_id',
        'approver_id',
        'grade',
        'status_id',
        'note',
    ];

    public function aper()
    {
        return $this->belongsTo(APER::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(AperStatus::class);
    }
}
