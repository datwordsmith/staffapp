<?php

namespace App\Http\Livewire\Staff\CommunityServices;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CommunityService;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $duty, $experience, $commending_officer, $date;
    public $user, $staffId, $deleteName;
    public $search;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function rules(){
        return [
            'duty' => 'required|string',
            'experience' => 'required|string',
            'commending_officer' => 'nullable|string',
            'date' => 'required|date_format:Y',
        ];
    }

    public function resetInput(){
        $this->duty = null;
        $this->experience = null;
        $this->commending_officer = null;
        $this->date = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeService(){
        $validatedData = $this->validate();
        $this->user->communityServices()->create([
            'duty' => $validatedData['duty'],
            'experience' => $validatedData['experience'],
            'commending_officer' => $validatedData['commending_officer'],
            'date' => $validatedData['date'],
        ]);
        session()->flash('message', 'Item Added Successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function editService(int $service_id){
        $this->service_id = $service_id;
        $service = CommunityService::findOrFail($service_id);
        $this->duty = $service->duty;
        $this->experience = $service->experience;
        $this->commending_officer = $service->commending_officer;
        $this->date = $service->date;
    }

    public function updateService(){
        $validatedData = $this->validate();
        CommunityService::findOrFail($this->service_id)->update([
            'duty' => $validatedData['duty'],
            'experience' => $validatedData['experience'],
            'commending_officer' => $validatedData['commending_officer'],
            'date' => $validatedData['date'],
        ]);
        session()->flash('message', 'Item Updated Successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function deleteService($service_id)
    {
        $this->service_id = $service_id;
        $service = CommunityService::findOrFail($service_id);
    }

    public function destroyService()
    {
        try {
            $service = CommunityService::FindOrFail($this->service_id);
            $service->delete();
            session()->flash('message', 'Item deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete item because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting the item.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the item.');
        }

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $services = CommunityService::where('user_id', $this->user->id)
            ->where(function ($query) {
                $query->where('duty', 'like', '%' . $this->search . '%')
                    ->orWhere('experience', 'like', '%' . $this->search . '%')
                    ->orWhere('commending_officer', 'like', '%' . $this->search . '%')
                    ->orWhere('date', 'like', '%' . $this->search . '%');
            })
            ->orderBy('date', 'desc')
            ->paginate(5);

        return view('livewire.staff.community-services.index', [
            'services' => $services,
            ])->extends('layouts.staff')->section('content');
    }
}
