<div>
    @include('livewire.staff.teaching-experience.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-newspaper menu-icon"></i>
            </span> Teaching Experience
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
                    <div class="d-flex justify-content-end mb-3 me-auto">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addExperienceModal">
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
                            <input type="text" class="form-control" wire:model="search" placeholder="Search Experiences...">
                        </div>

                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Course Code</th>
                                    <th scope="col">Course Title</th>
                                    <th scope="col">Course Credit Units</th>
                                    <th scope="col">Lectures</th>
                                    <th scope="col">Semester/Year</th>
                                    <th scope="col" class="ps-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($experiences as $experience)
                                    <tr>
                                        <td class="text-wrap">{{ $experience->course_code }}</td>
                                        <td class="text-wrap">{{ $experience->course_title }}</td>
                                        <td class="text-wrap">{{ $experience->credit_unit }}</td>
                                        <td class="text-wrap">{{ $experience->lectures }}</td>
                                        <td class="text-wrap">{{ $experience->semester }}/{{ $experience->year }}</td>
                                        <td class="">
                                            <a href="#" wire:click="editExperience({{ $experience->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateExperienceModal"><i class="fa-solid fa-pen-nib"></i> Edit</a>
                                            <a href="#" wire:click="deleteExperience({{ $experience->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteExperienceModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="">
                                        <td colspan="6" class="text-center text-danger py-5">No Experiences Listed.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $experiences->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#addExperienceModal').modal('hide');
            $('#updateExperienceModal').modal('hide');
            $('#deleteExperienceModal').modal('hide');
        });

        var modals = ['#addExperienceModal', '#updateExperienceModal', '#deleteExperienceModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endsection
