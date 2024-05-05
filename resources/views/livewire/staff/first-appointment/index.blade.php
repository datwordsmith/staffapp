<div>
    @include('livewire.staff.first-appointment.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-thumbs-up menu-icon"></i>
            </span> First Appointment
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
                        @if (!$appointment)
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addAppointmentModal">
                                <i class="fa-solid fa-plus"></i> Add Record
                            </button>
                        @endif
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
                                <th scope="col" class="ps-3">Post</th>
                                <th scope="col" class="ps-3">Salary Grade/Step</th>
                                <th scope="col" class="ps-3">Date of First Appointment</th>
                                <th scope="col" class="ps-3">Confirmation Date</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($appointment)
                                    <tr>
                                        <td class="ps-3"> {{$appointment->post}} </td>
                                        <td class="ps-3"> {{$appointment->grade_step}} </td>
                                        <td class="ps-3"> {{$appointment->first_appointment}} </td>
                                        <td class="ps-3"> {{$appointment->confirmation}} </td>
                                        <td class="d-flex justify-content-end">
                                            <a href="#" wire:click="editAppointment({{ $appointment->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateAppointmentModal"><i class="fa-solid fa-pen-nib"></i></a>
                                            <a href="#" wire:click="deleteAppointment({{ $appointment->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAppointmentModal"><i class="fa-solid fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td colspan="5" class="text-danger text-center">No Record Found</td>
                                    </tr>
                                @endif

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
