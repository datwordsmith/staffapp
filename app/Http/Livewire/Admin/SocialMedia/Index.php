<?php

namespace App\Http\Livewire\Admin\SocialMedia;

use App\Models\socialPlatform;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $platform_id, $name, $icon, $deleteName;

    public $search;

    public function mount()
    {
        $this->admin = Auth::user();
    }

    public function rules(){
        return [
            'name' => 'required|string|unique:social_platforms,name,' . $this->platform_id,
            'icon' => 'required|string|unique:social_platforms,icon,' . $this->platform_id,
        ];
    }

    public function resetInput(){
        $this->name = null;
        $this->icon = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storePlatform(){
        $validatedData = $this->validate();
        socialPlatform::create([
            'name' => $validatedData['name'],
            'icon' => $validatedData['icon'],
        ]);
        session()->flash('message', 'Social Media Platform Added Successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function editPlatform(int $platform_id){
        $this->platform_id = $platform_id;
        $platform = socialPlatform::findOrFail($platform_id);
        $this->name = $platform->name;
        $this->icon = $platform->icon;
    }

    public function updatePlatform(){
        $validatedData = $this->validate();
        socialPlatform::findOrFail($this->platform_id)->update([
            'name' => $validatedData['name'],
            'icon' => $validatedData['icon'],
        ]);
        session()->flash('message', 'Social Media Platform Updated Successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function deletePlatform($platform_id)
    {
        $this->platform_id = $platform_id;
        $platform = socialPlatform::findOrFail($platform_id);
        $this->deleteName = $platform->name;
    }

    public function destroyPlatform()
    {
        try {
            $platform = socialPlatform::FindOrFail($this->platform_id);
            $platform->delete();
            session()->flash('message', 'Social Media Platform deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete platform because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting the platform.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the platform.');
        }

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function render()
    {

        $platforms = socialPlatform::where('name', 'like', '%'.$this->search.'%')
            ->orderBy('name', 'ASC')
            ->paginate(5);

        return view('livewire.admin.social-media.index', [
            'platforms' => $platforms,
            'deleteName' => $this->deleteName,
            ])->extends('layouts.admin')->section('content');
    }
}
