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
        @if(!$isPending)
            <div class="d-flex justify-content-end mb-3 me-auto">
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addAperModal">
                    <i class="fa-solid fa-plus"></i> New Request
                </button>
            </div>
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
                        <div class="">
                            <input type="text" class="form-control" wire:model="search" placeholder="Search...">
                        </div>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                <th scope="col" class="ps-3">Date Submitted</th>
                                <th scope="col" class="ps-3">Current Status</th>
                                <th scope="col" class="ps-3">Date Updated</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($apers as $aper)
                                    <tr>
                                        @php
                                        $statusClass = ''; // Default value
                                        switch ($aper->status_id) {
                                            case 2:
                                                $statusClass = 'success';
                                                break;
                                            case 3:
                                                $statusClass = 'danger';
                                                break;
                                            default:
                                                $statusClass = 'primary';
                                        }
                                        @endphp

                                        <td class="ps-3"> {{$aper->created_at}} </td>
                                        <td class="ps-3"><span class="badge bg-{{ $statusClass }}"> {{$aper->status}} </span></td>
                                        <td class="ps-3"> {{$aper->updated_at}} </td>
                                        <td class="ps-3">
                                            <div class="d-flex justify-content-end">
                                                @if($aper->status_id > 1)
                                                    <a href="#" wire:click="deleteAper({{ $aper->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAperModal"><i class="fa-solid fa-trash-can"></i></a>
                                                @else
                                                    <a wire:click="viewAper({{ $aper->id }})" class="btn btn-sm btn-primary"><i class="fa-solid fa-folder-open"></i> View </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-danger text-center">No Appraisal Request Found</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    <div>
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
