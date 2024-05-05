<?php

namespace App\Livewire\Admin\Aper;

use App\Models\APER;
use App\Models\AperApproval;
use App\Models\User;
use Livewire\Component;
use App\Models\AperEvaluation;
use Illuminate\Support\Facades\Auth;
use App\Models\AperEvaluationQuestions;

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

        return view('livewire.admin.aper.report', [
            'approvalDetail' => $approvalDetail,
        ])->extends('layouts.admin')->section('content');
    }
}
