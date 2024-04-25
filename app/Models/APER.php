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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evaluation()
    {
        return $this->hasOne(AperEvaluation::class, 'aper_id');
    }

    public function approval()
    {
        return $this->hasOne(AperApproval::class, 'aper_id');
    }
}
