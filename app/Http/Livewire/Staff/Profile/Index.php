<?php

namespace App\Http\Livewire\Staff\Profile;

use App\Models\Profile;
use App\Models\Title;
use Livewire\Component;
use App\Models\Interests;
use App\Models\socialMedia;
use Illuminate\Support\Str;
use App\Models\Publications;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $profile, $biography, $photo;
    public $maxBioCharacters = 1000;
    public $user, $staffId;
    public $title_id, $lastname, $firstname, $othername, $designation;
    public $search;

    public function mount()
    {
        // Fetch user details based on $userId
        $this->user = Auth::user();

    }

    public function rules(){
        return [
            'title_id' => 'required|numeric|min:1|exists:titles,id',
            'lastname' => 'required|string',
            'firstname' => 'required|string',
            'othername' => 'required|string',
            'designation' => 'required|string',
            'biography' => 'required|string|max:1000',
        ];
    }

    public function resetInput(){
        $this->biography = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function updatedBiography()
    {
        // Limit the number of characters
        $this->biography = substr($this->biography, 0, $this->maxBioCharacters);
    }

    public function resetLoading()
    {
        $this->resetErrorBag('biography'); // Reset the error bag for the 'biography' field
        $this->resetValidation(); // Reset the validation state
        dd('here');
    }


    public function editBio(int $profile_id){
        $this->profile_id = $profile_id;
        $profile = Profile::findOrFail($profile_id);
        $this->title_id = $profile->title_id;
        $this->firstname = $profile->firstname;
        $this->lastname = $profile->lastname;
        $this->othername = $profile->othername;
        $this->designation = $profile->designation;
        $this->biography = $profile->biography;
    }

    public function updateBio(){
        $validatedData = $this->validate();
        Profile::findOrFail($this->profile_id)->update([
            'title_id' => $validatedData['title_id'],
            'lastname' => $validatedData['lastname'],
            'firstname' => $validatedData['firstname'],
            'othername' => $validatedData['othername'],
            'designation' => $validatedData['designation'],
            'biography' => $validatedData['biography'],
        ]);
        session()->flash('message', 'Profile Updated Successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function deleteBio(int $profile_id)
    {
        $this->profile_id = $profile_id;
        $profile = Profile::findOrFail($profile_id);
        $this->biography = $profile->biography;
    }

    public function destroyBio()
    {
        Profile::findOrFail($this->profile_id)->update([
            'biography' => null,
        ]);
        session()->flash('message', 'Biography deleted Successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function uploadPhoto()
    {
        $this->validate([
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120'
        ]);

        // Get the user's staffId
        $staffId = auth()->user()->staffId;

        // Generate a unique filename with the staffId and original file extension
        $filename = $staffId . '_' . Str::random(10) . '.' . $this->photo->getClientOriginalExtension();

        // Delete existing photo
        $existingPhoto = auth()->user()->profile->photo;
            if ($existingPhoto && Storage::disk('public')->exists('assets/photos/' . $existingPhoto)) {
                Storage::disk('public')->delete('assets/photos/' . $existingPhoto);
        }

        // Store the uploaded file with the new filename
        $this->photo->storeAs('assets/photos', $filename, 'public');

        // Update the user's photo path in the database
        $user = auth()->user();
        $user->profile->update([
            'photo' => $filename,
        ]);

        // Clear the file input
        $this->photo = null;

        // Close the modal
        $this->dispatchBrowserEvent('close-modal');

        // Show a success message or perform additional actions
        session()->flash('message', 'Photo uploaded successfully.');
    }


    public function deletePhoto(int $profile_id)
    {
        $this->profile_id = $profile_id;
        $profile = Profile::findOrFail($profile_id);
        $this->photo = $profile->photo;
    }

    public function destroyPhoto()
    {
        // Delete existing photo
        $existingPhoto = auth()->user()->profile->photo;
        if ($existingPhoto && Storage::disk('public')->exists('assets/photos/' . $existingPhoto)) {
            Storage::disk('public')->delete('assets/photos/' . $existingPhoto);
        }

        Profile::findOrFail($this->profile_id)->update([
            'photo' => null,
        ]);
        session()->flash('message', 'Photo deleted Successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $staff = Profile::where('user_id', $this->user->id)
                    ->first();

        $publications = Publications::where('user_id', $this->user->id)
            ->where(function ($query) {
                $query->where('publication', 'like', '%' . $this->search . '%')
                    ->orWhere('url', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $socials = socialMedia::where('user_id', $this->user->id)
                    ->leftjoin('social_platforms', 'social_media.socialPlatform_id', '=', 'social_platforms.id')
                    ->select('social_media.*', 'social_platforms.name as sm', 'social_platforms.icon as icon')
                    ->orderBy('social_platforms.name', 'ASC')
                    ->get();

        $interests = Interests::where('user_id', $this->user->id)
                    ->orderBy('interest', 'asc')
                    ->get();

        $titles = Title::all();


        return view('livewire.staff.profile.index', [
            'publications' => $publications,
            'socials' => $socials,
            'interests' => $interests,
            'staff' => $staff,
            'titles' => $titles,
            ])->extends('layouts.staff')->section('content');
    }

}
