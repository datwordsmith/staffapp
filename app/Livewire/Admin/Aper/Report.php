<?php

namespace App\Livewire\Admin\Aper;

use App\Models\APER;
use App\Models\User;
use App\Models\Awards;
use App\Models\Honours;
use Livewire\Component;
use App\Models\Conference;
use App\Models\Membership;
use App\Models\Appointment;
use App\Models\AperApproval;
use App\Models\CreativeWork;
use App\Models\JournalPaper;
use App\Models\AperAcceptance;
use App\Models\AperEvaluation;
use App\Models\OngoingResearch;
use App\Models\CommunityService;
use App\Models\FirstAppointment;
use App\Models\StaffPublication;
use App\Models\CompletedResearch;
use App\Models\TeachingExperience;
use App\Models\InitialQualification;
use Illuminate\Support\Facades\Auth;
use App\Models\AdditionalQualification;
use App\Models\AperEvaluationQuestions;
use App\Models\UniversityAdministration;

class Report extends Component
{

    public $aper, $admin;
    public $questions;
    public $details;
    public $aperId, $user, $staffId, $status, $note;

    public function mount($aperId)
    {
        $this->aper = APER::where('id', $aperId)->first();

        $staffId = $this->aper->user->staffId;
        // Fetch user details based on $userId
        $this->user = User::where('staffId', $staffId)->first();
        $this->admin = Auth::user();

        $this->details = AperEvaluation::where('aper_id', $this->aperId)->first();
        $this->questions = AperEvaluationQuestions::orderBy('id', 'asc')->get();

    }

    public function render()
    {
        $approvalDetail = AperApproval::where('aper_id', $this->aper->id)->first();

        $staffAction = AperAcceptance::where('aper_id', $this->aper->id)->first();

        $AppointmentHistory = Appointment::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
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


        return view('livewire.admin.aper.report', [
            'approvalDetail' => $approvalDetail,
            'staffAction' => $staffAction,
            'firstAppointment' => $firstAppointment,
            'AppointmentHistory' => $AppointmentHistory,
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
        ])->extends('layouts.admin')->section('content');
    }
}
