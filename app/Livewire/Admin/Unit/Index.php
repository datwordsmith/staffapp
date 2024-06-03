<?php

namespace App\Livewire\Admin\Unit;

use App\Models\Unit;
use App\Models\User;
use Livewire\Component;
use Carbon\Traits\Units;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $unit_id, $name, $head_title, $head_id, $deleteName;

    public $search;

    public function mount()
    {
        $this->admin = Auth::user();
    }

    public function rules(){
        return [

            'name' => 'required|string|unique:units,name',
            'head_title' => 'required|string',
            'head_id' => 'nullable|numeric|min:1|exists:users,id',

        ];
    }

    public function resetInput(){
        $this->name = null;
        $this->head_title = null;
        $this->head_id = null;
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
            'head_title' => $validatedData['head_title'],
            'head_id' => $validatedData['head_id'],
        ]);
        session()->flash('message', 'Unit Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editUnit(int $unit_id){
        $this->unit_id = $unit_id;
        $unit = Unit::findOrFail($unit_id);
        $this->name = $unit->name;
        $this->head_title = $unit->head_title;
        $this->head_id = $unit->head_id;
    }

    public function updateUnit(){
        $validatedData = $this->validate([
            'head_title' => 'required|string',
            'head_id' => 'nullable|numeric|min:1|exists:users,id',
        ]);
        Unit::findOrFail($this->unit_id)->update([
            'name' => $this->name,
            'head_title' => $validatedData['head_title'],
            'head_id' => $validatedData['head_id'],
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
            ->paginate(10);

        $users = User::join('profiles', 'profiles.user_id', '=', 'users.id')
            ->leftJoin('titles', 'profiles.title_id', '=', 'titles.id')
            ->select('users.*', 'profiles.lastname as lastname', 'profiles.firstname as firstname', 'titles.name as title')
            ->orderBy('profiles.lastname', 'ASC')
            ->get();

        return view('livewire.admin.unit.index', [
            'units' => $units,
            'deleteName' => $this->deleteName,
            'users' => $users,
            ])->extends('layouts.admin')->section('content');
    }
}
