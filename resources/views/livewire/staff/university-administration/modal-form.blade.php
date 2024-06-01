<!-- Add Modal -->
<div wire:ignore.self class="modal fade" id="addAdministrationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Add New Record</h1>
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
                <form wire:submit="storeAdministration" class="">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Duty</label>
                            <textarea wire:model.defer="duty" class="form-control" rows="4" placeholder="Duty" required></textarea>
                            @error('duty') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>Experience</label>
                            <textarea wire:model.defer="experience" class="form-control" rows="4" placeholder="Experience" required></textarea>
                            @error('experience') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>Commending Officer</label>
                            <select class="form-select form-control form-control-lg" wire:model.defer="commending_officer" required>
                                <option value="">Select Commending Officer</option>
                                <option value="HOD">HOD</option>
                                <option value="Dean">Dean</option>
                                <option value="Vice Chancellor">Vice Chancellor</option>
                                <option value="Registrar">Registrar</option>
                                <option value="Bursar">Bursar</option>
                                <option value="Librarian">Librarian</option>
                            </select>
                            @error('commending_officer')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label"><small>Date</small></label>
                            <select wire:model.defer="date" class="form-select form-control form-control-lg" required>
                                <option value="">Select Year</option>
                                @for ($y = date('Y'); $y >= 2010; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                            @error('date') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-lg btn-gradient-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div wire:ignore.self class="modal fade" id="updateAdministrationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit</h1>
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
                <form wire:submit="updateAdministration()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Duty</label>
                            <textarea wire:model.defer="duty" class="form-control" rows="4" placeholder="Duty" required></textarea>
                            @error('duty') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>Experience</label>
                            <textarea wire:model.defer="experience" class="form-control" rows="4" placeholder="Experience" required></textarea>
                            @error('experience') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>Commending Officer</label>
                            <select class="form-select form-control form-control-lg" wire:model.defer="commending_officer" required>
                                <option value="">Select Commending Officer</option>
                                <option value="HOD">HOD</option>
                                <option value="Dean">Dean</option>
                                <option value="Vice Chancellor">Vice Chancellor</option>
                                <option value="Registrar">Registrar</option>
                                <option value="Bursar">Bursar</option>
                                <option value="Librarian">Librarian</option>
                            </select>
                            @error('commending_officer')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label"><small>Date</small></label>
                            <select wire:model.defer="date" class="form-select form-control form-control-lg" required>
                                <option value="">Select Year</option>
                                @for ($y = date('Y'); $y >= 2010; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                            @error('date') <small class="text-danger">{{ $message }}</small> @enderror
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

<!-- DELETE MODAL -->
<div wire:ignore.self class="modal fade" id="deleteAdministrationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Delete</h1>
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
                <form wire:submit="destroyAdministration()">
                    <div class="modal-body">
                        <h4>Are you sure you want to delete this item?</h4>
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
