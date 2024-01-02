<?php

namespace App\Http\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $deleteName;
    public $search;

    public function mount()
    {
        $this->admin = Auth::user();
    }

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

        return view('livewire.admin.user.index', [
            'users' => $users,
            'deleteName' => $this->deleteName,
            ])->extends('layouts.admin')->section('content');
    }
}
