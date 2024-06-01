<div>
    @include('livewire.staff.creative-works.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-thumbs-up menu-icon"></i>
            </span> Creative Works
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
        <small class="purple-text">
            Music, Fine and Applied Arts, Literature,
            Archaeology/Technical Inventions, Design and Constructions, Professional
            Exhibition, Plays, Directorship of Plays, Opera, Concert, Professional Performance
            and Production of Popular Music etc with relevant manuals and descriptions
        </small>
    @endsection

    <div class="row">
        <div class="col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Add New Item</h4>
                <form wire:submit="storeCreativeWork" class="mt-3">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" wire:model.defer="title" class="form-control" placeholder="Title" required>
                        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label>Author</label>
                        <input type="text" wire:model.defer="author" class="form-control" placeholder="Author" required>
                        @error('author') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" wire:model.defer="category" class="form-control" placeholder="Category" required>
                        @error('category') <small class="text-danger">{{ $message }}</small> @enderror
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
                <h4 class="card-title mb-3">Creative Works</h4>
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
                            <th scope="col" class="ps-3">Title</th>
                            <th scope="col" class="ps-3">Author</th>
                            <th scope="col" class="ps-3">Category</th>
                            <th scope="col" class="ps-3">Date</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($creativeWorks as $creativeWork)
                                <tr>
                                    <td class="ps-3"> {{$creativeWork->title}} </td>
                                    <td class="ps-3"> {{$creativeWork->author}} </td>
                                    <td class="ps-3 text-wrap"> {{$creativeWork->category}} </td>
                                    <td class="ps-3"> {{$creativeWork->date}} </td>
                                    <td class="d-flex justify-content-end">
                                        <a href="#" wire:click="editCreativeWork({{ $creativeWork->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateCreativeWorkModal"><i class="fa-solid fa-pen-nib"></i> Edit</a>
                                        <a href="#" wire:click="deleteCreativeWork({{ $creativeWork->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCreativeWorkModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-danger text-center">No Creative Work Found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $creativeWorks->links() }}
                </div>

            </div>
        </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#updateCreativeWorkModal').modal('hide');
            $('#deleteCreativeWorkModal').modal('hide');
        });

        var modals = ['#updateCreativeWorkModal', '#deleteCreativeWorkModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endsection
