<div>
    @include('livewire.admin.rank.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-chevron-triple-up menu-icon"></i>
            </span> Ranks
        </h3>
    @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                Ranks
            </li>
        </ul>
        </nav>
    @endsection


    <div class="row">
        <div class="col-md-5 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Add New Rank</h4>

                <form wire:submit="storeRank" class="">
                    <div class="form-group">
                        <label for="rank">Rank</label>
                        <input type="text" wire:model.defer="rank" class="form-control" placeholder="Rank" required>
                        @error('rank') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-select form-control form-control-lg" wire:model.defer="category" required>
                            <option value="">Select a Category</option>
                            <option value="2">Academic</option>
                            <option value="3">Non-Academic</option>
                        </select>
                        @error('category')
                            <small class="error text-danger">{{ $message }}</small>
                        @enderror
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
                <h4 class="card-title mb-3">All Ranks</h4>
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
                            <th scope="col" class="ps-3">Category</th>
                            <th scope="col" class="ps-3">Ranks</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ranks as $rank)
                                <tr>
                                    <td class="ps-3"> {{ $rank->category == 2 ? 'Academic' : 'Non-Academic' }} </td>
                                    <td class="ps-3"> {{$rank->rank}} </td>
                                    <td class="d-flex justify-content-end">
                                        <a href="#" wire:click="editRank({{ $rank->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateRankModal"><i class="fa-solid fa-pen-nib"></i> Edit</a>
                                        <a href="#" wire:click="deleteRank({{ $rank->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteRankModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-danger text-center">No Ranks Found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $ranks->links() }}
                </div>

            </div>
        </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#updateRankModal').modal('hide');
            $('#deleteRankModal').modal('hide');
        });

        var modals = ['#updateRankModal', '#deleteRankModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endsection
