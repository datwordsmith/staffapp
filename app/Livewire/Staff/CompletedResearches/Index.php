<?php

namespace App\Livewire\Staff\CompletedResearches;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CompletedResearch;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $topic, $publication_number, $summary, $findings, $date;
    public $user, $staffId, $deleteName;
    public $search;

    public function mount()
    {
        // Fetch user details based on $userId
        $this->user = Auth::user();

    }


    public function rules(){
        return [
            'topic' => 'required|string',
            'publication_number' => 'required|string',
            'summary' => 'required|string',
            'findings' => 'required|string',
            'date' => 'required|date|before_or_equal:today',
        ];
    }

    public function resetInput(){
        $this->topic = null;
        $this->publication_number = null;
        $this->summary = null;
        $this->findings = null;
        $this->date = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeResearch(){
        $validatedData = $this->validate();
        $this->user->completedResearches()->create([
            'topic' => $validatedData['topic'],
            'publication_number' => $validatedData['publication_number'],
            'summary' => $validatedData['summary'],
            'findings' => $validatedData['findings'],
            'date' => $validatedData['date'],
        ]);
        session()->flash('message', 'Research Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editResearch(int $research_id){
        $this->research_id = $research_id;
        $research = CompletedResearch::findOrFail($research_id);
        $this->topic = $research->topic;
        $this->publication_number = $research->publication_number;
        $this->summary = $research->summary;
        $this->findings = $research->findings;
        $this->date = $research->date;
    }

    public function updateResearch(){
        $validatedData = $this->validate();
        CompletedResearch::findOrFail($this->research_id)->update([
            'topic' => $validatedData['topic'],
            'publication_number' => $validatedData['publication_number'],
            'summary' => $validatedData['summary'],
            'findings' => $validatedData['findings'],
            'date' => $validatedData['date'],
        ]);
        session()->flash('message', 'Research Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteResearch($research_id)
    {
        $this->research_id = $research_id;
        $research = CompletedResearch::findOrFail($research_id);

    }

    public function destroyResearch()
    {
        try {
            $research = CompletedResearch::FindOrFail($this->research_id);
            $research->delete();
            session()->flash('message', 'Research deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete research because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting the research.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the research.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $researches = CompletedResearch::where('user_id', $this->user->id)
            ->where(function ($query) {
                $query->where('topic', 'like', '%' . $this->search . '%')
                    ->orWhere('publication_number', 'like', '%' . $this->search . '%')
                    ->orWhere('date', 'like', '%' . $this->search . '%');
            })
            ->orderBy('date', 'desc')
            ->paginate(5);

        return view('livewire.staff.completed-researches.index', [
            'researches' => $researches,
            ])->extends('layouts.staff')->section('content');
    }
}
