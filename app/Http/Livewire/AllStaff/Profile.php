<?php

namespace App\Http\Livewire\AllStaff;

use App\Models\User;
use Livewire\Component;
use App\Models\socialMedia;
use App\Models\Publications;
use Livewire\WithPagination;

class Profile extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $user, $staffId;
    public $search;

    public function mount($staffId)
    {
        // Fetch user details based on $userId
        $this->user = User::where('staffId', $staffId)->first();

        $this->user->load(['interests' => function ($query) {
            $query->orderBy('interest', 'asc');
        }]);

    }

    public function render()
    {

        $publications = Publications::where('user_id', $this->user->id)
            ->where(function ($query) {
                $query->where('publication', 'like', '%' . $this->search . '%')
                    ->orWhere('url', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $socials = socialMedia::where('user_id', $this->user->id)
                    ->leftjoin('social_platforms', 'social_media.socialPlatform_id', '=', 'social_platforms.id')
                    ->select('social_media.*', 'social_platforms.name as sm', 'social_platforms.icon as icon')
                    ->orderBy('social_platforms.name', 'ASC')
                    ->get();

        return view('livewire.all-staff.profile', [
            'publications' => $publications,
            'socials' => $socials,
            ])->extends('layouts.public_detail')->section('content');
    }
}
