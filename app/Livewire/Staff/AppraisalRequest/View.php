<?php

namespace App\Livewire\Staff\AppraisalRequest;

use App\Models\APER;
use App\Models\User;
use Livewire\Component;
use App\Models\AperApproval;
use App\Models\AperAcceptance;
use App\Models\AperEvaluation;
use App\Models\AppraisalCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\AperEvaluationQuestions;

class View extends Component
{

    public $aper;
    public $categories, $questions;
    public $details, $isRequired;
    public $aperId, $user, $staffId, $status_id, $status, $note;

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

        $this->categories = AppraisalCategory::orderBy('category')->get();

    }

    public function rules()
    {
        return [
            'status' => 'required',
            'note' => $this->status == 6 ? 'required|string' : 'nullable|string',
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

    public function updatedStatus($value)
    {
        $this->isRequired = $value == 6 ? "required" : "";
    }

    public function storeAcceptance()
    {
        $validatedData = $this->validate();
        AperAcceptance::create([
            'aper_id' => $this->aper->id,
            'staff_id' => $this->user->id,
            'status_id' => $validatedData['status'],
            'note' => $validatedData['note'],
        ]);

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {

        $approvalDetail = AperApproval::where('aper_id', $this->aper->id)
            ->first();

        $staffAction = AperAcceptance::where('aper_id', $this->aper->id)
            ->first();

        return view('livewire.staff.appraisal-request.view', [
            'approvalDetail' => $approvalDetail,
            'staffAction' => $staffAction,
        ])->extends('layouts.staff')->section('content');
    }
}
