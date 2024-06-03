<!-- Edit Modal -->
<div wire:ignore.self class="modal fade" id="updateSubUnitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Sub-Unit</h1>
                <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div wire:loading class="py-5">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="spinner-grow purple-text" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div wire:loading.remove>
                <form wire:submit="updateSubUnit()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Sub-Unit</label>
                            <input type="text" wire:model.defer="name" class="form-control" placeholder="Sub-Unit">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click ="closeModal" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gradient-primary"><i class="fa-regular fa-thumbs-up"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- DELETE TITLE MODAL -->
<div wire:ignore.self class="modal fade" id="deleteSubUnitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Delete Sub-Unit</h1>
                <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div wire:loading class="py-5">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="spinner-grow purple-text" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div wire:loading.remove>
                <form wire:submit="destroySubUnit()">
                    <div class="modal-body">
                        <h4>Are you sure you want to delete this sub-unit - "{{ $deleteName }}"?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click ="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END DELETE MODAL -->
