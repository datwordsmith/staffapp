<?php

namespace App\Livewire\Admin\User;

use App\Models\Unit;
use App\Models\User;
use App\Models\Faculty;
use App\Models\SubUnit;
use Livewire\Component;
use App\Models\staffUnit;
use App\Models\Department;
use App\Models\staffSubUnit;
use Livewire\WithPagination;
use App\Models\staffDepartment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class NonAcademicStaff extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $user_id, $staffId, $email, $role_as;
    public $banStaffId, $deleteStaffId;
    public $unit_id, $subunits, $subunit_id;
    public $search;

    public function rules()
    {
        return [
            'staffId' => 'required|string|unique:users,staffId',
            'email' => 'required|string|unique:users,email',
            'subunit_id' => 'required|numeric|min:1|exists:sub_units,id',
        ];
    }

    public function mount()
    {
        $this->admin = Auth::user();
        $this->subunits = [];
    }

    public function resetInput() {
        $this->staffId = NULL;
        $this->email = null;
        $this->subunit_id = null;
        $this->unit_id = null;
    }

    public function closeModal() {
        $this->resetInput();
    }

    public function openModal() {
        $this->resetInput();
    }

    public function updated($unit_id)
    {
        $this->subunits = SubUnit::where('unit_id', $this->unit_id)->orderBy('name')->get();
    }

    public function storeNonAcademicStaff()
    {
        $validatedData = $this->validate();

        //$userPassword = preg_replace("/[^a-zA-Z0-9]/", '', Str::random(8));
        $password = '12345678';
        $role_as = 3;

        $user = User::create([
            'staffId' => $validatedData['staffId'],
            'email' => $validatedData['email'],
            'password' => Hash::make($password),
            'role_as' => $role_as,
        ]);

        staffSubUnit::create([
            'user_id' => $user->id,
            'subunit_id' => $validatedData['subunit_id'],
        ]);

        //$user->notify(new NewUserAlert($userPassword));

        session()->flash('message', 'User Added Successfully');
        $this->dispatch('close-modal');
        $this->resetInput();
    }


    public function banNonAcademicStaff($user_id)
    {
        $this->user_id = $user_id;
        $user = User::findOrFail($user_id);
        $this->banStaffId = $user->staffId;
    }

    public function deactivateNonAcademicStaff(){
        User::findOrFail($this->user_id)->update([
            'isActive' => 0,
        ]);
        session()->flash('message', 'User deactivated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function activateNonAcademicStaff($user_id){

        $this->user_id = $user_id;
        User::findOrFail($this->user_id)->update([
            'isActive' => 1,
        ]);
        session()->flash('message', 'User activated Successfully.');
        $this->resetInput();
    }

    public function deleteNonAcademicStaff($user_id)
    {
        $this->user_id = $user_id;
        $user = User::findOrFail($user_id);
        $this->deleteStaffId = $user->staffId;
    }

    public function destroyNonAcademicStaff()
    {
        try {
            $user = User::FindOrFail($this->user_id);
            // Check if the user has a profile
            if ($user->profile()->exists()) {
                session()->flash('error', 'Cannot delete because the user has a profile.');
                return;
            }

            // If the user doesn't have a profile, proceed with deletion
            $user->load('subunit'); // Load the subunit relationship

            // Delete the subunit record if it exists
            if ($user->subunit) {
                $user->subunit->delete();
            }

            // Delete the user
            $user->delete();

            session()->flash('message', 'Non-Academic Staff deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete because Non-Academic Staff is referenced in another module.');
            } else {
                session()->flash('error', 'An error occurred while deleting Non-Academic Staff.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting Non-Academic Staff.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }


    public function hasProfile($userId)
    {
        $user = User::findOrFail($userId);
        return $user->profile()->exists();
    }


    public function render()
    {
        $users = User::where(function ($query) {
            $query->where('users.staffId', 'like', '%'.$this->search.'%')
                ->orWhere('users.email', 'like', '%'.$this->search.'%')
                ->orWhere('profiles.lastname', 'like', '%'.$this->search.'%')
                ->orWhere('profiles.firstname', 'like', '%'.$this->search.'%');
        })
        ->where('users.role_as', 3)
        ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
        ->leftJoin('titles', 'profiles.title_id', '=', 'titles.id')
        ->select('users.*', 'profiles.lastname as lastname', 'profiles.firstname as firstname', 'profiles.slug as slug', 'titles.name as title')
        ->orderBy('profiles.lastname', 'ASC')
        ->paginate(5);

        $this->units = Unit::orderBy('name')->get();

        return view('livewire.admin.user.non-academic-staff', [
            'users' => $users,
            'deleteStaffId' => $this->deleteStaffId,
            'units'=>$this->units,
            ])->extends('layouts.admin')->section('content');
    }
}
