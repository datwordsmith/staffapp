<?php

namespace App\Livewire\Admin\Faculty;

use App\Models\User;
use App\Models\Faculty;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $faculty_id, $name, $dean_id, $description, $deleteName;

    public $search;

    public function mount()
    {
        $this->admin = Auth::user();
    }

    public function rules(){
        return [
            'name' => 'required|string|unique:faculties,name',
            'description' => 'nullable|text',
            'dean_id' => 'nullable|numeric|min:1|exists:users,id',

        ];
    }

    public function resetInput(){
        $this->name = null;
        $this->description = null;
        $this->dean_id = null;
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
            'dean_id' => $validatedData['dean_id'],
        ]);
        session()->flash('message', 'Faculty Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editFaculty(int $faculty_id){
        $this->faculty_id = $faculty_id;
        $faculty = Faculty::findOrFail($faculty_id);
        $this->name = $faculty->name;
        $this->dean_id = $faculty->dean_id;
    }

    public function updateFaculty(){
        $validatedData = $this->validate([
            'dean_id' => 'nullable|numeric|min:1|exists:users,id',
        ]);
        Faculty::findOrFail($this->faculty_id)->update([
            'name' => $this->name,
            'dean_id' => $validatedData['dean_id'],
        ]);
        session()->flash('message', 'Faculty Updated Successfully.');
        $this->dispatch('close-modal');
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

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {

        $faculties = Faculty::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('name', 'ASC')
            ->paginate(10);

        $users = User::join('profiles', 'profiles.user_id', '=', 'users.id')
                ->leftJoin('titles', 'profiles.title_id', '=', 'titles.id')
                ->select('users.*', 'profiles.lastname as lastname', 'profiles.firstname as firstname', 'titles.name as title')
                ->orderBy('profiles.lastname', 'ASC')
                ->get();

        return view('livewire.admin.faculty.index', [
            'faculties' => $faculties,
            'deleteName' => $this->deleteName,
            'users' => $users,
            ])->extends('layouts.admin')->section('content');
    }
}
