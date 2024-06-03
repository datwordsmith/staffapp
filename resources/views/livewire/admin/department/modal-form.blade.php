<!-- Edit Modal -->
<div wire:ignore.self class="modal fade" id="updateDepartmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Department</h1>
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
                <form wire:submit="updateDepartment()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Department</label>
                            <input type="text" wire:model.defer="name" class="form-control" placeholder="Department">
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
<div wire:ignore.self class="modal fade" id="deleteDepartmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Delete Department</h1>
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
                <form wire:submit="destroyDepartment()">
                    <div class="modal-body">
                        <h4>Are you sure you want to delete this department - "{{ $deleteName }}"?</h4>
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
