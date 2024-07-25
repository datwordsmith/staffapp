<div>
    @include('livewire.admin.faculty.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-sitemap menu-icon"></i>
            </span> Faculties
        </h3>
    @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                Faculties
            </li>
        </ul>
        </nav>
    @endsection


    <div class="row">
        <div class="col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Add New Faculty</h4>

                <form wire:submit="storeFaculty" class="">
                    <div class="form-group">
                        <label for="faculty">Faculty</label>
                        <input type="text" wire:model.defer="name" class="form-control" placeholder="Faculty" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>Dean</label>
                        <select class="form-select form-control form-control-lg" wire:model.defer="dean_id">
                            <option value="">Select Dean</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->lastname }} {{ $user->firstname }} {{ $user->othername }} ({{ $user->title }})</option>
                            @endforeach
                        </select>
                        @error('dean_id')
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
        <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">All Faculties</h4>
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
                        <input type="text" class="form-control" wire:model.live="search" placeholder="Search...">
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                            <th scope="col" class="ps-2">Faculty</th>
                            <th scope="col" class="ps-2">Dean</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($faculties as $faculty)
                                <tr>
                                    <td class="ps-2">
                                        <a href="{{ route('faculty', ['facultyId' => $faculty->id]) }}">
                                            {{$faculty->name}}
                                        </a>
                                    </td>
                                    <td>
                                        @if($faculty->dean_id !== null)
                                            <a href="{{ url('admin/profile/'.$faculty->dean->staffId) }}">
                                                {{ $faculty->dean->profile->title->name }} {{ $faculty->dean->profile->lastname }} {{ $faculty->dean->profile->firstname }} {{ $faculty->dean->profile->othername }}
                                            </a>
                                        @else
                                            Not assigned
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-end">
                                        <a href="#" wire:click="editFaculty({{ $faculty->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateFacultyModal"><i class="fa-solid fa-pen-nib"></i> Edit</a>
                                        <a href="#" wire:click="deleteFaculty({{ $faculty->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteFacultyModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-danger text-center">No Faculties Found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $faculties->links() }}
                </div>

            </div>
        </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#updateFacultyModal').modal('hide');
            $('#deleteFacultyModal').modal('hide');
        });

        var modals = ['#updateFacultyModal', '#deleteFacultyModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endsection
