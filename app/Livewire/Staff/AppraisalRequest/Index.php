<?php

namespace App\Livewire\Staff\AppraisalRequest;

use App\Models\APER;
use App\Models\AppraisalCategory;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CurrentAppointment;
use App\Models\TeachingExperience;
use App\Models\InitialQualification;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $status, $isRequired;
    public $categories, $user, $staffId, $category_id, $deleteName;
    public $search;
    public $currentYear;

    public $aper_id;

    public function mount()
    {
        $this->user = Auth::user();
        $this->categories = AppraisalCategory::orderBy('category')->get();
        $this->currentYear = date('Y');
    }

    public function rules(){
        return [
            'category_id' => 'required|numeric|min:1|exists:appraisal_category,id',
        ];
    }

    public function checkRecords(){

        $checks = [];

        $currentAppointment = CurrentAppointment::where('user_id', $this->user->id)->first();
        if (!$currentAppointment) {
            $checks[] = "Current appointment record does not exist.";
        }

        $initialQualification = InitialQualification::where('user_id', $this->user->id)->first();
        if (!$initialQualification) {
            $checks[] = "Initial qualification record does not exist.";
        }

        if ($this->user->role_as == 2) {
            $teachingExperience = TeachingExperience::where('user_id', $this->user->id)->first();
            if (!$teachingExperience) {
                $checks[] = "Teaching experience record does not exist.";
            }
        }

        $profile = Profile::where('user_id', $this->user->id)->first();
        if (empty($profile->dob)) {
            $checks[] = "Your Date of Birth record does not exist.";
        }

        if ($this->userHasAper())
        {
            //$checks[] = "You have an Appraisal Request for this year";
        }

        return $checks;
    }

    public function resetInput(){
        $this->category_id = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeAper(){
        if(!$this->userHasAper()) {
            $validatedData = $this->validate();
            $this->user->appraisalRequests()->create([
                'category_id' => $validatedData['category_id'],
            ]);
            session()->flash('message', 'Appraisal Request Submitted Successfully.');
            $this->dispatch('close-modal');
            $this->resetInput();
        }
        else {
            session()->flash('error', 'Failed to add Appraisal Reques.');
        }
    }

    public function deleteAper($aper_id)
    {
        $this->aper_id = $aper_id;
        $aper = APER::findOrFail($aper_id);
    }

    public function destroyAper()
    {
        try {
            $aper = APER::FindOrFail($this->aper_id);

            $hasEvaluation = $aper->evaluation()->exists();

            if ($hasEvaluation) {
                session()->flash('error', 'Cannot delete request because it is referenced in evaluation table.');
            } else {
                $aper->delete();
                session()->flash('message', 'Appraisal Request deleted successfully.');
            }

        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the award.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function viewAper() {
        return redirect()->to('staff/profile');
    }

    public function userHasAper()
    {
        return APER::where('user_id', $this->user->id)
            ->whereYear('created_at', $this->currentYear)
            ->exists();
    }

    public function render()
    {

        $apers = APER::where('user_id', $this->user->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(5);


        $isPending = APER::where('user_id', $this->user->id)
            ->whereYear('aper.created_at', $this->currentYear)
            ->leftJoin('aper_approval', 'aper_approval.aper_id', '=', 'aper.id')
            ->whereNull('aper_approval.aper_id')
            ->exists();

        $checks = $this->checkRecords();
        $hasAperRecord = $this->userHasAper();

        return view('livewire.staff.appraisal-request.index', [
            'apers' => $apers,
            'checks' => $checks,
            'isPending' => $isPending,
            'categories' => $this->categories,
            'hasAperRecord' => $hasAperRecord,
            ])->extends('layouts.staff')->section('content');
    }
}
