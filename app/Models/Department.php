<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'name',
        'description',
        'faculty_id',
        'hod_id',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function programmes()
    {
        return $this->hasMany(Programme::class);
    }

    public function hod()
    {
        return $this->belongsTo(User::class, 'hod_id', 'id');
    }
}
