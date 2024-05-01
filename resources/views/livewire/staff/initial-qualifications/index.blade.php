<div>
    @include('livewire.staff.initial-qualifications.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-thumbs-up menu-icon"></i>
            </span> Initial Qualifications
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
        <small class="purple-text">List qualifications on first appointment</small>
    @endsection

    <div class="row">
        <div class="col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add Initial Qualification</h4>
                <form wire:submit="storeQualification">
                    <div class="form-group">
                        <label>Insititution</label>
                        <input type="text" wire:model.defer="institution" class="form-control" placeholder="Insititution" required>
                        @error('insititution') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label>Qualification</label>
                        <input type="text" wire:model.defer="qualification" class="form-control" placeholder="Qualification" required>
                        @error('qualification') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" wire:model.defer="date" class="form-control" required>
                        @error('date') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-lg btn-gradient-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>
        </div>
        <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">All Qualifications</h4>
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
                            <th scope="col" class="ps-3">Institution</th>
                            <th scope="col" class="ps-3">Qualification</th>
                            <th scope="col" class="ps-3">Date</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($qualifications as $qualification)
                                <tr>
                                    <td class="ps-3"> {{$qualification->institution}} </td>
                                    <td class="ps-3"> {{$qualification->qualification}} </td>
                                    <td class="ps-3"> {{$qualification->date}} </td>
                                    <td class="d-flex justify-content-end">
                                        <a href="#" wire:click="editQualification({{ $qualification->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateQualificationModal"><i class="fa-solid fa-pen-nib"></i></a>
                                        <a href="#" wire:click="deleteQualification({{ $qualification->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteQualificationModal"><i class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-danger text-center">No Qualification Found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $qualifications->links() }}
                </div>

            </div>
        </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#updateQualificationModal').modal('hide');
            $('#deleteQualificationModal').modal('hide');
        });
    </script>
@endsection
