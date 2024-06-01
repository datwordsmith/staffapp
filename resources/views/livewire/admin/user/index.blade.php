<div>
    {{-- @include('livewire.admin.programme.modal-form') --}}

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-account-group menu-icon"></i>
            </span> Users
        </h3>
        @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
            <span></span>Users</i>
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
                        <h4 class="card-title mb-3">All Users</h4>
                    </div>
                    <div class="ms-auto">
                        <button class="btn btn-sm btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#addProgrammeModal">
                            <i class="mdi mdi-plus-circle-outline"></i> Add User
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
                                <th scope="col" class="ps-3">Staff ID</th>
                                <th scope="col" class="ps-3">email</th>
                                <th scope="col" class="ps-3">Surname</th>
                                <th scope="col" class="ps-3">Firstname</th>
                                <th scope="col" class="ps-3">Title</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td class="ps-3"> {{$user->staffId}} </td>
                                    <td class="ps-3"> {{$user->email}} </td>
                                    <td class="ps-3"> {{$user->lastname}} </td>
                                    <td class="ps-3"> {{$user->firstname}} </td>
                                    <td class="ps-3"> {{$user->title}} </td>
                                    <td class="d-flex justify-content-end">
                                        <a href="#" class="btn btn-sm btn-success me-2"><i class="fa-regular fa-folder-open"></i> View</a>
                                        <a href="#" wire:click="editProgramme({{ $user->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateProgrammeModal"><i class="fa-solid fa-pen-nib"></i> Edit</a>
                                        <a href="#" wire:click="deleteProgramme({{ $user->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteProgrammeModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-danger text-center">No Users Found</td>
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
            $('#addProgrammeModal').modal('hide');
            $('#updateProgrammeModal').modal('hide');
            $('#deleteProgrammeModal').modal('hide');
        });

        var modals = ['#addProgrammeModal', '#updateProgrammeModal', '#deleteProgrammeModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endsection
