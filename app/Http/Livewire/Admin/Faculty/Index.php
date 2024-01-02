<?php

namespace App\Http\Livewire\Admin\Faculty;

use App\Models\Faculty;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $faculty_id, $name, $description, $deleteName;

    public $search;

    public function mount()
    {
        $this->admin = Auth::user();
    }

    public function rules(){
        return [
            'name' => 'required|string|unique:faculties,name',
            'description' => 'nullable|text',

        ];
    }

    public function resetInput(){
        $this->name = null;
        $this->description = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeFaculty(){
        $validatedData = $this->validate();
        Faculty::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);
        session()->flash('message', 'Faculty Added Successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function editFaculty(int $faculty_id){
        $this->faculty_id = $faculty_id;
        $faculty = Faculty::findOrFail($faculty_id);
        $this->name = $faculty->name;
    }

    public function updateFaculty(){
        $validatedData = $this->validate();
        Faculty::findOrFail($this->faculty_id)->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);
        session()->flash('message', 'Faculty Updated Successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function deleteFaculty($faculty_id)
    {
        $this->faculty_id = $faculty_id;
        $faculty = Faculty::findOrFail($faculty_id);
        $this->deleteName = $faculty->name;
    }

    public function destroyFaculty()
    {
        try {
            $faculty = Faculty::FindOrFail($this->faculty_id);
            $faculty->delete();
            session()->flash('message', 'Faculty deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete faculty because it is referenced in another module.');
            } else {
                session()->flash('error', 'An error occurred while deleting the faculty.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the faculty.');
        }

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function render()
    {

        $faculties = Faculty::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('name', 'ASC')
            ->paginate(5);

        return view('livewire.admin.faculty.index', [
            'faculties' => $faculties,
            'deleteName' => $this->deleteName,
            ])->extends('layouts.admin')->section('content');
    }
}
