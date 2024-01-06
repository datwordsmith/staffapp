<div>
    @include('livewire.admin.user.modals.academic-staff_modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-account-group menu-icon"></i>
            </span> Academic Staff
        </h3>
    @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">
                Users
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Staff
            </li>
        </ul>
        </nav>
    @endsection


    <div class="row">
        <div class="col-md-12 grid-margin ">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-2">
                    <div class="d-flex">
                        <h4 class="card-title mb-3">Academic Staff</h4>
                    </div>
                    <div class="ms-auto">
                        <button class="btn btn-sm btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                            <i class="mdi mdi-plus-circle-outline"></i> Academic Staff
                        </button>
                    </div>
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
                    <div class="">
                        <input type="text" class="form-control" wire:model="search" placeholder="Search...">
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col" class="">Staff ID</th>
                                <th scope="col" class="ps-3">email</th>
                                <th scope="col" class="ps-3">Surname</th>
                                <th scope="col" class="ps-3">Firstname</th>
                                <th scope="col" class="ps-3">Title</th>
                                <th scope="col" class="ps-3 text-center">Status</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td class="">
                                        @if ($this->hasProfile($user->id))
                                            <a href="{{ url('admin/profile/'.$user->staffId) }}" class="btn btn-sm btn-primary me-2"><i class="fa-regular fa-folder-open"></i></a>
                                        @else
                                            <button class="btn btn-sm btn-secondary me-2 disabled"><i class="fa-regular fa-folder-open"></i></button>
                                        @endif
                                        {{$user->staffId}}

                                    </td>
                                    <td class="ps-3"> {{$user->email}} </td>
                                    <td class="ps-3"> {{$user->lastname}} </td>
                                    <td class="ps-3"> {{$user->firstname}} </td>
                                    <td class="ps-3"> {{$user->title}} </td>
                                    <td class="ps-3 text-center">
                                        @if ($user->isActive)
                                            <span class="badge bg-primary">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-end">

                                        @if ($user->isActive)
                                            <!-- Show ban button if the user is active -->
                                            <a href="#" wire:click="banAcademicStaff({{ $user->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#banStaffModal">
                                                <i class="fa-solid fa-ban"></i>
                                            </a>
                                        @else
                                            <!-- Show activate button if the user is inactive -->
                                            <a href="#" wire:click="activateAcademicStaff({{ $user->id }})" class="btn btn-sm btn-success me-2">
                                                <i class="fa-solid fa-lock-open"></i>
                                            </a>
                                        @endif

                                        @can('superadmin')
                                            @if ($this->hasProfile($user->id))
                                                <button class="btn btn-sm btn-secondary disabled"><i class="fa-regular fa-trash-can"></i></button>
                                            @else
                                                <a href="#" wire:click="deleteAcademicStaff({{ $user->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteStaffModal"><i class="fa-solid fa-trash-can"></i></a>
                                            @endif
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-danger text-center">No Users Found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $users->links() }}
                </div>

            </div>
        </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#addStaffModal').modal('hide');
            $('#banStaffModal').modal('hide');
            $('#deleteStaffModal').modal('hide');
        });
    </script>
@endsection
