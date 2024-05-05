<?php

namespace App\Livewire\Staff\AppraisalRequest;

use App\Models\APER;
use App\Models\AperApproval;
use App\Models\User;
use Livewire\Component;
use App\Models\AperEvaluation;
use Illuminate\Support\Facades\Auth;
use App\Models\AperEvaluationQuestions;

class View extends Component
{

    public $aper;
    public $questions;
    public $details;
    public $aperId, $user, $staffId, $status, $note;

    public function mount($aperId)
    {
        $this->user = Auth::user();

        $this->aper = APER::where('id', $aperId)
            ->where('user_id', $this->user->id)
            ->first();

        if (!$this->aper) {
            return redirect()->route('myprofile');
        }

        $this->details = AperEvaluation::where('aper_id', $this->aperId)
            ->first();

        $this->questions = AperEvaluationQuestions::orderBy('id', 'asc')->get();

    }

    public function render()
    {

        $approvalDetail = AperApproval::where('aper_id', $this->aper->id)
            ->first();

        return view('livewire.staff.appraisal-request.view', [
            'approvalDetail' => $approvalDetail,
        ])->extends('layouts.staff')->section('content');
    }
}
