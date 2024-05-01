<?php

namespace App\Livewire\Staff\Memberships;

use Livewire\Component;
use App\Models\Membership;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $society, $class, $date;
    public $user, $staffId, $deleteName;
    public $search;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function rules(){
        return [
            'society' => 'required|string',
            'class' => 'required|string',
            'date' => 'required|date|before_or_equal:today',
        ];
    }

    public function resetInput(){
        $this->society = null;
        $this->class = null;
        $this->date = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeMembership(){
        $validatedData = $this->validate();
        $this->user->memberships()->create([
            'society' => $validatedData['society'],
            'class' => $validatedData['class'],
            'date' => $validatedData['date'],
        ]);
        session()->flash('message', 'Membership Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editMembership(int $membership_id){
        $this->membership_id = $membership_id;
        $membership = Membership::findOrFail($membership_id);
        $this->society = $membership->society;
        $this->class = $membership->class;
        $this->date = $membership->date;
    }

    public function updateMembership(){
        $validatedData = $this->validate();
        Membership::findOrFail($this->membership_id)->update([
            'society' => $validatedData['society'],
            'class' => $validatedData['class'],
            'date' => $validatedData['date'],
        ]);
        session()->flash('message', 'Membership Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteMembership($membership_id)
    {
        $this->membership_id = $membership_id;
        $membership = Membership::findOrFail($membership_id);
    }

    public function destroyMembership()
    {
        try {
            $membership = Membership::FindOrFail($this->membership_id);
            $membership->delete();
            session()->flash('message', 'Membership deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete membership because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting the membership.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the membership.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $memberships = Membership::where('user_id', $this->user->id)
            ->where(function ($query) {
                $query->where('society', 'like', '%' . $this->search . '%')
                    ->orWhere('class', 'like', '%' . $this->search . '%')
                    ->orWhere('date', 'like', '%' . $this->search . '%');
            })
            ->orderBy('date', 'desc')
            ->orderBy('society', 'asc')
            ->paginate(5);

        return view('livewire.staff.memberships.index', [
            'memberships' => $memberships,
            ])->extends('layouts.staff')->section('content');
    }
}
