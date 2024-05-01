<?php

namespace App\Livewire\Staff\AdditionalQualifications;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\AdditionalQualification;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $institution, $qualification, $date;
    public $user, $staffId, $deleteName;
    public $search;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function rules(){
        return [
            'institution' => 'required|string',
            'qualification' => 'required|string',
            'date' => 'required|date|before_or_equal:today',
        ];
    }

    public function resetInput(){
        $this->institution = null;
        $this->qualification = null;
        $this->date = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeQualification(){
        $validatedData = $this->validate();
        $this->user->additionalQualifications()->create([
            'institution' => $validatedData['institution'],
            'qualification' => $validatedData['qualification'],
            'date' => $validatedData['date'],
        ]);
        session()->flash('message', 'Qualification Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editQualification(int $qualification_id){
        $this->qualification_id = $qualification_id;
        $qualification = AdditionalQualification::findOrFail($qualification_id);
        $this->institution = $qualification->institution;
        $this->qualification = $qualification->qualification;
        $this->date = $qualification->date;
    }

    public function updateQualification(){
        $validatedData = $this->validate();
        AdditionalQualification::findOrFail($this->qualification_id)->update([
            'institution' => $validatedData['institution'],
            'qualification' => $validatedData['qualification'],
            'date' => $validatedData['date'],
        ]);
        session()->flash('message', 'Qualification Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteQualification($qualification_id)
    {
        $this->qualification_id = $qualification_id;
        $qualification = AdditionalQualification::findOrFail($qualification_id);
    }

    public function destroyQualification()
    {
        try {
            $qualification = AdditionalQualification::FindOrFail($this->qualification_id);
            $qualification->delete();
            session()->flash('message', 'Qualification deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete qualification because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting the qualification.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the qualification.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $qualifications = AdditionalQualification::where('user_id', $this->user->id)
            ->where(function ($query) {
                $query->where('institution', 'like', '%' . $this->search . '%')
                    ->orWhere('qualification', 'like', '%' . $this->search . '%')
                    ->orWhere('date', 'like', '%' . $this->search . '%');
            })
            ->orderBy('date', 'desc')
            ->orderBy('institution', 'asc')
            ->paginate(5);

        return view('livewire.staff.additional-qualifications.index', [
            'qualifications' => $qualifications,
            ])->extends('layouts.staff')->section('content');
    }
}
