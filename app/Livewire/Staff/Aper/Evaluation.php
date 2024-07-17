<?php

namespace App\Livewire\Staff\Aper;

use App\Models\APER;
use App\Models\AperEvaluation;
use App\Models\AperEvaluationQuestions;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Evaluation extends Component
{
    protected $paginationTheme = 'bootstrap';
    public $aper, $admin;
    public $aperId, $user, $staffId;

    public $questions;

    public $foresight, $penetration, $judgement, $written_expression, $oral_expression, $numeracy, $staff_relationship, $student_relationship, $accepts_responsibility, $pressure_reliabilty, $drive, $knowledge_application, $staff_management, $work_output, $work_quality, $punctuality, $time_management, $comportment, $ict_literacy, $query_commendations;
    public $note;
    public $selectedValues = [];
    public $previousValues, $sumOfValues = 0, $zeros;

    public $is_numeracy=1, $is_knowledge_application = 1, $is_staff_management = 1;

    public $search;

    public function mount($aperId)
    {
        $this->aper = APER::where('id', $aperId)->first();

        $staffId = $this->aper->user->staffId;
        // Fetch user details based on $userId
        $this->user = User::where('staffId', $staffId)->first();
        $this->admin = Auth::user();

        $this->questions = AperEvaluationQuestions::orderBy('id', 'asc')->get();

        $this->previousValues = [];

    }

    public function rules()
    {
        return [
            'note' => 'required|string',
        ];
    }

    public function updated($propertyName)
    {

        $newValue = (int) $this->{$propertyName};
        $oldValue = isset($this->previousValues[$propertyName]) ? (int) $this->previousValues[$propertyName] : 0;

        //Store Values in Array
        $this->selectedValues[$propertyName] = $newValue;

        //Count Number of Zeros (Optional Questions not answered)
        $this->zeros = collect($this->selectedValues)->filter(function ($value) {
            return $value === 0;
        })->count();

        // Update sumOfValues
        $this->sumOfValues = $this->sumOfValues - $oldValue + $newValue;

        // Update previous value
        $this->previousValues[$propertyName] = $newValue;

    }


    public function storeEvaluation()
    {
        $validatedData = $this->validate();
        AperEvaluation::create([
            'aper_id' => $this->aper->id,
            'appraiser_id' => $this->admin->id,
            'foresight' => $this->foresight,
            'penetration' => $this->penetration,
            'judgement' => $this->judgement,
            'written_expression' => $this->written_expression,
            'oral_expression' => $this->oral_expression,
            'numeracy' => $this->numeracy,
            'staff_relationship' => $this->staff_relationship,
            'student_relationship' => $this->student_relationship,
            'accepts_responsibility' => $this->accepts_responsibility,
            'pressure_reliabilty' => $this->pressure_reliabilty,
            'drive' => $this->drive,
            'knowledge_application' => $this->knowledge_application,
            'staff_management' => $this->staff_management,
            'work_output' => $this->work_output,
            'work_quality' => $this->work_quality,
            'punctuality' => $this->punctuality,
            'time_management' => $this->time_management,
            'comportment' => $this->comportment,
            'ict_literacy' => $this->ict_literacy,
            'query_commendations' => $this->query_commendations,
            'grade' => $this->sumOfValues,
            'status_id' => 2,
            'note' => $validatedData['note'],
        ]);

        session()->flash('message', 'Evaluation Complete.');
    }


    public function render()
    {
        $pendingEvaluation = APER::where('id', $this->aper->id)
            ->whereHas('evaluation')
            ->exists();

        $pendingApproval = APER::where('user_id', $this->user->id)
            ->leftJoin('aper_evaluation', 'aper_evaluation.aper_id', '=', 'aper.id')
            ->where('aper_evaluation.status_id', 2)
            ->exists();

        $questions = AperEvaluationQuestions::orderBy('id', 'asc')->get();

        return view('livewire.staff.aper.evaluation', [
            'pendingEvaluation' => $pendingEvaluation,
            'pendingApproval' => $pendingApproval,
            'questions' => $questions,
            'sumOfValues' => $this->sumOfValues,
        ])->extends('layouts.staff')->section('content');
    }
}
