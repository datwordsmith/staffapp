<?php

namespace App\Livewire\Admin\Title;

use App\Models\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $title_id, $name, $deleteName;

    public $search;

    public function mount()
    {
        $this->admin = Auth::user();
    }

    public function rules(){
        return [
            'name' => 'required|string|unique:titles,name',
        ];
    }

    public function resetInput(){
        $this->name = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeTitle(){
        $validatedData = $this->validate();
        Title::create([
            'name' => $validatedData['name'],
        ]);
        session()->flash('message', 'Title Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editTitle(int $title_id){
        $this->title_id = $title_id;
        $title = Title::findOrFail($title_id);
        $this->name = $title->name;
    }

    public function updateTitle(){
        $validatedData = $this->validate();
        Title::findOrFail($this->title_id)->update([
            'name' => $validatedData['name'],
        ]);
        session()->flash('message', 'Title Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteTitle($title_id)
    {
        $this->title_id = $title_id;
        $title = Title::findOrFail($title_id);
        $this->deleteName = $title->name;
    }

    public function destroyTitle()
    {
        try {
            $title = Title::FindOrFail($this->title_id);
            $title->delete();
            session()->flash('message', 'Title deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete title because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting the title.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the title.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {

        $titles = Title::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('name', 'ASC')
            ->paginate(5);

        return view('livewire.admin.title.index', [
            'titles' => $titles,
            'deleteName' => $this->deleteName,
            ])->extends('layouts.admin')->section('content');
    }
}
