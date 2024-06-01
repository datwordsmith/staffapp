<?php

namespace App\Livewire\Admin\Rank;

use App\Models\Ranks;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $rank_id, $category, $rank, $deleteName;

    public $search;

    public function mount()
    {
        $this->admin = Auth::user();
    }

    public function rules(){
        return [

            'category' => 'required|numeric|min:2',
            'rank' => 'required|string|unique:ranks,rank',

        ];
    }

    public function resetInput(){
        $this->category = null;
        $this->rank = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeRank(){
        $validatedData = $this->validate();
        Ranks::create([
            'category' => $validatedData['category'],
            'rank' => $validatedData['rank'],
        ]);
        session()->flash('message', 'Rank Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editRank(int $rank_id){
        $this->rank_id = $rank_id;
        $rank = Ranks::findOrFail($rank_id);
        $this->category = $rank->category;
        $this->rank = $rank->rank;
    }

    public function updateRank(){
        $validatedData = $this->validate();
        Ranks::findOrFail($this->rank_id)->update([
            'rank' => $validatedData['rank'],
        ]);
        session()->flash('message', 'Rank Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteRank($rank_id)
    {
        $this->rank_id = $rank_id;
        $rank = Ranks::findOrFail($rank_id);
        $this->deleteName = $rank->name;
    }

    public function destroyRank()
    {
        try {
            $rank = Ranks::FindOrFail($this->rank_id);
            $rank->delete();
            session()->flash('message', 'Rank deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete rank because it is referenced in another module.');
            } else {
                session()->flash('error', 'An error occurred while deleting the rank.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the rank.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {

        $ranks = Ranks::where('rank', 'like', '%'.$this->search.'%')
            ->orderBy('rank', 'ASC')
            ->paginate(5);

        return view('livewire.admin.rank.index', [
            'ranks' => $ranks,
            'deleteName' => $this->deleteName,
            ])->extends('layouts.admin')->section('content');
    }
}
