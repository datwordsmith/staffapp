<?php

namespace App\Http\Livewire\Staff\TeachingExperience;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TeachingExperience;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $course_code, $course_title, $credit_unit, $lectures, $semester, $year;
    public $user, $staffId, $deleteName;
    public $search;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function rules(){
        return [
            'course_code' => 'required|string',
            'course_title' => 'required|string',
            'credit_unit' => 'required|int|min:1',
            'lectures' => 'required|int|min:1',
            'semester' => 'required|string',
            'year' => 'required|date_format:Y',
        ];
    }

    public function resetInput(){
        $this->course_code = null;
        $this->course_title = null;
        $this->credit_unit = null;
        $this->lectures = null;
        $this->semester = null;
        $this->year = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeExperience(){
        $validatedData = $this->validate();
        $this->user->teachingExperiences()->create([
            'course_code' => $validatedData['course_code'],
            'course_title' => $validatedData['course_title'],
            'credit_unit' => $validatedData['credit_unit'],
            'lectures' => $validatedData['lectures'],
            'semester' => $validatedData['semester'],
            'year' => $validatedData['year'],
        ]);
        session()->flash('message', 'Experience Added Successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function editExperience(int $experience_id){
        $this->experience_id = $experience_id;
        $experience = TeachingExperience::findOrFail($experience_id);
        $this->course_code = $experience->course_code;
        $this->course_title = $experience->course_title;
        $this->credit_unit = $experience->credit_unit;
        $this->lectures = $experience->lectures;
        $this->semester = $experience->semester;
        $this->year = $experience->year;
    }

    public function updateExperience(){
        $validatedData = $this->validate();
        TeachingExperience::findOrFail($this->experience_id)->update([
            'course_code' => $validatedData['course_code'],
            'course_title' => $validatedData['course_title'],
            'credit_unit' => $validatedData['credit_unit'],
            'lectures' => $validatedData['lectures'],
            'semester' => $validatedData['semester'],
            'year' => $validatedData['year'],
        ]);
        session()->flash('message', 'Experience Updated Successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function deleteExperience($experience_id)
    {
        $this->experience_id = $experience_id;
        $experience = TeachingExperience::findOrFail($experience_id);
    }

    public function destroyExperience()
    {
        try {
            $experience = TeachingExperience::FindOrFail($this->experience_id);
            $experience->delete();
            session()->flash('message', 'Experience deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete experience because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting the experience.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the experience.');
        }

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $experiences = TeachingExperience::where('user_id', $this->user->id)
            ->where(function ($query) {
                $query->where('course_title', 'like', '%' . $this->search . '%')
                    ->orWhere('course_code', 'like', '%' . $this->search . '%')
                    ->orWhere('semester', 'like', '%' . $this->search . '%')
                    ->orWhere('year', 'like', '%' . $this->search . '%');
            })
            ->orderBy('year')
            ->paginate(5);

        return view('livewire.staff.teaching-experience.index', [
            'experiences' => $experiences,
            ])->extends('layouts.staff')->section('content');
    }
}
