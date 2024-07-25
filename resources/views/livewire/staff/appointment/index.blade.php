<div>
    @include('livewire.staff.appointment.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-thumbs-up menu-icon"></i>
            </span> Appointments
        </h3>
        @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
            <span></span></i>
            </li>
        </ul>
        </nav>
    @endsection


    @section('subheader')
        <small class="purple-text"></small>
    @endsection

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-3 me-auto">

                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                                <i class="fa-solid fa-plus"></i> Add Record
                            </button>

                    </div>

                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                <th scope="col" class="ps-3">Rank</th>
                                <th scope="col" class="ps-3">Salary Grade/Step</th>
                                <th scope="col" class="ps-3">Appointment Date</th>
                                <th scope="col" class="ps-3">Transfer of Service Date</th>
                                <th scope="col" class="ps-3">Last Promotion</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($appointments as $appointment)
                                    <tr>
                                        <td class="ps-3"> {{$appointment->rank->rank}} </td>
                                        <td class="ps-3"> {{$appointment->grade_step}} </td>
                                        <td class="ps-3"> {{$appointment->appointment_date}} </td>
                                        <td class="ps-3"> {{$appointment->confirmation_date}} </td>
                                        <td class="ps-3"> {{$appointment->last_promotion}} </td>
                                        <td class="d-flex justify-content-end">
                                            <a href="#" wire:click="editAppointment({{ $appointment->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateAppointmentModal"><i class="fa-solid fa-pen-nib"></i> Edit</a>
                                            <a href="#" wire:click="deleteAppointment({{ $appointment->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAppointmentModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-danger text-center">No Appointment Record Found</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#addAppointmentModal').modal('hide');
            $('#updateAppointmentModal').modal('hide');
            $('#deleteAppointmentModal').modal('hide');
        });

        var modals = ['#addAppointmentModal', '#updateAppointmentModal', '#deleteAppointmentModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endsection
