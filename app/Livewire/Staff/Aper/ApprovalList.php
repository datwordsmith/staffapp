<?php

namespace App\Livewire\Staff\Aper;

use App\Models\APER;
use App\Models\AperEvaluation;
use App\Models\User;
use App\Models\SubUnit;
use Livewire\Component;
use App\Models\Department;
use Livewire\WithPagination;
use App\Models\AperAcceptance;
use App\Models\staffDepartment;
use App\Models\AppraisalCategory;
use Illuminate\Support\Facades\Auth;

class ApprovalList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $user_id, $staffId;
    public $department_id, $subunit_id;
    public $search;

    public function mount()
    {
        $this->admin = Auth::user();


        // Get department IDs where admin is the dean
        $this->departmentIds = Department::whereIn('faculty_id', function($query) {
            $query->select('id')
                ->from('faculties')
                ->where('dean_id', $this->admin->id);
        })->pluck('id');

        // Get subunit IDs where admin is the head
        $this->subunitIds = SubUnit::whereIn('unit_id', function($query) {
            $query->select('id')
                ->from('units')
                ->where('head_id', $this->admin->id);
        })->pluck('id');



        $this->categories = AppraisalCategory::orderBy('category')->get();
    }


    public function rules()
    {

    }

    public function viewAper($aperId)
    {
        $aper = APER::findOrFail($aperId);
        return redirect()->route('profile', ['staffId' => $aper->user->staffId]);
    }

    public function render()
    {

        $apers = APER::join('users', 'aper.user_id', '=', 'users.id')
            ->leftJoin('staff_departments', function($join) {
                $join->on('staff_departments.user_id', '=', 'users.id')
                    ->whereIn('staff_departments.department_id', $this->departmentIds);
            })
            ->leftJoin('staff_sub_units', function($join) {
                $join->on('staff_sub_units.user_id', '=', 'users.id')
                    ->whereIn('staff_sub_units.subunit_id', $this->subunitIds);
            })
            ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
            ->leftJoin('titles', 'profiles.title_id', '=', 'titles.id')
            ->where('aper.user_id', '<>', $this->admin->id)
            ->where(function($query) {
                $query->whereNotNull('staff_departments.department_id')
                    ->orWhereNotNull('staff_sub_units.subunit_id');
            })
            ->select('aper.*', 'profiles.lastname as lastname', 'profiles.firstname as firstname', 'users.staffId as staffId', 'titles.name as title')
            ->orderBy('aper.created_at', 'ASC')
            ->get();


        return view('livewire.staff.aper.approvallist', [
            'apers' => $apers,
            ])->extends('layouts.staff')->section('content');
    }
}
