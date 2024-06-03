<div>
    @include('livewire.admin.department.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-shape-plus menu-icon"></i>
            </span> Departments
        </h3>
        @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
            <span></span>Departments</i>
            </li>
        </ul>
        </nav>
    @endsection


    <div class="row">
        <div class="col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Add New Department</h4>

                <form wire:submit="storeDepartment" class="">
                    <div class="form-group">
                        <label for="department">Department</label>
                        <input type="text" wire:model.defer="name" class="form-control" placeholder="Departrment" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>Faculty</label>
                        <select class="form-select form-control form-control-lg" wire:model.defer="faculty_id" required>
                            <option value="">Select a Faculty</option>
                            @foreach ($faculties as $faculty)
                                <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
                            @endforeach
                        </select>
                        @error('faculty_id')
                            <small class="error text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>HOD</label>
                        <select class="form-select form-control form-control-lg" wire:model.defer="hod_id">
                            <option value="">Select HOD</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->lastname }} {{ $user->firstname }} {{ $user->othername }} ({{ $user->title }})</option>
                            @endforeach
                        </select>
                        @error('hod_id')
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
                <h4 class="card-title mb-3">All Departments</h4>
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
                            <th scope="col" class="ps-2">Department</th>
                            <th scope="col" class="ps-2">Faculty</th>
                            <th scope="col" class="ps-2">HOD</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($departments as $department)
                                <tr>
                                    <td class="ps-2"> {{$department->name}} </td>
                                    <td class="ps-2"> {{$department->faculty}} </td>
                                    <td class="ps-2">
                                        @if($department->hod_id !== null)
                                            <a href="{{ url('admin/profile/'.$department->hod->staffId) }}">
                                                {{ $department->hod->profile->title->name }} {{ $department->hod->profile->lastname }} {{ $department->hod->profile->firstname }} {{ $department->hod->profile->othername }}
                                            </a>
                                        @else
                                            Not assigned
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-end">
                                        <a href="#" wire:click="editDepartment({{ $department->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateDepartmentModal"><i class="fa-solid fa-pen-nib"></i> Edit</a>
                                        <a href="#" wire:click="deleteDepartment({{ $department->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteDepartmentModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-danger text-center">No Departments Found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $departments->links() }}
                </div>

            </div>
        </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#updateDepartmentModal').modal('hide');
            $('#deleteDepartmentModal').modal('hide');
        });

        var modals = ['#updateDepartmentModal', '#deleteDepartmentModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endsection
