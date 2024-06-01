<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppraisalCategory extends Model
{
    use HasFactory;

    protected $table = 'appraisal_category';

    protected $fillable = [
        'category',
    ];

    public function aper()
    {
        return $this->hasMany(APER::class);
    }
}
