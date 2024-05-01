<?php

namespace App\Livewire\Admin\Programme;

use App\Models\Faculty;
use Livewire\Component;
use App\Models\Programme;
use App\Models\Department;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $programme_id, $name, $description, $department_id, $deleteName;
    public $faculty_id;
    public $departments;
    public $search;
    protected $listeners = ['faculty_id' => 'updatedFacultyId'];

    public function rules()
    {
        return [
            'name' => 'required|string',
            'department_id' => 'required|numeric|min:1|exists:departments,id',
        ];
    }

    public function mount()
    {
        $this->faculties = Faculty::orderBy('name')->get();
        $this->departments = [];
        $this->admin = Auth::user();
    }

    public function resetInput() {
        $this->name = NULL;
        $this->department_id = null;
        $this->faculty_id = NULL;
    }

    public function closeModal() {
        $this->resetInput();
    }

    public function openModal() {
        $this->resetInput();
    }

    public function updatedFacultyId($value)
    {
        $this->departments = Department::where('faculty_id', $value)->orderBy('name')->get();
    }

    public function storeProgramme()
    {
        $validatedData = $this->validate();
        Programme::create([
            'name' => $validatedData['name'],
            'department_id' => $validatedData['department_id'],
        ]);
        session()->flash('message', 'Programme Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editProgramme(int $programme_id){
        $this->programme_id = $programme_id;
        $programme = Programme::findOrFail($programme_id);
        $this->name = $programme->name;
        $this->department_id = $programme->department_id;

        // Retrieve the department
        $department = Department::findOrFail($programme->department_id);

        // Set the faculty for the edit form
        $this->faculty_id = $department->faculty_id;

        // Update the departments dropdown based on the faculty of the existing department
        $this->updatedFacultyId($department->faculty_id);
    }

    public function updateProgramme(){
        $validatedData = $this->validate();
        Programme::findOrFail($this->programme_id)->update([
            'name' => $validatedData['name'],
            'department_id' => $validatedData['department_id'],
        ]);
        session()->flash('message', 'Programme Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteProgramme($programme_id)
    {
        $this->programme_id = $programme_id;
        $programme = Programme::findOrFail($programme_id);
        $this->deleteName = $programme->name;
    }

    public function destroyProgramme()
    {
        try {
            $programme = Programme::FindOrFail($this->programme_id);
            $programme->delete();
            session()->flash('message', 'Programme deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete programme because it is referenced in another module.');
            } else {
                session()->flash('error', 'An error occurred while deleting the programme.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the programme.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {

            $programmes = Programme::where(function ($query) {
                        $query->where('programmes.name', 'like', '%'.$this->search.'%')
                            ->orWhere('departments.name', 'like', '%'.$this->search.'%')
                            ->orWhere('faculties.name', 'like', '%'.$this->search.'%');
                    })
                    ->join('departments', 'programmes.department_id', '=', 'departments.id')
                    ->join('faculties', 'departments.faculty_id', '=', 'faculties.id')
                    ->select('programmes.*', 'departments.name as department', 'faculties.name as faculty')
                    ->orderBy('programmes.name', 'ASC')
                    ->paginate(5);

            return view('livewire.admin.programme.index', [
                'programmes' => $programmes,
                'departments' => $this->departments,
                'deleteName' => $this->deleteName,
                ])->extends('layouts.admin')->section('content');
    }
}
