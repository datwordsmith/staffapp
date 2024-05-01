<?php

namespace App\Livewire\Staff\CreativeWorks;

use Livewire\Component;
use App\Models\CreativeWork;
use Livewire\WithPagination;
use App\Models\CreativeWorks;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $title, $author, $category, $date;
    public $user, $staffId, $deleteName;
    public $search;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function rules(){
        return [
            'title' => 'required|string',
            'author' => 'required|string',
            'category' => 'required|string',
            'date' => 'required|date|before_or_equal:today',
        ];
    }

    public function resetInput(){
        $this->title = null;
        $this->author = null;
        $this->category = null;
        $this->date = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeCreativeWork(){
        $validatedData = $this->validate();
        $this->user->creativeWorks()->create([
            'title' => $validatedData['title'],
            'author' => $validatedData['author'],
            'category' => $validatedData['category'],
            'date' => $validatedData['date'],
        ]);
        session()->flash('message', 'Creative Work Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editCreativeWork(int $creativeWork_id){
        $this->creativeWork_id = $creativeWork_id;
        $creativeWork = CreativeWork::findOrFail($creativeWork_id);
        $this->title = $creativeWork->title;
        $this->author = $creativeWork->author;
        $this->category = $creativeWork->category;
        $this->date = $creativeWork->date;
    }

    public function updateCreativeWork(){
        $validatedData = $this->validate();
        CreativeWork::findOrFail($this->creativeWork_id)->update([
            'title' => $validatedData['title'],
            'author' => $validatedData['author'],
            'category' => $validatedData['category'],
            'date' => $validatedData['date'],
        ]);
        session()->flash('message', 'Creative Work Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteCreativeWork($creativeWork_id)
    {
        $this->creativeWork_id = $creativeWork_id;
        $creativeWork = CreativeWork::findOrFail($creativeWork_id);
    }

    public function destroyCreativeWork()
    {
        try {
            $creativeWork = CreativeWork::FindOrFail($this->creativeWork_id);
            $creativeWork->delete();
            session()->flash('message', 'Item deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete this item because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting this item.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting this item.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $creativeWorks = CreativeWork::where('user_id', $this->user->id)
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('author', 'like', '%' . $this->search . '%')
                    ->orWhere('category', 'like', '%' . $this->search . '%')
                    ->orWhere('date', 'like', '%' . $this->search . '%');
            })
            ->orderBy('date', 'desc')
            ->orderBy('title', 'asc')
            ->orderBy('author', 'asc')
            ->orderBy('category', 'asc')
            ->paginate(5);

        return view('livewire.staff.creative-works.index', [
            'creativeWorks' => $creativeWorks,
            ])->extends('layouts.staff')->section('content');
    }
}
