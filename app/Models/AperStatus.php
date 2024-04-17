<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AperStatus extends Model
{
    use HasFactory;

    protected $table = 'aper_status';

    protected $fillable = [
        'name',
    ];
}
