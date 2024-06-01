<?php

namespace App\Livewire\AllStaff;

use App\Models\User;
use Livewire\Component;
use App\Models\socialMedia;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;
    public $photo, $search, $user_id;

    public function mount()
    {

    }


    public function render()
    {


        $allstaff = User::whereHas('profile', function ($query) {
            $query->where('profiles.lastname', 'like', '%'.$this->search.'%')
                ->orWhere('profiles.firstname', 'like', '%'.$this->search.'%');
        })
        ->where(function ($query) {
            $query->where('users.staffId', 'like', '%'.$this->search.'%')
                ->orWhere('users.email', 'like', '%'.$this->search.'%')
                ->orWhere('ranks.rank', 'like', '%'.$this->search.'%'); // Include rank in search
        })
        ->whereIn('users.role_as', [2, 3]) // Check if role_as is 2 or 3
        ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
        ->leftJoin('titles', 'profiles.title_id', '=', 'titles.id')
        ->leftJoin('ranks', 'profiles.rank_id', '=', 'ranks.id') // Join ranks table
        ->select('users.*',
                 'profiles.lastname as lastname',
                 'profiles.firstname as firstname',
                 'profiles.slug as slug',
                 'titles.name as title',
                 'ranks.rank as rank') // Select rank
        ->orderBy('profiles.lastname', 'ASC')
        ->paginate(9);

        return view('livewire.all-staff.index',[
            'allstaff' => $allstaff,
            ])->extends('layouts.public')->section('content');
    }
}
