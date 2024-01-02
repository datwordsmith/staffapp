<!-- Add Modal -->
<div wire:ignore.self class="modal fade" id="addStaffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Add New Academic Staff</h1>
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
                <form wire:submit.prevent="storeAcademicStaff()">
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Staff ID</label>
                            <input type="text" wire:model.defer="staffId" class="form-control" placeholder="Staff ID">
                            @error('staffId') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" wire:model.defer="email" class="form-control" placeholder="Email Address">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click ="closeModal" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gradient-primary"><i class="fa-regular fa-thumbs-up"></i> Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL -->

<!-- BAN MODAL -->
<div wire:ignore.self class="modal fade" id="banStaffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Deactivate Academic Staff</h1>
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
                <form wire:submit.prevent="deactivateAcademicStaff()">
                    <div class="modal-body">
                        <h4>Are you sure you want to deactivate this user - "{{ $banStaffId }}"?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click ="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Yes, Deactivate</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL -->


<!-- DELETE TITLE MODAL -->
<div wire:ignore.self class="modal fade" id="deleteStaffModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Delete Academic Staff</h1>
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
                <form wire:submit.prevent="destroyAcademicStaff()">
                    <div class="modal-body">
                        <h4>Are you sure you want to delete this user - "{{ $deleteStaffId }}"?</h4>
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
