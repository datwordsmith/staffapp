<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';

    protected $fillable = [
        'user_id',
        'title_id',
        'lastname',
        'firstname',
        'othername',
        'dob',
        'biography',
        'designation',
        'first_appointment',
        'telephone',
        'photo',
        'slug',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function title()
    {
        return $this->belongsTo(Title::class);
    }
}
