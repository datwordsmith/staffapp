<?php

namespace App\Livewire\Admin\Department;

use App\Models\User;
use App\Models\Faculty;
use Livewire\Component;
use App\Models\Department;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $faculties, $department_id, $name, $description, $faculty_id, $hod_id, $deleteName;
    public $search;

    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'faculty_id' => 'required|numeric|min:1|exists:faculties,id',
            'hod_id' => 'nullable|numeric|min:1|exists:users,id',
        ];
    }

    public function mount()
    {
        $this->faculties = Faculty::orderBy('name')->get();
        $this->admin = Auth::user();
    }

    public function resetInput() {
        $this->name = NULL;
        $this->description = null;
        $this->faculty_id = NULL;
        $this->hod_id = NULL;
    }

    public function closeModal() {
        $this->resetInput();
    }

    public function openModal() {
        $this->resetInput();
    }

    public function storeDepartment()
    {
        $validatedData = $this->validate();
        Department::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'faculty_id' => $validatedData['faculty_id'],
            'hod_id' => $validatedData['hod_id'],
        ]);
        session()->flash('message', 'Department Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editDepartment(int $department_id){
        $this->department_id = $department_id;
        $department = Department::findOrFail($department_id);
        $this->name = $department->name;
        $this->description = $department->description;
        $this->faculty_id = $department->faculty_id;
        $this->hod_id = $department->hod_id;
    }

    public function updateDepartment(){
        $validatedData = $this->validate();
        Department::findOrFail($this->department_id)->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'faculty_id' => $validatedData['faculty_id'],
            'hod_id' => $validatedData['hod_id'],
        ]);
        session()->flash('message', 'Department Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteDepartment($department_id)
    {
        $this->department_id = $department_id;
        $department = Department::findOrFail($department_id);
        $this->deleteName = $department->name;
    }

    public function destroyDepartment()
    {
        try {
            $department = Department::FindOrFail($this->department_id);
            $department->delete();
            session()->flash('message', 'Department deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete department because it is referenced in another module.');
            } else {
                session()->flash('error', 'An error occurred while deleting the department.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the department.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {

            $departments = Department::where(function ($query) {
                        $query->where('departments.name', 'like', '%'.$this->search.'%')
                            ->orWhere('faculties.name', 'like', '%'.$this->search.'%')
                            ->orWhere('profiles.lastname', 'like', '%'.$this->search.'%')
                            ->orWhere('profiles.firstname', 'like', '%'.$this->search.'%')
                            ->orWhere('profiles.othername', 'like', '%'.$this->search.'%');
                    })
                    ->join('faculties', 'departments.faculty_id', '=', 'faculties.id')
                    ->leftJoin('profiles', 'departments.hod_id', '=', 'profiles.user_id')
                    ->select('departments.*', 'faculties.name as faculty')
                    ->orderBy('departments.name', 'ASC')
                    ->paginate(10);

            $users = User::join('profiles', 'profiles.user_id', '=', 'users.id')
                    ->leftJoin('titles', 'profiles.title_id', '=', 'titles.id')
                    ->select('users.*', 'profiles.lastname as lastname', 'profiles.firstname as firstname', 'titles.name as title')
                    ->orderBy('profiles.lastname', 'ASC')
                    ->get();

            return view('livewire.admin.department.index', [
                'departments' => $departments,
                'users' => $users,
                'deleteName' => $this->deleteName,
                ])->extends('layouts.admin')->section('content');
    }
}
