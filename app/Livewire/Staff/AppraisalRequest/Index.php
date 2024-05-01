<?php

namespace App\Livewire\Staff\AppraisalRequest;

use App\Models\APER;
use App\Models\Profile;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FirstAppointment;
use App\Models\TeachingExperience;
use App\Models\InitialQualification;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $status;
    public $user, $staffId, $deleteName;
    public $search;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function rules(){
        return [
            'status_id' => 'required|numeric|min:1|exists:aper_status,id',
        ];
    }

    public function checkRecords(){

        $checks = [];

        $firstAppointment = FirstAppointment::where('user_id', $this->user->id)->first();
        if (!$firstAppointment) {
            $checks[] = "First appointment record does not exist.";
        }

        $initialQualification = InitialQualification::where('user_id', $this->user->id)->first();
        if (!$initialQualification) {
            $checks[] = "Initial qualification record does not exist.";
        }

        $teachingExperience = TeachingExperience::where('user_id', $this->user->id)->first();
        if (!$teachingExperience) {
            $checks[] = "Teaching experience record does not exist.";
        }

        $profile = Profile::where('user_id', $this->user->id)->first();
        if (empty($profile->dob)) {
            $checks[] = "Your Date of Birth record does not exist.";
        }

        return $checks;
    }

    public function resetInput(){

    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeAper(){
        $this->user->appraisalRequests()->create();
        session()->flash('message', 'Appraisal Request Submitted Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
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
            $aper->delete();
            session()->flash('message', 'Appraisal Request deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete request because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting the request.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the request.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function viewAper() {
        return redirect()->to('staff/profile');
    }

    public function render()
    {

        $apers = APER::where(function ($query) {
            $query->whereHas('approval.status', function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%');
                    $q->orwhere('name', 'like', '%Pending%');
                })
                ->orWhereHas('evaluation.status', function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%');
                    $q->orwhere('name', 'like', '%Pending%');
                })
                ->orWhereHas('evaluation', function ($q) {
                    $q->where('grade', 'like', '%'.$this->search.'%');
                })
                ->orWhere('created_at', 'like', '%' . $this->search . '%');
        })
        ->where('user_id', $this->user->id)
        ->orderBy('created_at', 'ASC')
        ->paginate(5);



        $isPending = APER::where('user_id', $this->user->id)
            ->leftJoin('aper_evaluation', 'aper_evaluation.aper_id', '=', 'aper.id')
            ->leftJoin('aper_approval', 'aper_approval.aper_id', '=', 'aper.id')
            ->whereNotNull('aper_evaluation.aper_id')
            ->whereNotNull('aper_approval.aper_id')
            ->exists();


        $checks = $this->checkRecords();

        return view('livewire.staff.appraisal-request.index', [
            'apers' => $apers,
            'checks' => $checks,
            'isPending' => $isPending,
            ])->extends('layouts.staff')->section('content');
    }
}
