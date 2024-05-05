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
    public $socialMediaAccounts = [];

    public function mount()
    {
        //$this->loadSocialMediaAccounts();
    }

    public function loadSocialMediaAccounts()
    {
        $users = User::where('role_as', 2)
            ->with('socialMedia.socialPlatform')
            ->select('id')
            ->get();

        foreach ($users as $user) {
            $socialMedia = SocialMedia::where('user_id', $user->id)
                ->join('social_platforms', 'social_media.socialPlatform_id', '=', 'social_platforms.id')
                ->select('social_media.*', 'social_platforms.name as platform', 'social_platforms.icon as icon')
                ->orderBy('social_platforms.name', 'asc')
                ->get();

            $this->socialMediaAccounts[$user->id] = $socialMedia;
        }
    }



    public function render()
    {
        $allstaff = User::whereHas('profile')
        ->where(function ($query) {
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

        $this->loadSocialMediaAccounts(); // Load social media accounts before rendering

        return view('livewire.all-staff.index',[
            'allstaff' => $allstaff,
            ])->extends('layouts.public')->section('content');
    }
}
