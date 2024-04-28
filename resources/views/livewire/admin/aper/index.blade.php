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

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
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
                        <table class="table table-striped table-hover" id="aperTable">
                            <thead>
                                <tr>

                                    <th scope="col" class="">Staff ID</th>
                                    <th scope="col" class="">Fullname</th>
                                    <th scope="col" class="text-center">Evaluation Grade</th>
                                    <th scope="col" class="text-center">Evaluation Status</th>
                                    <th scope="col" class="text-center">Approval Status</th>
                                    <th scope="col">Date Submitted</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($apers as $aper)
                                    <tr>
                                        <td>{{ $aper->staffId }}</td>
                                        <td>{{ $aper->title }}  {{ $aper->lastname }} {{$aper->firstname}}</td>
                                        <td class="text-center">{{ $aper->evaluation ? $aper->evaluation->grade : '-' }}</td>
                                        <td class="text-center">
                                            {{ $aper->evaluation?->status->name ?? 'Pending' }}
                                        </td>
                                        <td class="text-center">
                                            {{ $aper->approval?->status->name ?? 'Pending' }}
                                        </td>
                                        <td>{{ $aper->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <div class="d-flex justify-content-end">
                                                @if($aper->status_id > 1)
                                                    <a href="#" wire:click="deleteAper({{ $aper->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAperModal">
                                                        <i class="fa-solid fa-trash-can"></i>
                                                    </a>
                                                @else
                                                    <a wire:click="viewAper({{ $aper->id }})" class="btn btn-sm btn-primary">
                                                        <i class="fa-solid fa-folder-open"></i> View
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-danger text-center">No Appraisal Request Found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-2">
                        {{ $apers->links() }}
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
    </script>
@endsection
