<div>
    @include('livewire.staff.university-administration.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-newspaper menu-icon"></i>
            </span> University Administration
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
        <small class="purple-text">List instances of participation in University Administration indicating in year(s)</small>
    @endsection


    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-3 me-auto">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addAdministrationModal">
                            <i class="fa-solid fa-plus"></i> Add New
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
                        <div class="mb-3">
                            <input type="text" class="form-control" wire:model.live="search" placeholder="Search...">
                        </div>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Administration Details</th>
                                    <th scope="col" class="ps-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($administrations as $administration)
                                    <tr>
                                        <td class="text-wrap ">
                                            <small class="purple-text">Year</small>
                                            <p class="text-purple">{{ $administration->date }}</p>

                                            <small class="purple-text">Duty</small>
                                            <p>{{ $administration->duty }}</p>

                                            <small class="purple-text">Experience</small>
                                            <p>{{ $administration->experience }}</p>

                                            <small class="purple-text">Commending Officer</small>
                                            <p>{{ $administration->commending_officer }}</p>

                                        </td>
                                        <td class="align-top">
                                            <div class="d-flex justify-content-end">
                                                <a href="#" wire:click="editAdministration({{ $administration->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateAdministrationModal"><i class="fa-solid fa-pen-nib"></i> Edit</a>
                                                <a href="#" wire:click="deleteAdministration({{ $administration->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAdministrationModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">No Record found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $administrations->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#addAdministrationModal').modal('hide');
            $('#updateAdministrationModal').modal('hide');
            $('#deleteAdministrationModal').modal('hide');
        });

        var modals = ['#addAdministrationModal', '#updateAdministrationModal', '#deleteAdministrationModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endsection
