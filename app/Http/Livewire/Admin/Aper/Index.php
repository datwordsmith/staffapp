<?php

namespace App\Http\Livewire\Admin\Aper;

use App\Models\APER;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {

        $users = User::where(function ($query) {
            $query->where('users.staffId', 'like', '%'.$this->search.'%')
                ->orWhere('users.email', 'like', '%'.$this->search.'%')
                ->orWhere('profiles.lastname', 'like', '%'.$this->search.'%')
                ->orWhere('profiles.firstname', 'like', '%'.$this->search.'%');
        })
        ->where('users.role_as', 2)
        ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
        ->leftJoin('titles', 'profiles.title_id', '=', 'titles.id')
        ->select('users.*', 'profiles.lastname as lastname', 'profiles.firstname as firstname', 'profiles.slug as slug', 'titles.name as title')
        ->orderBy('profiles.lastname', 'ASC')
        ->paginate(5);


        return view('livewire.admin.aper.index');
    }
}
