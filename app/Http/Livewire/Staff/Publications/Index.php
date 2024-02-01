<?php

namespace App\Http\Livewire\Staff\Publications;

use App\Models\Publications;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $publication, $url;
    public $user, $staffId, $deleteName;
    public $search;

    public function mount()
    {
        // Fetch user details based on $userId
        $this->user = Auth::user();

    }


    public function rules(){
        return [
            'publication' => 'required|string',
            'url' => 'url|nullable',
        ];
    }

    public function resetInput(){
        $this->publication = null;
        $this->url = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storePublication(){
        $validatedData = $this->validate();
        $this->user->publications()->create([
            'publication' => $validatedData['publication'],
            'url' => $validatedData['url'],
        ]);
        session()->flash('message', 'Publication Added Successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function editPublication(int $publication_id){
        $this->publication_id = $publication_id;
        $publication = Publications::findOrFail($publication_id);
        $this->publication = $publication->publication;
    }

    public function updatePublication(){
        $validatedData = $this->validate();
        Publications::findOrFail($this->publication_id)->update([
            'publication' => $validatedData['publication'],
            'url' => $validatedData['url'],
        ]);
        session()->flash('message', 'Publication Updated Successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function deletePublication($publication_id)
    {
        $this->publication_id = $publication_id;
        $publication = Publications::findOrFail($publication_id);
        $this->deleteName = $publication->publication;
    }

    public function destroyPublication()
    {
        try {
            $publication = Publications::FindOrFail($this->publication_id);
            $publication->delete();
            session()->flash('message', 'Publication deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete publication because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting the publication.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the publication.');
        }

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $publications = Publications::where('user_id', $this->user->id)
            ->where(function ($query) {
                $query->where('publication', 'like', '%' . $this->search . '%')
                    ->orWhere('url', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('livewire.staff.publications.index', [
            'publications' => $publications,
            ])->extends('layouts.staff')->section('content');
    }
}
