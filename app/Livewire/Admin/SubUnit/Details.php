<?php

namespace App\Livewire\Admin\SubUnit;

use App\Models\User;
use Livewire\Component;
use App\Models\SubUnit;
use App\Models\staffSubUnit;
use Illuminate\Support\Facades\Auth;

class Details extends Component
{
    public $subunitId;

    public function mount($subunitId)
    {
        $this->admin = Auth::user();
        $this->subunitId = $subunitId;
        $this->subunit = SubUnit::where('id', $this->subunitId)->first();
    }

    public function hasProfile($userId)
    {
        $user = User::findOrFail($userId);
        return $user->profile()->exists();
    }


    public function render()
    {
        $staff = staffSubUnit::where('subunit_id', $this->subunitId)->get();
        $staffdetails = staffSubUnit::where('subunit_id', $this->subunitId)->get();

        return view('livewire.admin.subunit.details',  [
            'staff' => $staff,
            'staffdetails' => $staffdetails,
            'subunit' => $this->subunit,
        ])->extends('layouts.admin')->section('content');;
    }
}
