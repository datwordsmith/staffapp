<div>
    @include('livewire.staff.publications.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-newspaper menu-icon"></i>
            </span> Publications
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
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">All Publications <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addPublicationModal">
                        <i class="fa-solid fa-plus"></i> Add New
                      </button>
                    </h4>
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
                            <input type="text" class="form-control" wire:model="search" placeholder="Search publications...">
                        </div>

                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Publications</th>
                                    <th scope="col" class="ps-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($publications as $publication)
                                    <tr>
                                        <td class="text-wrap">
                                            <p>{{ $publication->publication }}</p>

                                            <p><strong><i class="fa-solid fa-at me-1"></i></strong>
                                                <a href="{{ $publication->url }}" target="_blank">{{ $publication->url }}</a>
                                            </p>
                                        </td>
                                        <td class="">
                                            <a href="#" wire:click="editPublication({{ $publication->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updatePublicationModal"><i class="fa-solid fa-pen-nib"></i> Edit</a>
                                            <a href="#" wire:click="deletePublication({{ $publication->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletePublicationModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">No publications found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $publications->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#addPublicationModal').modal('hide');
            $('#updatePublicationModal').modal('hide');
            $('#deletePublicationModal').modal('hide');
        });

        var modals = ['#addPublicationModal', '#updatePublicationModal', '#deletePublicationModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endsection
