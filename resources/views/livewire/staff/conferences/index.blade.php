<div>
    @include('livewire.staff.conferences.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-thumbs-up menu-icon"></i>
            </span> Conferences
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
        <small class="purple-text">List conferences attended</small>
    @endsection


    <div class="row">
        <div class="col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add New Conference</h4>
                <form wire:submit="storeConference" class="">
                    <div class="form-group">
                        <label>Conference</label>
                        <input type="text" wire:model.defer="conference" class="form-control" placeholder="Conference" required>
                        @error('conference') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label>Conference Location</label>
                        <input type="text" wire:model.defer="location" class="form-control" placeholder="Conference Location" required>
                        @error('location') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label>Paper Presented</label>
                        <textarea wire:model.defer="paper_presented" class="form-control" rows="4" placeholder="Paper Presented"></textarea>
                        @error('paper_presented') <small class="text-danger">{{ $message }}</small> @enderror
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
                <h4 class="card-title mb-3">All Conferences</h4>
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
                        <input type="text" class="form-control" wire:model.live="search" placeholder="Search...">
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                            <th scope="col" class="ps-3">Conference</th>
                            <th scope="col" class="ps-3">Location</th>
                            <th scope="col" class="ps-3">Paper Presented</th>
                            <th scope="col" class="ps-3">Date</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($conferences as $conference)
                                <tr>
                                    <td class="ps-3"> {{$conference->conference}} </td>
                                    <td class="ps-3"> {{$conference->location}} </td>
                                    <td class="ps-3 text-wrap"> {{$conference->paper_presented}} </td>
                                    <td class="ps-3"> {{$conference->date}} </td>
                                    <td class="d-flex justify-content-end">
                                        <a href="#" wire:click="editConference({{ $conference->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateConferenceModal"><i class="fa-solid fa-pen-nib"></i> Edit</a>
                                        <a href="#" wire:click="deleteConference({{ $conference->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConferenceModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-danger text-center">No Conference Found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $conferences->links() }}
                </div>

            </div>
        </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#updateConferenceModal').modal('hide');
            $('#deleteConferenceModal').modal('hide');
        });

        var modals = ['#updateConferenceModal', '#deleteConferenceModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endsection
