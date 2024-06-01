<div>
    @include('livewire.staff.staff-publications.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-newspaper menu-icon"></i>
            </span> Published Conference Proceedings
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
            Each publication should be listed exactly as published
            indicating Author(s), year of publication, title of article, name of journal, volume number,
            published volume, pagination as may apply. Thesis and dissertation, unless actually published
            should not be listed as books or monographs. Newspaper and magazine articles, papers read at
            conferences, unpublished or rejected manuscripts, unpublished manuals, classified documents
            and materials submitted for publication with no acceptance letters from editors, work in
            progress and books in preparation are not acceptable
        </small>
    @endsection

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-3 me-auto">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addPublicationModal">
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

                            <tbody>
                                @forelse($publications as $publication)
                                    <tr>
                                        <td class="text-wrap ">
                                            <small class="purple-text">Title (Year)</small>
                                            <p class="text-purple">{{ $publication->title }} ({{ $publication->year }})</p>

                                            <small class="purple-text">Authors</small>
                                            <p>{{ $publication->authors }}</p>

                                            <small class="purple-text">Journal (Volume)</small>
                                            <p>{{ $publication->journal }} {{ $publication->journal_volume }}</p>

                                            <small class="purple-text">DOI</small>
                                            <p>{{ $publication->doi }}</p>

                                            <small class="purple-text">Details</small>
                                            <p>{{ $publication->details }}</p>

                                            <small class="purple-text">Journal (Volume)</small>
                                            <p>{{ $publication->journal }} {{ $publication->journal_volume }}</p>

                                            <small class="purple-text mb-2">Abstract</small>
                                            <p class="mt-2">
                                                {{ $publication->abstractFileName }}
                                                @if ($publication->abstractFileName)
                                                <button class="btn btn-sm btn-gradient-primary ms-2" wire:click="downloadAbstract('{{ $publication->abstract }}')"><i class="fas fa-cloud-download-alt"></i> Download Abstract</button>
                                                @endif
                                                <a href="#" wire:click="editPublication({{ $publication->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#changeAbstractModal"><i class="fa-solid fa-pen-nib"></i> Edit</a>
                                            </p>

                                            <small class="purple-text">Evidence (Letter from the Editor)</small>
                                            <p class="mt-2">
                                                {{ $publication->evidenceFileName }}
                                                @if ($publication->abstractFileName)
                                                <button class="btn btn-sm btn-gradient-primary ms-2" wire:click="downloadEvidence('{{ $publication->evidence }}')"><i class="fas fa-cloud-download-alt"></i> Download Evidence</button>
                                                @endif
                                                <a href="#" wire:click="editPublication({{ $publication->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#changeEvidenceModal"><i class="fa-solid fa-pen-nib"></i> Edit</a>
                                            </p>
                                        </td>
                                        <td class="align-top">
                                            <div class="d-flex justify-content-end">
                                                <a href="#" wire:click="editPublication({{ $publication->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updatePublicationModal"><i class="fa-solid fa-pen-nib"></i> Edit</a>
                                                <a href="#" wire:click="deletePublication({{ $publication->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletePublicationModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="">
                                        <td colspan="6" class="text-center text-danger py-5">No Publication Listed.</td>
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
            $('#changeAbstractModal').modal('hide');
            $('#changeEvidenceModal').modal('hide');
        });

        var modals = ['#addPublicationModal', '#updatePublicationModal', '#deletePublicationModal', '#changeAbstractModal', '#changeEvidenceModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endsection
