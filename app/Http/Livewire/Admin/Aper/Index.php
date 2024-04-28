<?php

namespace App\Http\Livewire\Admin\Aper;

use App\Models\APER;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
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
    }


    public function rules()
    {

    }

    public function render()
    {

        $apers = APER::where(function ($query) {
            $query->whereHas('approval.status', function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%');
                })
                ->orWhereHas('evaluation.status', function ($q) {
                    $q->where('name', 'like', '%'.$this->search.'%');
                })
                ->orWhereHas('evaluation', function ($q) {
                    $q->where('grade', 'like', '%'.$this->search.'%');
                })
                ->orWhereHas('evaluation', function ($q) {
                    $q->where('grade', 'like', '%'.$this->search.'%');
                })
                ->orwhere('users.staffId', 'like', '%'.$this->search.'%')
                ->orwhere('profiles.lastname', 'like', '%'.$this->search.'%')
                ->orwhere('profiles.firstname', 'like', '%'.$this->search.'%');
        })
        ->leftJoin('users', 'aper.user_id', '=', 'users.id')
        ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
        ->leftJoin('titles', 'profiles.title_id', '=', 'titles.id')
        ->select('aper.*', 'profiles.lastname as lastname', 'profiles.firstname as firstname', 'users.staffId as staffId', 'titles.name as title')
        ->orderBy('aper.created_at', 'ASC')
        ->paginate(5);

        return view('livewire.admin.aper.index', [
            'apers' => $apers,
            ])->extends('layouts.admin')->section('content');
    }
}
