<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AcademicStaff extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $user_id, $staffId, $email, $role_as;
    public $banStaffId, $deleteStaffId;
    public $search;

    public function rules()
    {
        return [
            'staffId' => 'required|string|unique:users,staffId',
            'email' => 'required|string|unique:users,email',
        ];
    }

    public function mount()
    {
        $this->admin = Auth::user();
    }

    public function resetInput() {
        $this->staffId = NULL;
        $this->email = null;
    }

    public function closeModal() {
        $this->resetInput();
    }

    public function openModal() {
        $this->resetInput();
    }


    public function storeAcademicStaff()
    {
        $validatedData = $this->validate();

        //$userPassword = preg_replace("/[^a-zA-Z0-9]/", '', Str::random(8));
        $password = '12345678';
        $role_as = 2;

        $user = new User([
            'staffId' => $validatedData['staffId'],
            'email' => $validatedData['email'],
            'password' => Hash::make($password),
            'role_as' => $role_as,
        ]);
        $user->save();

        //$user->notify(new NewUserAlert($userPassword));

        session()->flash('message', 'User Added Successfully');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }


    public function banAcademicStaff($user_id)
    {
        $this->user_id = $user_id;
        $user = User::findOrFail($user_id);
        $this->banStaffId = $user->staffId;
    }

    public function deactivateAcademicStaff(){
        User::findOrFail($this->user_id)->update([
            'isActive' => 0,
        ]);
        session()->flash('message', 'User deactivated Successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function activateAcademicStaff($user_id){

        $this->user_id = $user_id;
        User::findOrFail($this->user_id)->update([
            'isActive' => 1,
        ]);
        session()->flash('message', 'User activated Successfully.');
        $this->resetInput();
    }

    public function deleteAcademicStaff($user_id)
    {
        $this->user_id = $user_id;
        $user = User::findOrFail($user_id);
        $this->deleteStaffId = $user->staffId;
    }

    public function destroyAcademicStaff()
    {
        try {
            $user = User::FindOrFail($this->user_id);
            $user->delete();
            session()->flash('message', 'Academic Staff deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete because Academic Staff is referenced in another module.');
            } else {
                session()->flash('error', 'An error occurred while deleting Academic Staff.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting Academic Staff.');
        }

        $this->dispatchBrowserEvent('close-modal');
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
        ->where('users.role_as', 2)
        ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
        ->leftJoin('titles', 'profiles.title_id', '=', 'titles.id')
        ->select('users.*', 'profiles.lastname as lastname', 'profiles.firstname as firstname', 'profiles.slug as slug', 'titles.name as title')
        ->orderBy('profiles.lastname', 'ASC')
        ->paginate(5);

        return view('livewire.admin.user.academic-staff', [
            'users' => $users,
            'deleteStaffId' => $this->deleteStaffId,
            ])->extends('layouts.admin')->section('content');
    }
}
