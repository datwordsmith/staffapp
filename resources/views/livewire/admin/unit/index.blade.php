<div>
    @include('livewire.admin.unit.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-file-tree menu-icon"></i>
            </span> Units
        </h3>
    @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                Units
            </li>
        </ul>
        </nav>
    @endsection


    <div class="row">
        <div class="col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Add New Unit</h4>

                <form wire:submit="storeUnit" class="">
                    <div class="form-group">
                        <label for="rank">Unit</label>
                        <input type="text" wire:model.defer="name" class="form-control" placeholder="Unit" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>Head</label>
                        <select class="form-select form-control form-control-lg" wire:model.defer="head_id">
                            <option value="">Select Head</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->lastname }} {{ $user->firstname }} {{ $user->othername }} ({{ $user->title }})</option>
                            @endforeach
                        </select>
                        @error('head_id')
                            <small class="error text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="head_title">Head Title</label>
                        <input type="text" wire:model.defer="head_title" class="form-control" placeholder="Eg. Registrar, Bursar" required>
                        @error('head_title') <small class="text-danger">{{ $message }}</small> @enderror
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
                <h4 class="card-title mb-3">All Units</h4>
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
                            <th scope="col" class="ps-3">Unit</th>
                            <th scope="col" class="ps-3">Head</th>
                            <th scope="col" class="ps-3">Head Title</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($units as $unit)
                                <tr>
                                    <td class="ps-3">
                                        <a href="{{ route('single_unit', ['unitId' => $unit->id]) }}">
                                            {{ $unit->name }}
                                        </a>
                                    </td>
                                    <td class="ps-3">
                                        @if($unit->head_id !== null)
                                            @if($unit->head->profile)
                                                <a href="{{ url('admin/profile/'.$unit->head->staffId) }}">
                                                    {{ $unit->head->profile->title->name }} {{ $unit->head->profile->lastname }} {{ $unit->head->profile->firstname }} {{ $unit->head->profile->othername }}
                                                </a>
                                            @else
                                                No Profile
                                            @endif
                                        @else
                                            Not assigned
                                        @endif
                                    </td>
                                    <td class="ps-3"> {{$unit->head_title}} </td>
                                    <td class="d-flex justify-content-end">
                                        <a href="#" wire:click="editUnit({{ $unit->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateUnitModal"><i class="fa-solid fa-pen-nib"></i> Edit</a>
                                        <a href="#" wire:click="deleteUnit({{ $unit->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUnitModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-danger text-center">No Units Found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $units->links() }}
                </div>

            </div>
        </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#updateUnitModal').modal('hide');
            $('#deleteUnitModal').modal('hide');
    });

        var modals = ['#updateUnitModal', '#deleteUnitModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endsection
