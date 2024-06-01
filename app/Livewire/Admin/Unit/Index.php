<?php

namespace App\Livewire\Admin\Unit;

use App\Models\Unit;
use Livewire\Component;
use Carbon\Traits\Units;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $unit_id, $name, $description, $deleteName;

    public $search;

    public function mount()
    {
        $this->admin = Auth::user();
    }

    public function rules(){
        return [

            'name' => 'required|string|unique:units,name',
            'description' => 'nullable|string',

        ];
    }

    public function resetInput(){
        $this->name = null;
        $this->description = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeUnit(){
        $validatedData = $this->validate();
        Unit::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);
        session()->flash('message', 'Unit Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editUnit(int $unit_id){
        $this->rank_id = $unit_id;
        $unit = Unit::findOrFail($unit_id);
        $this->name = $unit->name;
        $this->description = $unit->description;
    }

    public function updateUnit(){
        $validatedData = $this->validate();
        Unit::findOrFail($this->unit_id)->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);
        session()->flash('message', 'Unit Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteUnit($unit_id)
    {
        $this->unit_id = $unit_id;
        $unit = Unit::findOrFail($unit_id);
        $this->deleteName = $unit->name;
    }

    public function destroyUnit()
    {
        try {
            $unit = Unit::FindOrFail($this->unit_id);
            $unit->delete();
            session()->flash('message', 'Unit deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete unit because it is referenced in another module.');
            } else {
                session()->flash('error', 'An error occurred while deleting the unit.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the unit.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {

        $units = Unit::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('name', 'ASC')
            ->paginate(5);

        return view('livewire.admin.unit.index', [
            'units' => $units,
            'deleteName' => $this->deleteName,
            ])->extends('layouts.admin')->section('content');
    }
}
