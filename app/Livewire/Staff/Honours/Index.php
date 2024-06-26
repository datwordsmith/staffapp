<?php

namespace App\Livewire\Staff\Honours;

use App\Models\Honours;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $award, $awarding_body, $date;
    public $user, $staffId, $deleteName;
    public $search;
    public $award_id;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function rules(){
        return [
            'award' => 'required|string',
            'awarding_body' => 'required|string',
            'date' => 'required|date|before_or_equal:today',
        ];
    }

    public function resetInput(){
        $this->award = null;
        $this->awarding_body = null;
        $this->date = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeAward(){
        $validatedData = $this->validate();
        $this->user->honours()->create([
            'award' => $validatedData['award'],
            'awarding_body' => $validatedData['awarding_body'],
            'date' => $validatedData['date'],
        ]);
        session()->flash('message', 'Award Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editAward(int $award_id){
        $this->award_id = $award_id;
        $award = Honours::findOrFail($award_id);
        $this->award = $award->award;
        $this->awarding_body = $award->awarding_body;
        $this->date = $award->date;
    }

    public function updateAward(){
        $validatedData = $this->validate();
        Honours::findOrFail($this->award_id)->update([
            'award' => $validatedData['award'],
            'awarding_body' => $validatedData['awarding_body'],
            'date' => $validatedData['date'],
        ]);
        session()->flash('message', 'Award Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteAward($award_id)
    {
        $this->award_id = $award_id;
        $award = Honours::findOrFail($award_id);
    }

    public function destroyAward()
    {
        try {
            $award = Honours::FindOrFail($this->award_id);
            $award->delete();
            session()->flash('message', 'Award deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete award because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting the award.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the award.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $awards = Honours::where('user_id', $this->user->id)
            ->where(function ($query) {
                $query->where('award', 'like', '%' . $this->search . '%')
                    ->orWhere('awarding_body', 'like', '%' . $this->search . '%')
                    ->orWhere('date', 'like', '%' . $this->search . '%');
            })
            ->orderBy('date', 'desc')
            ->paginate(5);

        return view('livewire.staff.honours.index', [
            'awards' => $awards,
            ])->extends('layouts.staff')->section('content');
    }
}
