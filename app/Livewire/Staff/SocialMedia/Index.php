<?php

namespace App\Livewire\Staff\SocialMedia;

use App\Models\socialMedia;
use App\Models\socialPlatform;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $socialPlatform_id, $socialmedia, $url;
    public $user, $staffId, $deleteName;
    public $search;

    public function mount()
    {
        // Fetch user details based on $userId
        $this->user = Auth::user();
        $this->socialMediaPlatforms = socialPlatform::all();

    }


    public function rules(){
        return [
            'socialPlatform_id' => 'required|int',
            'url' => 'url|required',
        ];
    }

    public function resetInput(){
        $this->socialPlatform_id = null;
        $this->url = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeSocialMedia(){
        $validatedData = $this->validate();
        $this->user->socialMedia()->create([
            'socialPlatform_id' => $validatedData['socialPlatform_id'],
            'url' => $validatedData['url'],
        ]);
        session()->flash('message', 'Social Media Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }


    public function deleteSocialMedia($socialMedia_id)
    {
        $this->socialMedia_id = $socialMedia_id;
    }

    public function destroySocialMedia()
    {
        try {
            $socialMedia = socialMedia::FindOrFail($this->socialMedia_id);
            $socialMedia->delete();
            session()->flash('message', 'Social Media deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete social media because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting the social media.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the social media.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $socialMedia = socialMedia::where('user_id', $this->user->id)
            ->join('social_platforms', 'social_media.socialPlatform_id', '=', 'social_platforms.id')
            ->select('social_media.*', 'social_platforms.name as platform', 'social_platforms.icon as icon')
            ->orderBy('social_platforms.name', 'asc')
            ->get();


        return view('livewire.staff.social-media.index', [
            'socialMedia' => $socialMedia,
            ])->extends('layouts.staff')->section('content');
    }
}
