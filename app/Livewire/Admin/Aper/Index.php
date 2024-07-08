<?php

namespace App\Livewire\Admin\Aper;

use App\Models\APER;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AppraisalCategory;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $user_id, $staffId;
    public $search;

    public function mount()
    {
        $this->admin = Auth::user();
        $this->categories = AppraisalCategory::orderBy('category')->get();
    }


    public function rules()
    {

    }

    public function viewAper($aperId)
    {
        $aper = APER::findOrFail($aperId);
        return redirect()->route('profile', ['staffId' => $aper->user->staffId]);
    }

    public function render()
    {

        $apers = APER::leftJoin('users', 'aper.user_id', '=', 'users.id')
            ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
            ->leftJoin('titles', 'profiles.title_id', '=', 'titles.id')
            ->select('aper.*', 'profiles.lastname as lastname', 'profiles.firstname as firstname', 'users.staffId as staffId', 'titles.name as title')
            ->orderBy('aper.created_at', 'DESC')
            ->get();


        return view('livewire.admin.aper.index', [
            'apers' => $apers,
            ])->extends('layouts.admin')->section('content');
    }
}
