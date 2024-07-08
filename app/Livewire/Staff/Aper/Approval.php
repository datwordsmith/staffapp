<?php

namespace App\Livewire\Staff\Aper;

use App\Models\APER;
use App\Models\AperApproval;
use App\Models\User;
use Livewire\Component;
use App\Models\AperEvaluation;
use Illuminate\Support\Facades\Auth;
use App\Models\AperEvaluationQuestions;

class Approval extends Component
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

    public function rules()
    {
        return [
            'status' => 'required',
            'note' => 'nullable|string',
        ];
    }

    public function resetInput(){
        $this->status_id = null;
        $this->note = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeApproval()
    {

        $validatedData = $this->validate();
        AperApproval::create([
            'aper_id' => $this->aper->id,
            'approver_id' => $this->admin->id,
            'note' => $validatedData['note'],
            'grade' => $this->details->grade,
            'status_id' => $validatedData['status'],
        ]);

        $this->dispatch('close-modal');
        $this->resetInput();
    }


    public function render()
    {

        $approvalDetail = AperApproval::where('aper_id', $this->aper->id)->first();

        return view('livewire.staff.aper.approval', [
            'approvalDetail' => $approvalDetail,
        ])->extends('layouts.staff')->section('content');
    }
}
