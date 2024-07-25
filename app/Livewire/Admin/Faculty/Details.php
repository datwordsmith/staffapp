<?php

namespace App\Livewire\Admin\Faculty;

use App\Models\Faculty;
use Livewire\Component;
use App\Models\Department;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Details extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $facultyId;
    public $search;

    public function mount($facultyId)
    {
        $this->admin = Auth::user();
        $this->facultyId = $facultyId;
        $this->faculty = Faculty::where('id', $this->facultyId)->first();
    }

    public function render()
    {
        $departments = Department::where('faculty_id', $this->facultyId)
        ->orderBy('name', 'ASC')
        ->get();

        return view('livewire.admin.faculty.details', [
            'faculty' => $this->faculty,
            'departments' => $departments,
        ])->extends('layouts.admin')->section('content');
    }
}
