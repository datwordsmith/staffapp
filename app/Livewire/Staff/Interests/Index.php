<?php

namespace App\Livewire\Staff\Interests;

use Livewire\Component;
use App\Models\Interests;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $interest;
    public $user, $staffId, $deleteName;
    public $search;

    public function mount()
    {
        // Fetch user details based on $userId
        $this->user = Auth::user();
        $user = Auth::user();
    }


    public function rules(){
        return [
            'interest' => 'required|string|unique:interests,interest',
        ];
    }

    public function resetInput(){
        $this->interest = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeInterest(){
        $validatedData = $this->validate();
        /* Interests::create([
            'interest' => $validatedData['interest'],
        ]); */
        $this->user->interests()->create([
            'interest' => $validatedData['interest'],
        ]);
        session()->flash('message', 'Interest Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editInterest(int $interest_id){
        $this->interest_id = $interest_id;
        $interest = Interests::findOrFail($interest_id);
        $this->interest = $interest->interest;
    }

    public function updateInterest(){
        $validatedData = $this->validate();
        Interests::findOrFail($this->interest_id)->update([
            'interest' => $validatedData['interest'],
        ]);
        session()->flash('message', 'Interest Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteInterest($interest_id)
    {
        $this->interest_id = $interest_id;
        $interest = Interests::findOrFail($interest_id);
        $this->deleteName = $interest->interest;
    }

    public function destroyInterest()
    {
        try {
            $interest = Interests::FindOrFail($this->interest_id);
            $interest->delete();
            session()->flash('message', 'Interest deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete interest because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting the interest.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the interest.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $interests = Interests::where('user_id', $this->user->id)
            ->where(function ($query) {
                $query->where('interest', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.staff.interests.index', [
            'interests' => $interests,
            ])->extends('layouts.staff')->section('content');
    }

}
