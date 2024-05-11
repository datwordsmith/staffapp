<?php

namespace App\Livewire\Staff\UniversityAdministration;

use App\Models\UniversityAdministration;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $duty, $experience, $commending_officer, $date;
    public $user, $staffId, $deleteName;
    public $search;
    public $administration_id;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function rules(){
        return [
            'duty' => 'required|string',
            'experience' => 'required|string',
            'commending_officer' => 'nullable|string',
            'date' => 'required|date_format:Y',
        ];
    }

    public function resetInput(){
        $this->duty = null;
        $this->experience = null;
        $this->commending_officer = null;
        $this->date = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeAdministration(){
        $validatedData = $this->validate();
        $this->user->universityAdministrations()->create([
            'duty' => $validatedData['duty'],
            'experience' => $validatedData['experience'],
            'commending_officer' => $validatedData['commending_officer'],
            'date' => $validatedData['date'],
        ]);
        session()->flash('message', 'Item Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editAdministration(int $administration_id){
        $this->administration_id = $administration_id;
        $administration = UniversityAdministration::findOrFail($administration_id);
        $this->duty = $administration->duty;
        $this->experience = $administration->experience;
        $this->commending_officer = $administration->commending_officer;
        $this->date = $administration->date;
    }

    public function updateAdministration(){
        $validatedData = $this->validate();
        UniversityAdministration::findOrFail($this->administration_id)->update([
            'duty' => $validatedData['duty'],
            'experience' => $validatedData['experience'],
            'commending_officer' => $validatedData['commending_officer'],
            'date' => $validatedData['date'],
        ]);
        session()->flash('message', 'Item Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteAdministration($administration_id)
    {
        $this->administration_id = $administration_id;
        $administration = UniversityAdministration::findOrFail($administration_id);
    }

    public function destroyAdministration()
    {
        try {
            $administration = UniversityAdministration::FindOrFail($this->administration_id);
            $administration->delete();
            session()->flash('message', 'Item deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete item because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting the item.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the item.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $administrations = UniversityAdministration::where('user_id', $this->user->id)
            ->where(function ($query) {
                $query->where('duty', 'like', '%' . $this->search . '%')
                    ->orWhere('experience', 'like', '%' . $this->search . '%')
                    ->orWhere('commending_officer', 'like', '%' . $this->search . '%')
                    ->orWhere('date', 'like', '%' . $this->search . '%');
            })
            ->orderBy('date', 'desc')
            ->paginate(5);

        return view('livewire.staff.university-administration.index', [
            'administrations' => $administrations,
            ])->extends('layouts.staff')->section('content');
    }
}
