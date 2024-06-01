<?php

namespace App\Livewire\Admin\User;

use App\Models\APER;
use App\Models\User;
use App\Models\Title;
use App\Models\Awards;
use App\Models\Honours;
use Livewire\Component;
use App\Models\Interests;
use App\Models\Conference;
use App\Models\Membership;
use App\Models\socialMedia;
use App\Models\CreativeWork;
use App\Models\JournalPaper;
use App\Models\Publications;
use Livewire\WithPagination;
use App\Models\OngoingResearch;
use App\Models\CommunityService;
use App\Models\FirstAppointment;
use App\Models\StaffPublication;
use App\Models\CompletedResearch;
use App\Models\TeachingExperience;
use App\Models\InitialQualification;
use Illuminate\Support\Facades\Auth;
use App\Models\AdditionalQualification;
use App\Models\UniversityAdministration;

class Profile extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $user, $staffId;
    public $search;

    public function mount($staffId)
    {
        // Fetch user details based on $userId
        $this->user = User::where('staffId', $staffId)->first();
        $this->admin = Auth::user();

        $this->user->load(['interests' => function ($query) {
            $query->orderBy('interest', 'asc');
        }]);
    }

    public function render()
    {
        $pendingEvaluation = APER::where('user_id', $this->user->id)
            ->whereDoesntHave('evaluation')
            ->first();


        $pendingApproval = APER::where('user_id', $this->user->id)
            ->whereHas('evaluation', function ($query) {
                $query->where('status_id', 2);
            })
            ->whereDoesntHave('approval')
            ->first();

        $isApproved = APER::where('user_id', $this->user->id)
            ->whereHas('approval')
            ->first();

        $socials = socialMedia::where('user_id', $this->user->id)
                    ->leftjoin('social_platforms', 'social_media.socialPlatform_id', '=', 'social_platforms.id')
                    ->select('social_media.*', 'social_platforms.name as sm', 'social_platforms.icon as icon')
                    ->orderBy('social_platforms.name', 'ASC')
                    ->get();

        $interests = Interests::where('user_id', $this->user->id)
                    ->orderBy('interest', 'asc')
                    ->get();

        $firstAppointment = FirstAppointment::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $experiences = TeachingExperience::where('user_id', $this->user->id)
            ->orderBy('year')
            ->get();

        $awards = Awards::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->get();

        $honours = Honours::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->get();

        $memberships = Membership::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->orderBy('society', 'asc')
            ->get();

        $conferences = Conference::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->orderBy('conference', 'asc')
            ->orderBy('location', 'asc')
            ->get();

        $Iqualifications = InitialQualification::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->orderBy('institution', 'asc')
            ->get();

        $qualifications = AdditionalQualification::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->orderBy('institution', 'asc')
            ->get();

        $researches = CompletedResearch::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->get();


        $ongoingResearches = OngoingResearch::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->get();

        $monographs = StaffPublication::where('user_id', $this->user->id)
            ->where('category_id', 1)
            ->orderBy('year', 'desc')
            ->get();

        $articles = StaffPublication::where('user_id', $this->user->id)
            ->where('category_id', 2)
            ->orderBy('year', 'desc')
            ->get();

        $conferenceProceedings = StaffPublication::where('user_id', $this->user->id)
            ->where('category_id', 3)
            ->orderBy('year', 'desc')
            ->get();

        $creativeWorks = CreativeWork::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->orderBy('title', 'asc')
            ->orderBy('author', 'asc')
            ->orderBy('category', 'asc')
            ->get();

        $acceptedPapers = JournalPaper::where('user_id', $this->user->id)
            ->where('isSubmitted', 0)
            ->orderBy('year', 'desc')
            ->get();

        $submittedPapers = JournalPaper::where('user_id', $this->user->id)
            ->where('isSubmitted', 1)
            ->orderBy('year', 'desc')
            ->get();

        $administrations = UniversityAdministration::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->get();

        $services = CommunityService::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->get();

        return view('livewire.admin.user.profile', [
            'socials' => $socials,
            'interests' => $interests,
            'firstAppointment' => $firstAppointment,
            'experiences' => $experiences,
            'awards' => $awards,
            'honours' => $honours,
            'memberships' => $memberships,
            'conferences' => $conferences,
            'Iqualifications' => $Iqualifications,
            'Aqualifications' => $qualifications,
            'researches' => $researches,
            'ongoingResearches' => $ongoingResearches,
            'monographs' => $monographs,
            'articles' => $articles,
            'conferenceProceedings' => $conferenceProceedings,
            'creativeWorks' => $creativeWorks,
            'acceptedPapers' => $acceptedPapers,
            'submittedPapers' => $submittedPapers,
            'administrations' => $administrations,
            'services' => $services,
            'pendingEvaluation' => $pendingEvaluation,
            'pendingApproval' => $pendingApproval,
            'isApproved' => $isApproved,
            ])->extends('layouts.admin')->section('content');
    }
}
