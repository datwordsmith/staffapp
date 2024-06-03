<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class staffSubUnit extends Model
{
    use HasFactory;

    protected $table = 'staff_sub_units';

    protected $fillable = [
        'user_id',
        'subunit_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subunit()
    {
        return $this->belongsTo(SubUnit::class);
    }
}
