<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubUnit extends Model
{
    use HasFactory;

    protected $table = 'sub_units';

    protected $fillable = [
        'name',
        'unit_id',
        'hou_id',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function hou()
    {
        return $this->belongsTo(User::class, 'hou_id', 'id');
    }
}
