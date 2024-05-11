<div>
    @include('livewire.staff.journal-papers.accepted-modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-newspaper menu-icon"></i>
            </span> Papers Accepted for Publication in Learned Journals
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
            Give the name(s) of Author, Year, Title of paper, Name of learned journal and Volume
            of journal if indicated in the letter of acceptance. Also give an abstract of the paper
            accepted for publication. Attach a photocopy of the letter from the Editor of the Journal
            indicating that the paper(s) has/have been accepted for publication
        </small>
    @endsection

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-3 me-auto">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addPaperModal">
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
                            <input type="text" class="form-control" wire:model="search" placeholder="Search...">
                        </div>

                        <table class="table table-striped table-hover">

                            <tbody>
                                @forelse($papers as $paper)
                                    <tr>
                                        <td class="text-wrap ">
                                            <small class="purple-text">Title (Year)</small>
                                            <p class="text-purple">{{ $paper->title }} ({{ $paper->year }})</p>

                                            <small class="purple-text">Authors</small>
                                            <p>{{ $paper->authors }}</p>

                                            <small class="purple-text">Journal (Volume)</small>
                                            <p>{{ $paper->journal }} {{ $paper->journal_volume }}</p>

                                            <small class="purple-text mb-2">Abstract</small>
                                            <p class="mt-2">
                                                {{ $paper->abstractFileName }} <button class="btn btn-sm btn-gradient-primary ms-2" wire:click="downloadAbstract('{{ $paper->abstract }}')"><i class="fas fa-cloud-download-alt"></i> Download Abstract</button>
                                                <a href="#" wire:click="editPaper({{ $paper->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#changeAbstractModal"><i class="fa-solid fa-pen-nib"></i></a>
                                            </p>

                                            <small class="purple-text">Evidence (Letter from the Editor)</small>
                                            <p class="mt-2">
                                                {{ $paper->evidenceFileName }} <button class="btn btn-sm btn-gradient-primary ms-2" wire:click="downloadEvidence('{{ $paper->evidence }}')"><i class="fas fa-cloud-download-alt"></i> Download Evidence</button>
                                                <a href="#" wire:click="editPaper({{ $paper->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#changeEvidenceModal"><i class="fa-solid fa-pen-nib"></i></a>
                                            </p>

                                        </td>
                                        <td class="align-top">
                                            <div class="d-flex justify-content-end">
                                                <a href="#" wire:click="editPaper({{ $paper->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updatePaperModal"><i class="fa-solid fa-pen-nib"></i></a>
                                                <a href="#" wire:click="deletePaper({{ $paper->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletePaperModal"><i class="fa-solid fa-trash-can"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="">
                                        <td colspan="6" class="text-center text-danger py-5">No Journal Paper Listed.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $papers->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#addPaperModal').modal('hide');
            $('#updatePaperModal').modal('hide');
            $('#deletePaperModal').modal('hide');
            $('#changeAbstractModal').modal('hide');
            $('#changeEvidenceModal').modal('hide');
        });

        var modals = ['#addPaperModal', '#updatePaperModal', '#deletePaperModal', '#changeAbstractModal', '#changeEvidenceModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endsection
