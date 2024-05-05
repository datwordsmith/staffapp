<div>
    @include('livewire.staff.appraisal-request.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-thumbs-up menu-icon"></i>
            </span> Annual Performance Evaluation Request
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
        <small class="purple-text"></small>
    @endsection

    @if(count($checks) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach($checks as $check)
                    <li>{{ $check }}</li>
                @endforeach
            </ul>
        </div>
    @else

            <div class="d-flex justify-content-end mb-3 me-auto">
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addAperModal">
                    <i class="fa-solid fa-plus"></i> New Request
                </button>
            </div>
            @if($isPending)
        @endif
    @endif

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    @if($isPending)
                        <p><small class="text-danger fw-bold"><i class="fas fa-exclamation-triangle"></i> You can only have one open request at a time.</small></p>
                    @endif
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

                        <table class="table table-striped table-hover" id="aperTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">Date Submitted</th>
                                    <th scope="col" class="text-center">Evaluation Grade</th>
                                    <th scope="col" class="text-center">Evaluation Status</th>
                                    <th scope="col" class="text-center">Approval Status</th>
                                    <th scope="col">Date Updated</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($apers as $aper)
                                    <tr>
                                        <td>{{ $aper->created_at->format('d-m-Y') }}</td>
                                        <td class="text-center">{{ $aper->evaluation ? $aper->evaluation->grade : '-' }}</td>
                                        <td class="text-center">
                                            {{ $aper->evaluation?->status->name ?? 'Pending' }}
                                        </td>
                                        <td class="text-center">
                                            {{ $aper->approval?->status->name ?? 'Pending' }}
                                        </td>
                                        <td>{{ $aper->updated_at }}</td>
                                        <td>
                                            <div class="d-flex justify-content-end">
                                                @if(!$aper->evaluation)
                                                    <a href="#" wire:click="deleteAper({{ $aper->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAperModal">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                @elseif($aper->approval)
                                                    <a href="{{ route('aperview', ['aperId' => $aper->id]) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa-solid fa-folder-open"></i> View
                                                    </a>
                                                @else
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-danger text-center">No Appraisal Request Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#addAperModal').modal('hide');
            $('#deleteAperModal').modal('hide');
        });
        new DataTable('#aperTable');

        var modals = ['#addAperModal', '#deleteAperModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });

        $(document).ready(function() {
            $('#aperTable').DataTable({
                "paging": true, // Enable pagination
                "searching": true, // Enable search
            });
        });
    </script>
@endsection
