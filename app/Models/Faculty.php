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
        'dean_id'
    ];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function dean()
    {
        return $this->belongsTo(User::class, 'dean_id', 'id');
    }
}
