<?php

namespace App\Livewire\Staff\FirstAppointment;

use App\Models\FirstAppointment;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $post, $grade_step, $first_appointment, $confirmation;
    public $user, $staffId, $deleteName;
    public $appointment_id;
    public $search;

    public function mount()
    {
        $this->user = Auth::user();
    }

    public function rules(){
        return [
            'post' => 'required|string',
            'grade_step' => 'required|string',
            'first_appointment' => 'required|date|before_or_equal:today',
            'confirmation' => 'required|date|before_or_equal:today',
        ];
    }

    public function resetInput(){
        $this->post = null;
        $this->grade_step = null;
        $this->first_appointment = null;
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
        $this->user->firstAppointment()->create([
            'post' => $validatedData['post'],
            'grade_step' => $validatedData['grade_step'],
            'first_appointment' => $validatedData['first_appointment'],
            'confirmation' => $validatedData['confirmation'],
        ]);
        session()->flash('message', 'First Appointment Added Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function editAppointment(int $appointment_id){
        $this->appointment_id = $appointment_id;
        $appointment = FirstAppointment::findOrFail($appointment_id);
        $this->post = $appointment->post;
        $this->grade_step = $appointment->grade_step;
        $this->first_appointment = $appointment->first_appointment;
        $this->confirmation = $appointment->confirmation;
    }

    public function updateAppointment(){
        $validatedData = $this->validate();
        FirstAppointment::findOrFail($this->appointment_id)->update([
            'post' => $validatedData['post'],
            'grade_step' => $validatedData['grade_step'],
            'first_appointment' => $validatedData['first_appointment'],
            'confirmation' => $validatedData['confirmation'],
        ]);
        session()->flash('message', 'Appointment Updated Successfully.');
        $this->dispatch('close-modal');
        $this->resetInput();
    }

    public function deleteAppointment($appointment_id)
    {
        $this->appointment_id = $appointment_id;
        $appointment = FirstAppointment::findOrFail($appointment_id);
    }

    public function destroyAppointment()
    {
        try {
            $appointment = FirstAppointment::FindOrFail($this->appointment_id);
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
        $appointment = FirstAppointment::where('user_id', $this->user->id)->first();

        return view('livewire.staff.first-appointment.index', [
            'appointment' => $appointment,
            ])->extends('layouts.staff')->section('content');
    }
}
