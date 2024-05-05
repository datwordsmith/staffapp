<div>
    @include('livewire.staff.completed-researches.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-newspaper menu-icon"></i>
            </span> Completed Researches
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
                    <h4 class="card-title mb-3">All Completed Researches <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addResearchModal">
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
                            <input type="text" class="form-control" wire:model="search" placeholder="Search...">
                        </div>

                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Research Details</th>
                                    <th scope="col" class="ps-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($researches as $research)
                                    <tr>
                                        <td class="text-wrap ">
                                            <small class="purple-text">Date</small>
                                            <p class="text-purple">{{ date('d M, Y', strtotime($research->date)) }}</p>

                                            <small class="purple-text">Topic</small>
                                            <p>{{ $research->topic }}</p>

                                            <small class="purple-text">Publication Number</small>
                                            <p>{{ $research->publication_number }}</p>

                                            <small class="purple-text">Summary</small>
                                            <p>{{ $research->summary }}</p>

                                            <small class="purple-text">Findings</small>
                                            <p>{{ $research->findings }}</p>
                                        </td>
                                        <td class="align-top">
                                            <div class="d-flex justify-content-end">
                                                <a href="#" wire:click="editResearch({{ $research->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateResearchModal"><i class="fa-solid fa-pen-nib"></i></a>
                                                <a href="#" wire:click="deleteResearch({{ $research->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteResearchModal"><i class="fa-solid fa-trash-can"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">No Reseach found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $researches->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#addResearchModal').modal('hide');
            $('#updateResearchModal').modal('hide');
            $('#deleteResearchModal').modal('hide');
        });

        var modals = ['#addResearchModal', '#updateResearchModal', '#deleteResearchModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endsection
