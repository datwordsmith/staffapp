<?php

namespace App\Livewire\Admin\SubUnit;

use App\Models\Unit;
use App\Models\User;
use App\Models\SubUnit;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $units, $subunit_id, $name, $unit_id, $hou_id, $deleteName;
    public $search;

    public function rules()
    {
        return [
            'name' => 'required|string',
            'unit_id' => 'required|numeric|min:1|exists:faculties,id',
            'hou_id' => 'nullable|numeric|min:1|exists:users,id',
        ];
    }

    public function mount()
    {
        $this->units = Unit::orderBy('name')->get();
        $this->admin = Auth::user();
    }

    public function resetInput() {
        $this->name = NULL;
        $this->unit_id = NULL;
        $this->hou_id = NULL;
    }

    public function closeModal() {
        $this->resetInput();
    }

    public function openModal() {
        $this->resetInput();
    }

    public function storeSubUnit()
    {
        $validatedData = $this->validate();
        SubUnit::create([
            'name' => $validatedData['name'],
            'unit_id' => $validatedData['unit_id'],
            'hou_id' => $validatedData['hou_id'],
        ]);
        session()->flash('message', 'Sub-Unit Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editSubUnit(int $subunit_id){
        $this->subunit_id = $subunit_id;
        $subunit = SubUnit::findOrFail($subunit_id);
        $this->name = $subunit->name;
        $this->unit_id = $subunit->unit_id;
        $this->hou_id = $subunit->hou_id;
    }

    public function updateSubUnit(){
        $validatedData = $this->validate();
        SubUnit::findOrFail($this->subunit_id)->update([
            'name' => $validatedData['name'],
            'unit_id' => $validatedData['unit_id'],
            'hou_id' => $validatedData['hou_id'],
        ]);
        session()->flash('message', 'Sub-Unit Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteSubUnit($subunit_id)
    {
        $this->subunit_id = $subunit_id;
        $subunit = SubUnit::findOrFail($subunit_id);
        $this->deleteName = $subunit->name;
    }

    public function destroySubUnit()
    {
        try {
            $subunit = SubUnit::FindOrFail($this->subunit_id);
            $subunit->delete();
            session()->flash('message', 'Sub-Unit deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete Sub-Unit because it is referenced in another module.');
            } else {
                session()->flash('error', 'An error occurred while deleting the Sub-Unit.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the Sub-Unit.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {

            $subunits = SubUnit::where(function ($query) {
                        $query->where('sub_units.name', 'like', '%'.$this->search.'%')
                            ->orWhere('units.name', 'like', '%'.$this->search.'%')
                            ->orWhere('profiles.lastname', 'like', '%'.$this->search.'%')
                            ->orWhere('profiles.firstname', 'like', '%'.$this->search.'%')
                            ->orWhere('profiles.othername', 'like', '%'.$this->search.'%');
                    })
                    ->join('units', 'sub_units.unit_id', '=', 'units.id')
                    ->leftJoin('profiles', 'sub_units.hou_id', '=', 'profiles.user_id')
                    ->select('sub_units.*', 'units.name as unit')
                    ->orderBy('sub_units.name', 'ASC')
                    ->paginate(10);

            $users = User::join('profiles', 'profiles.user_id', '=', 'users.id')
                    ->leftJoin('titles', 'profiles.title_id', '=', 'titles.id')
                    ->select('users.*', 'profiles.lastname as lastname', 'profiles.firstname as firstname', 'titles.name as title')
                    ->orderBy('profiles.lastname', 'ASC')
                    ->get();

            return view('livewire.admin.subunit.index', [
                'subunits' => $subunits,
                'users' => $users,
                'deleteName' => $this->deleteName,
                ])->extends('layouts.admin')->section('content');
    }
}
