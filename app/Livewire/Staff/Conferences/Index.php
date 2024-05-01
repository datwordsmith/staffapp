<?php

namespace App\Livewire\Staff\Conferences;

use Livewire\Component;
use App\Models\Conference;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $conference, $location, $paper_presented, $date;
    public $user, $staffId, $deleteName;
    public $search;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function rules(){
        return [
            'conference' => 'required|string',
            'location' => 'required|string',
            'paper_presented' => 'nullable|string',
            'date' => 'required|date|before_or_equal:today',
        ];
    }

    public function resetInput(){
        $this->conference = null;
        $this->location = null;
        $this->paper_presented = null;
        $this->date = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeConference(){
        $validatedData = $this->validate();
        $this->user->conferences()->create([
            'conference' => $validatedData['conference'],
            'location' => $validatedData['location'],
            'paper_presented' => $validatedData['paper_presented'],
            'date' => $validatedData['date'],
        ]);
        session()->flash('message', 'Conference Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editConference(int $conference_id){
        $this->conference_id = $conference_id;
        $conference = Conference::findOrFail($conference_id);
        $this->conference = $conference->conference;
        $this->location = $conference->location;
        $this->paper_presented = $conference->paper_presented;
        $this->date = $conference->date;
    }

    public function updateConference(){
        $validatedData = $this->validate();
        Conference::findOrFail($this->conference_id)->update([
            'conference' => $validatedData['conference'],
            'location' => $validatedData['location'],
            'paper_presented' => $validatedData['paper_presented'],
            'date' => $validatedData['date'],
        ]);
        session()->flash('message', 'Conference Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteConference($conference_id)
    {
        $this->conference_id = $conference_id;
        $conference = Conference::findOrFail($conference_id);
    }

    public function destroyConference()
    {
        try {
            $conference = Conference::FindOrFail($this->conference_id);
            $conference->delete();
            session()->flash('message', 'Conference deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete Conference because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting the conference.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the conference.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $conferences = Conference::where('user_id', $this->user->id)
            ->where(function ($query) {
                $query->where('conference', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%')
                    ->orWhere('paper_presented', 'like', '%' . $this->search . '%')
                    ->orWhere('date', 'like', '%' . $this->search . '%');
            })
            ->orderBy('date', 'desc')
            ->orderBy('conference', 'asc')
            ->orderBy('location', 'asc')
            ->paginate(5);

        return view('livewire.staff.conferences.index', [
            'conferences' => $conferences,
            ])->extends('layouts.staff')->section('content');
    }
}
