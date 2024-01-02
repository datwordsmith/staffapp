<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $table = 'faculties';

    protected $fillable = [
        'name',
        'description',
    ];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
