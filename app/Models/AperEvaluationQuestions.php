<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AperEvaluationQuestions extends Model
{
    use HasFactory;

    protected $table = 'aper_evaluation_questions';

    protected $fillable = [
        'question',
        'high',
        'low',
        'field',
    ];


}
