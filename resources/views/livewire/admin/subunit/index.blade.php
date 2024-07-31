<div>
    @include('livewire.admin.subunit.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-shape-plus menu-icon"></i>
            </span> Sub Units
        </h3>
    @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">
            <span></span>Sub-Units</i>
            </li>
        </ul>
        </nav>
    @endsection


    <div class="row">
        <div class="col-md-4 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Add New Sub-Unit</h4>

                <form wire:submit="storeSubUnit" class="">
                    <div class="form-group">
                        <label for="sub_unit">Sub Unit</label>
                        <input type="text" wire:model.defer="name" class="form-control" placeholder="Sub-Unit" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group">
                        <label>Unit</label>
                        <select class="form-select form-control form-control-lg" wire:model.defer="unit_id" required>
                            <option value="">Select a Unit</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                        @error('unit_id')
                            <small class="error text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>HoU</label>
                        <select class="form-select form-control form-control-lg" wire:model.defer="hou_id">
                            <option value="">Select HoU</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->lastname }} {{ $user->firstname }} {{ $user->othername }} ({{ $user->title }})</option>
                            @endforeach
                        </select>
                        @error('hou_id')
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
                <h4 class="card-title mb-3">All Sub-Units</h4>
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
                            <th scope="col" class="ps-2">Sub-Unit</th>
                            <th scope="col" class="ps-2">Unit</th>
                            <th scope="col" class="ps-2">HoU</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($subunits as $subunit)
                                <tr>
                                    <td class="ps-2"> {{$subunit->name}} </td>
                                    <td class="ps-2"> {{$subunit->unit}} </td>
                                    <td class="ps-2">
                                        @if($subunit->hou_id !== null)
                                            <a href="{{ url('admin/profile/'.$subunit->hou->staffId) }}">
                                                {{ $subunit->hou->profile->title->name }} {{ $subunit->hou->profile->lastname }} {{ $subunit->hou->profile->firstname }} {{ $subunit->hou->profile->othername }}
                                            </a>
                                        @else
                                            Not assigned
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-end">
                                        <a href="#" wire:click="editSubUnit({{ $subunit->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updateSubUnitModal"><i class="fa-solid fa-pen-nib"></i> Edit</a>
                                        <a href="#" wire:click="deleteSubUnit({{ $subunit->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteSubUnitModal"><i class="fa-solid fa-trash-can"></i> Delete</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-danger text-center">No Sub-Units Found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $subunits->links() }}
                </div>

            </div>
        </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#updateSubUnitModal').modal('hide');
            $('#deleteSubUnitModal').modal('hide');
        });

        var modals = ['#updateSubUnitModal', '#deleteSubUnitModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endsection
