<div>
    @include('livewire.staff.honours.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-thumbs-up menu-icon"></i>
            </span> Honours and Distinctions
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
        <small class="purple-text">List academic honours and distinctions</small>
    @endsection

    <div class="row">
        <div class="col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add New Honour/Distinction</h4>
                <form wire:submit.prevent="storeAward">
                    <div class="form-group">
                        <label>Award</label>
                        <input type="text" wire:model.defer="award" class="form-control" placeholder="Award" required>
                        @error('award') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label>Awarding Body</label>
                        <input type="text" wire:model.defer="awarding_body" class="form-control" placeholder="Awarding Body" required>
                        @error('awarding_body') <small class="text-danger">{{ $message }}</small> @enderror
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
                <h4 class="card-title mb-3">All Honours/Distinctions</h4>
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
                            <th scope="col" class="ps-3">Award</th>
                            <th scope="col" class="ps-3">Awarding Body</th>
                            <th scope="col" class="ps-3">Date</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($awards as $award)
                                <tr>
                                    <td class="ps-3"> {{$award->award}} </td>
                                    <td class="ps-3"> {{$award->awarding_body}} </td>
                                    <td class="ps-3"> {{$award->date}} </td>
                                    <td class="d-flex justify-content-end">
                                        <a href="#" wire:click="editAward({{ $award->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateAwardModal"><i class="fa-solid fa-pen-nib"></i></a>
                                        <a href="#" wire:click="deleteAward({{ $award->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAwardModal"><i class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-danger text-center">No Honours/Distinctions Found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $awards->links() }}
                </div>

            </div>
        </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#updateAwardModal').modal('hide');
            $('#deleteAwardModal').modal('hide');
        });
    </script>
@endsection
