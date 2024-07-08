<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AperEvaluation extends Model
{
    use HasFactory;

    protected $table = 'aper_evaluation';

    protected $fillable = [
        'aper_id',
        'appraiser_id',
        'foresight',
        'penetration',
        'judgement',
        'written_expression',
        'oral_expression',
        'numeracy',
        'staff_relationship',
        'student_relationship',
        'accepts_responsibility',
        'pressure_reliabilty',
        'drive',
        'knowledge_application',
        'staff_management',
        'work_output',
        'work_quality',
        'punctuality',
        'time_management',
        'comportment',
        'ict_literacy',
        'query_commendations',
        'grade',
        'status_id',
        'note',
    ];

    public function aper()
    {
        return $this->belongsTo(APER::class, 'aper_id');
    }

    public function appraiser()
    {
        return $this->belongsTo(User::class, 'appraiser_id');
    }

    public function status()
    {
        return $this->belongsTo(AperStatus::class, 'status_id');
    }
}
