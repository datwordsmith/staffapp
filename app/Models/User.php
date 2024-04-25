<?php

namespace App\Models;

use App\Models\Title;
use App\Models\Profile;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'staffId',
        'email',
        'password',
        'isActive',
        'role_as', //3 = non-academic, 2 = academic, 1 = admin, 0 = Super Admin
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function title()
    {
        return $this->hasOne(Title::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function department()
    {
        return $this->hasOne(staffDepartment::class);
    }

    public function socialMedia()
    {
        return $this->hasMany(socialMedia::class);
    }

    public function interests()
    {
        return $this->hasMany(Interests::class);
    }

    public function publications()
    {
        return $this->hasMany(Publications::class);
    }
    public function teachingExperiences()
    {
        return $this->hasMany(TeachingExperience::class);
    }

    public function awards()
    {
        return $this->hasMany(Awards::class);
    }
    public function honours()
    {
        return $this->hasMany(Honours::class);
    }

    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function conferences()
    {
        return $this->hasMany(Conference::class);
    }

    public function initialQualifications()
    {
        return $this->hasMany(InitialQualification::class);
    }

    public function additionalQualifications()
    {
        return $this->hasMany(AdditionalQualification::class);
    }

    public function completedResearches()
    {
        return $this->hasMany(CompletedResearch::class);
    }

    public function ongoingResearches()
    {
        return $this->hasMany(OngoingResearch::class);
    }

    public function creativeWorks()
    {
        return $this->hasMany(CreativeWork::class);
    }

    public function universityAdministrations()
    {
        return $this->hasMany(UniversityAdministration::class);
    }

    public function communityServices()
    {
        return $this->hasMany(CommunityService::class);
    }

    public function journalPapers()
    {
        return $this->hasMany(JournalPaper::class);
    }

    public function staffPublications()
    {
        return $this->hasMany(StaffPublication::class);
    }

    public function firstAppointment()
    {
        return $this->hasOne(FirstAppointment::class);
    }

    public function appraisalRequests()
    {
        return $this->hasMany(APER::class);
    }

    public function aperEvaluation()
    {
        return $this->hasMany(AperEvaluation::class);
    }

    public function aperApproval()
    {
        return $this->hasMany(AperApproval::class);
    }
}
