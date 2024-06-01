<!-- Add Modal -->
<div wire:ignore.self class="modal fade" id="addAppointmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Add Appointment</h1>
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
                <form wire:submit="storeAppointment">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label">Rank</label>
                                <select class="form-select form-control form-control-lg" wire:model.defer="rank_id" required>
                                    <option value="">Select Rank</option>
                                    @foreach ($ranks as $rank)
                                        <option value="{{ $rank->id }}">{{ $rank->rank }}</option>
                                    @endforeach
                                </select>
                                @error('rank_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="form-label"><small>Salary Grade/Step</small></label>
                                <input type="text" wire:model.defer="grade_step" class="form-control" placeholder="Salary Grade/Step" required>
                                @error('grade_step') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="date">Date of First Appointment</label>
                                <input type="date" wire:model.defer="first_appointment" class="form-control" required>
                                @error('first_appointment') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="date">Date of Confirmation of Appointment</label>
                                <input type="date" wire:model.defer="confirmation" class="form-control" required>
                                @error('confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
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
<div wire:ignore.self class="modal fade" id="updateAppointmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Update Appointment</h1>
                <button type="button" class="btn-close" wire:click="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div wire:loading class="py-5">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="spinner-grow purple-text" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <div wire:loading.remove>
                <form wire:submit="updateAppointment">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label">Rank</label>
                                <select class="form-select form-control form-control-lg" wire:model.defer="rank_id" required>
                                    <option value="">Select Rank</option>
                                    @foreach ($ranks as $rank)
                                        <option value="{{ $rank->id }}">{{ $rank->rank }}</option>
                                    @endforeach
                                </select>
                                @error('rank_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="form-label"><small>Salary Grade/Step</small></label>
                                <input type="text" wire:model.defer="grade_step" class="form-control" placeholder="Salary Grade/Step" required>
                                @error('grade_step') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="date">Date of First Appointment</label>
                                <input type="date" wire:model.defer="first_appointment" class="form-control" required>
                                @error('first_appointment') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label for="date">Date of Confirmation of Appointment</label>
                                <input type="date" wire:model.defer="confirmation" class="form-control" required>
                                @error('confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-lg btn-gradient-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- DELETE MODAL -->
<div wire:ignore.self class="modal fade" id="deleteAppointmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Delete Record</h1>
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
                <form wire:submit="destroyAppointment()">
                    <div class="modal-body">
                        <h4>Are you sure you want to delete this Record?</h4>
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
