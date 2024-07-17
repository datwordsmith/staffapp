<?php

namespace App\Livewire\Staff\CurrentAppointment;

use App\Models\Ranks;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CurrentAppointment;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $rank_id, $grade_step, $current_appointment, $confirmation;
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
            'current_appointment' => 'required|date|before_or_equal:today',
            'confirmation' => 'required|date|before_or_equal:today',
        ];
    }

    public function resetInput(){
        $this->rank_id = null;
        $this->grade_step = null;
        $this->current_appointment = null;
        $this->confirmation = null;
    }

    public function closeModal() {
        $this->resetInput();
    }
    public function openModal() {
        $this->resetInput();
    }

    public function storeAppointment(){
        $validatedData = $this->validate();
        $this->user->currentAppointment()->create([
            'rank_id' => $validatedData['rank_id'],
            'grade_step' => $validatedData['grade_step'],
            'current_appointment' => $validatedData['current_appointment'],
            'confirmation' => $validatedData['confirmation'],
        ]);
        session()->flash('message', 'Current Appointment Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editAppointment(int $appointment_id){
        $this->appointment_id = $appointment_id;
        $appointment = CurrentAppointment::findOrFail($appointment_id);
        $this->rank_id = $appointment->rank_id;
        $this->grade_step = $appointment->grade_step;
        $this->current_appointment = $appointment->current_appointment;
        $this->confirmation = $appointment->confirmation;
    }

    public function updateAppointment(){
        $validatedData = $this->validate();
        CurrentAppointment::findOrFail($this->appointment_id)->update([
            'rank_id' => $validatedData['rank_id'],
            'grade_step' => $validatedData['grade_step'],
            'current_appointment' => $validatedData['current_appointment'],
            'confirmation' => $validatedData['confirmation'],
        ]);
        session()->flash('message', 'Appointment Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteAppointment($appointment_id)
    {
        $this->appointment_id = $appointment_id;
        $appointment = CurrentAppointment::findOrFail($appointment_id);
    }

    public function destroyAppointment()
    {
        try {
            $appointment = CurrentAppointment::FindOrFail($this->appointment_id);
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
        $appointment = CurrentAppointment::where('user_id', $this->user->id)->first();

        $ranks = Ranks::where('category', $this->user->role_as)->get();

        return view('livewire.staff.current-appointment.index', [
            'appointment' => $appointment,
            'ranks' => $ranks,
            ])->extends('layouts.staff')->section('content');
    }
}
