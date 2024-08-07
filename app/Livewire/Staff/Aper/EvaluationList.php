<?php

namespace App\Livewire\Staff\Aper;

use Carbon\Carbon;
use App\Models\APER;
use App\Models\User;
use App\Models\SubUnit;
use Livewire\Component;
use App\Models\Department;
use Livewire\WithPagination;
use App\Models\AperAcceptance;
use App\Models\staffDepartment;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AppraisalCategory;
use Illuminate\Support\Facades\Auth;


class EvaluationList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $user_id, $staffId;
    public $department_id, $subunit_id;
    public $departmentIds = [];
    public $subunitIds = [];
    public $admin;
    public $currentYear;
    public $search;

    public function mount()
    {
        $this->admin = Auth::user();
        $this->departmentIds = Department::where('hod_id', $this->admin->id)->pluck('id');
        $this->subunitIds = SubUnit::where('hou_id', $this->admin->id)->pluck('id');

        $this->categories = AppraisalCategory::orderBy('category')->get();
        $this->currentYear = Carbon::now()->year;
    }


    public function rules()
    {

    }

    public function viewAper($aperId)
    {
        $aper = APER::findOrFail($aperId);
        return redirect()->route('profile', ['staffId' => $aper->user->staffId]);
    }

    public function getStaffDetails() {
        return User::join('aper', 'users.id', '=', 'aper.user_id')
            ->leftJoin('staff_departments', function($join) {
                $join->on('staff_departments.user_id', '=', 'users.id')
                    ->whereIn('staff_departments.department_id', $this->departmentIds);
            })
            ->leftJoin('staff_sub_units', function($join) {
                $join->on('staff_sub_units.user_id', '=', 'users.id')
                    ->whereIn('staff_sub_units.subunit_id', $this->subunitIds);
            })
            //->where('aper.user_id', '<>', $this->admin->id)
            ->where(function($query) {
                $query->whereNotNull('staff_departments.department_id')
                    ->orWhereNotNull('staff_sub_units.subunit_id');
            })
            ->select('users.*') // Adjust the columns as needed
            ->get();
    }


    public function getPdf() {

        // Fetch staff details
        $staffdetails = $this->getStaffDetails();

        // Prepare data for PDF
        $data = [
            'staffdetails' => $staffdetails,
        ];

        // Log the data for debugging purposes (optional)
        \Log::info(json_encode($data));

        try {
            $pdf = Pdf::loadView('aper-report', $data)->setPaper('a4', 'landscape');
            return response()->streamDownload(function() use ($pdf) {
                echo $pdf->stream();
            }, 'aper_report.pdf');
        } catch (\Exception $e) {
            // Log the error message
            \Log::error($e->getMessage());
            return response()->json(['error' => 'An error occurred while generating the PDF.'], 500);
        }
    }

    public function render()
    {

        $apers = APER::join('users', 'aper.user_id', '=', 'users.id')
            ->whereYear('aper.created_at', $this->currentYear)
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
            ->orderBy('aper.created_at', 'DESC')
            ->get();

        $staffdetails = $this->getStaffDetails();

        return view('livewire.staff.aper.evaluationlist', [
            'apers' => $apers,
            'staffdetails' => $staffdetails,
            ])->extends('layouts.staff')->section('content');
    }
}
