<?php

namespace App\Livewire\Admin\Department;

use App\Models\User;
use Livewire\Component;
use App\Models\Department;
use App\Models\staffDepartment;
use Illuminate\Support\Facades\Auth;

class Details extends Component
{
    public $departmentId;

    public function mount($departmentId)
    {
        $this->admin = Auth::user();
        $this->departmentId = $departmentId;
        $this->department = Department::where('id', $this->departmentId)->first();
    }

    public function hasProfile($userId)
    {
        $user = User::findOrFail($userId);
        return $user->profile()->exists();
    }


    public function render()
    {
        $staff = staffDepartment::where('department_id', $this->departmentId)->get();
        $staffdetails = staffDepartment::where('department_id', $this->departmentId)->get();

        return view('livewire.admin.department.details',  [
            'staff' => $staff,
            'staffdetails' => $staffdetails,
            'department' => $this->department,
        ])->extends('layouts.admin')->section('content');;
    }
}
