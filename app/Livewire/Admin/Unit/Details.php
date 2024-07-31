<?php

namespace App\Livewire\Admin\Unit;

use App\Models\Unit;
use App\Models\SubUnit;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Details extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $unitId;
    public $search;

    public function mount($unitId)
    {
        $this->admin = Auth::user();
        $this->unitId = $unitId;
        $this->unit = Unit::where('id', $this->unitId)->first();
    }

    public function render()
    {
        $subunits = SubUnit::where('unit_id', $this->unitId)
        ->orderBy('name', 'ASC')
        ->get();

        return view('livewire.admin.unit.details', [
            'unit' => $this->unit,
            'subunits' => $subunits,
        ])->extends('layouts.admin')->section('content');
    }
}
