<?php

namespace App\Livewire\Staff\Profile;

use App\Models\Ranks;
use App\Models\Title;
use App\Models\Awards;
use App\Models\Honours;
use App\Models\Profile;
use Livewire\Component;
use App\Models\Interests;
use App\Models\Conference;
use App\Models\Membership;
use App\Models\Appointment;
use App\Models\socialMedia;
use Illuminate\Support\Str;
use App\Models\CreativeWork;
use App\Models\JournalPaper;
use App\Models\Publications;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\OngoingResearch;
use App\Models\CommunityService;
use App\Models\FirstAppointment;
use App\Models\StaffPublication;
use App\Models\CompletedResearch;
use App\Models\CurrentAppointment;
use App\Models\TeachingExperience;
use Livewire\WithoutUrlPagination;
use App\Models\InitialQualification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\AdditionalQualification;
use Illuminate\Support\Facades\Storage;
use App\Models\UniversityAdministration;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $profile_id, $profile, $biography, $photo;
    public $maxBioCharacters = 1000;
    public $user, $staffId;
    public $title_id, $lastname, $firstname, $othername, $dob, $sex, $rank_id;
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
            'othername' => 'nullable|string',
            'dob' => 'required|date|before_or_equal:today',
            'sex' => 'required|string',
            'rank_id' => 'required|numeric',
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
    }

    public function newProfile(int $my_id)
    {
        $validatedData = $this->validate();
        if ($this->user->id = $my_id) {
            $staffId = auth()->user()->staffId;
            Profile::create([
                'user_id' => $my_id,
                'title_id' => $validatedData['title_id'],
                'lastname' => $validatedData['lastname'],
                'firstname' => $validatedData['firstname'],
                'othername' => $validatedData['othername'],
                'dob' => $validatedData['dob'],
                'sex' => $validatedData['sex'],
                'rank_id' => $validatedData['rank_id'],
                'biography' => $validatedData['biography'],
                'slug' => $staffId,
            ]);

            session()->flash('message', 'Profile Updated Successfully.');
        } else {
            session()->flash('error', 'Failed to update profile.');
        }
        $this->dispatch('close-modal');
        $this->resetInput();
    }


    public function editBio(int $profile_id){
        $this->profile_id = $profile_id;
        $profile = Profile::findOrFail($profile_id);
        $this->title_id = $profile->title_id;
        $this->firstname = $profile->firstname;
        $this->lastname = $profile->lastname;
        $this->othername = $profile->othername;
        $this->dob = $profile->dob;
        $this->sex = $profile->sex;
        $this->rank_id = $profile->rank_id;
        $this->biography = $profile->biography;
    }

    public function updateBio(){
        $validatedData = $this->validate();
        Profile::findOrFail($this->profile_id)->update([
            'title_id' => $validatedData['title_id'],
            'lastname' => $validatedData['lastname'],
            'firstname' => $validatedData['firstname'],
            'othername' => $validatedData['othername'],
            'dob' => $validatedData['dob'],
            'sex' => $validatedData['sex'],
            'rank_id' => $validatedData['rank_id'],
            'biography' => $validatedData['biography'],
        ]);
        session()->flash('message', 'Profile Updated Successfully.');
        $this->dispatch('close-modal');
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
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function uploadPhoto()
    {
        $this->validate([
            'photo' => 'image|max:5120'
        ]);

        // Get the user's staffId
        $staffId = auth()->user()->staffId;

        // Generate a unique filename with the staffId and original file extension
        $filename = $staffId . '_' . Str::random(10) . '.' . $this->photo->getClientOriginalExtension();

        // Delete existing photo
        $existingPhoto = auth()->user()->profile->photo;
        if ($existingPhoto && file_exists('uploads/photos/' . $existingPhoto)) {
            unlink('uploads/photos/' . $existingPhoto);
        }

        // Store the uploaded file with the new filename
        File::move($this->photo->getRealPath(), public_path('uploads/photos/' . $filename));

        // Update the user's photo path in the database
        $user = auth()->user();
        $user->profile->update([
            'photo' => $filename,
        ]);

        // Clear the file input
        $this->photo = null;

        // Close the modal
        $this->dispatch('close-modal');

        // Show a success message or perform additional actions
        session()->flash('message', 'Photo uploaded successfully.');
    }



    public function deletePhoto(int $profile_id)
    {
        $this->profile_id = $profile_id;
    }

    public function destroyPhoto()
    {

        $profile = Profile::findOrFail($this->profile_id);
        $photo = $profile->photo;
        // Delete existing photo
        $existingPhoto = $photo;
        if ($existingPhoto && file_exists('uploads/photos/' . $existingPhoto)) {
            unlink('uploads/photos/' . $existingPhoto);

            Profile::findOrFail($this->profile_id)->update([
                'photo' => null,
            ]);
            session()->flash('message', 'Photo deleted Successfully.');
            $this->dispatch('close-modal');
            $this->resetInput();
        } else {
            session()->flash('message', 'Failed.');
        }
    }

    public function render()
    {
        $staff = Profile::where('user_id', $this->user->id)
                    ->first();


        $socials = socialMedia::where('user_id', $this->user->id)
                    ->leftjoin('social_platforms', 'social_media.socialPlatform_id', '=', 'social_platforms.id')
                    ->select('social_media.*', 'social_platforms.name as sm', 'social_platforms.icon as icon')
                    ->orderBy('social_platforms.name', 'ASC')
                    ->get();

        $interests = Interests::where('user_id', $this->user->id)
                    ->orderBy('interest', 'asc')
                    ->get();

        $titles = Title::all();

        $ranks = Ranks::where('category', $this->user->role_as)->get();

        $firstAppointment = FirstAppointment::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $currentAppointment = CurrentAppointment::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $AppointmentHistory = Appointment::where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $experiences = TeachingExperience::where('user_id', $this->user->id)
            ->orderBy('year')
            ->get();

        $awards = Awards::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->get();

        $honours = Honours::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->get();

        $memberships = Membership::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->orderBy('society', 'asc')
            ->get();

        $conferences = Conference::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->orderBy('conference', 'asc')
            ->orderBy('location', 'asc')
            ->get();

        $Iqualifications = InitialQualification::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->orderBy('institution', 'asc')
            ->get();

        $qualifications = AdditionalQualification::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->orderBy('institution', 'asc')
            ->get();

        $researches = CompletedResearch::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->get();


        $ongoingResearches = OngoingResearch::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->get();

        $monographs = StaffPublication::where('user_id', $this->user->id)
            ->where('category_id', 1)
            ->orderBy('year', 'desc')
            ->get();

        $articles = StaffPublication::where('user_id', $this->user->id)
            ->where('category_id', 2)
            ->orderBy('year', 'desc')
            ->get();

        $conferenceProceedings = StaffPublication::where('user_id', $this->user->id)
            ->where('category_id', 3)
            ->orderBy('year', 'desc')
            ->get();

        $creativeWorks = CreativeWork::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->orderBy('title', 'asc')
            ->orderBy('author', 'asc')
            ->orderBy('category', 'asc')
            ->get();

        $acceptedPapers = JournalPaper::where('user_id', $this->user->id)
            ->where('isSubmitted', 0)
            ->orderBy('year', 'desc')
            ->get();

        $submittedPapers = JournalPaper::where('user_id', $this->user->id)
            ->where('isSubmitted', 1)
            ->orderBy('year', 'desc')
            ->get();

        $administrations = UniversityAdministration::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->get();

        $services = CommunityService::where('user_id', $this->user->id)
            ->orderBy('date', 'desc')
            ->get();

        return view('livewire.staff.profile.index', [
            'socials' => $socials,
            'interests' => $interests,
            'staff' => $staff,
            'titles' => $titles,
            'ranks' => $ranks,
            'firstAppointment' => $firstAppointment,
            'currentAppointment' => $currentAppointment,
            'AppointmentHistory' => $AppointmentHistory,
            'experiences' => $experiences,
            'awards' => $awards,
            'honours' => $honours,
            'memberships' => $memberships,
            'conferences' => $conferences,
            'Iqualifications' => $Iqualifications,
            'Aqualifications' => $qualifications,
            'researches' => $researches,
            'ongoingResearches' => $ongoingResearches,
            'monographs' => $monographs,
            'articles' => $articles,
            'conferenceProceedings' => $conferenceProceedings,
            'creativeWorks' => $creativeWorks,
            'acceptedPapers' => $acceptedPapers,
            'submittedPapers' => $submittedPapers,
            'administrations' => $administrations,
            'services' => $services,
            ])->extends('layouts.staff')->section('content');
    }

}
