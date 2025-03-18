<?php

namespace App\Livewire\AllStaff;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $photo, $search = '', $user_id;

    public function mount()
    {
        // Initialization if needed
    }

    public function render()
    {

        $allstaff = User::where(function ($query) {
                $query->where('users.staffId', 'like', '%'.$this->search.'%')
                    ->orWhere('users.email', 'like', '%'.$this->search.'%')
                    ->orWhere('profiles.lastname', 'like', '%'.$this->search.'%')
                    ->orWhere('profiles.firstname', 'like', '%'.$this->search.'%')
                    ->orWhere('profiles.othername', 'like', '%'.$this->search.'%')
                    ->orWhere('ranks.rank', 'like', '%'.$this->search.'%')
                    ->orWhere('titles.name', 'like', '%'.$this->search.'%');
            })
            ->whereIn('users.role_as', [2, 3])
            ->join('profiles', 'profiles.user_id', '=', 'users.id')
            ->leftJoin('titles', 'profiles.title_id', '=', 'titles.id')
            ->leftJoin('ranks', 'profiles.rank_id', '=', 'ranks.id')
            ->select('users.*', 'profiles.lastname as lastname', 'profiles.firstname as firstname', 'profiles.slug as slug', 'titles.name as title', 'ranks.rank as rank')
            ->orderBy('profiles.lastname', 'ASC')
            ->paginate(9);

        return view('livewire.all-staff.index', [
            'allstaff' => $allstaff,
        ])->extends('layouts.public')->section('content');
    }
}
