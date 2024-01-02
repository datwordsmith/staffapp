<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    use HasFactory;

    protected $table = 'programmes';

    protected $fillable = [
        'name',
        'description',
        'department_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
