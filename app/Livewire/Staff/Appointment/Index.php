<?php

namespace App\Livewire\Staff\Appointment;

use App\Models\Ranks;
use Livewire\Component;
use App\Models\Appointment;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $rank_id, $grade_step, $appointment_date, $confirmation_date, $last_promotion;
    public $user, $staffId, $deleteName;
    public $appointment_id;
    public $search;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function rules(){
        return [
            'rank_id' => 'required|numeric',
            'grade_step' => 'required|string',
            'appointment_date' => 'required|date|before_or_equal:today',
            'confirmation_date' => 'required|date|before_or_equal:today',
            'last_promotion' => 'required|date|before_or_equal:today',
        ];
    }

    public function resetInput(){
        $this->rank_id = null;
        $this->grade_step = null;
        $this->appointment_date = null;
        $this->confirmation_date = null;
        $this->last_promotion = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeAppointment(){
        $validatedData = $this->validate();
        $this->user->Appointment()->create([
            'rank_id' => $validatedData['rank_id'],
            'grade_step' => $validatedData['grade_step'],
            'appointment_date' => $validatedData['appointment_date'],
            'confirmation_date' => $validatedData['confirmation_date'],
            'last_promotion' => $validatedData['last_promotion'],
        ]);
        session()->flash('message', 'Appointment Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editAppointment(int $appointment_id){
        $this->appointment_id = $appointment_id;
        $appointment = Appointment::findOrFail($appointment_id);
        $this->rank_id = $appointment->rank_id;
        $this->grade_step = $appointment->grade_step;
        $this->appointment_date = $appointment->appointment_date;
        $this->confirmation_date = $appointment->confirmation_date;
        $this->last_promotion = $appointment->last_promotion;
    }

    public function updateAppointment(){
        $validatedData = $this->validate();
        Appointment::findOrFail($this->appointment_id)->update([
            'rank_id' => $validatedData['rank_id'],
            'grade_step' => $validatedData['grade_step'],
            'appointment_date' => $validatedData['appointment_date'],
            'confirmation_date' => $validatedData['confirmation_date'],
            'last_promotion' => $validatedData['last_promotion'],
        ]);
        session()->flash('message', 'Appointment Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteAppointment($appointment_id)
    {
        $this->appointment_id = $appointment_id;
        $appointment = Appointment::findOrFail($appointment_id);
    }

    public function destroyAppointment()
    {
        try {
            $appointment = Appointment::FindOrFail($this->appointment_id);
            $appointment->delete();
            session()->flash('message', 'Appointment deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete appointment because it is referenced in user profile.');
            } else {
                session()->flash('error', 'An error occurred while deleting the appointment.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the appointment.');
        }

        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function render()
    {
        $appointments = Appointment::where('user_id', $this->user->id)->get();

        $ranks = Ranks::where('category', $this->user->role_as)->get();

        return view('livewire.staff.appointment.index', [
            'appointments' => $appointments,
            'ranks' => $ranks,
            ])->extends('layouts.staff')->section('content');
    }
}
