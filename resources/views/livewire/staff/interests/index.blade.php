<div>
    @include('livewire.staff.interests.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-thumbs-up menu-icon"></i>
            </span> Interests
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


    <div class="row">
        <div class="col-md-5 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Add New Interest</h4>

                <form wire:submit="storeInterest" class="">
                    <div class="form-group">
                    <label for="interest">Interest</label>
                    <input type="text" wire:model.defer="interest" class="form-control" placeholder="Interest">
                    @error('interest') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-lg btn-gradient-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>
        </div>
        <div class="col-md-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">All Interests</h4>
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
                            <th scope="col" class="ps-3">Interest</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($interests as $interest)
                                <tr>
                                    <td class="ps-3"> {{$interest->interest}} </td>
                                    <td class="d-flex justify-content-end">
                                        <a href="#" wire:click="editInterest({{ $interest->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateInterestModal"><i class="fa-solid fa-pen-nib"></i></a>
                                        <a href="#" wire:click="deleteInterest({{ $interest->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteInterestModal"><i class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-danger text-center">No Interests Found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $interests->links() }}
                </div>

            </div>
        </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#updateInterestModal').modal('hide');
            $('#deleteInterestModal').modal('hide');
        });
    </script>
@endsection
