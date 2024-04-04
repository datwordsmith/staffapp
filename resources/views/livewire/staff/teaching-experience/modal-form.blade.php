<!-- Add Modal -->
<div wire:ignore.self class="modal fade" id="addExperienceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Add New Experience</h1>
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
                <form wire:submit.prevent="storeExperience" class="">
                    <div class="modal-body">
                        <p><small>(Indicate courses taught with dates, credit units, total hours of lecture, practical/field work
                            involved, indicate as well, number of lecturers co-teaching the courses)</small></p>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label"><small>Course Code</small></label>
                                <input type="text" wire:model.defer="course_code" class="form-control" placeholder="Course Code" required>
                                @error('course_code') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="form-label"><small>Credit Unit</small></label>
                                <input type="number" wire:model.defer="credit_unit" class="form-control" required>
                                @error('credit_unit') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><small>Course Title</small></label>
                            <input type="text" wire:model.defer="course_title" class="form-control" placeholder="Course Title" required>
                            @error('course_title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="form-label"><small>No. of Lectures</small></label>
                                <input type="number" wire:model.defer="lectures" class="form-control" required>
                                @error('lectures') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="form-label"><small>Semester</small></label>
                                <select class="form-select form-control form-control-lg" wire:model.defer="semester" required>
                                    <option selected>Select Semester</option>
                                    <option value="First">First</option>
                                    <option value="Second">Second</option>
                                    <option value="Third">Third</option>
                                  </select>
                                @error('semester') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="form-label"><small>Year</small></label>
                                <input type="number" wire:model.defer="year" class="form-control" min="2010" max="{{ date('Y') }}" required>
                                @error('year') <small class="text-danger">{{ $message }}</small> @enderror
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
<div wire:ignore.self class="modal fade" id="updateExperienceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Experience</h1>
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
                <form wire:submit.prevent="updateExperience()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label"><small>Course Code</small></label>
                                <input type="text" wire:model.defer="course_code" class="form-control" placeholder="Course Code" required>
                                @error('course_code') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="form-label"><small>Credit Unit</small></label>
                                <input type="number" wire:model.defer="credit_unit" class="form-control" required>
                                @error('credit_unit') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><small>Course Title</small></label>
                            <input type="text" wire:model.defer="course_title" class="form-control" placeholder="Course Title" required>
                            @error('course_title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label class="form-label"><small>No. of Lectures</small></label>
                                <input type="number" wire:model.defer="lectures" class="form-control" required>
                                @error('lectures') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="form-label"><small>Semester</small></label>
                                <select class="form-select form-control form-control-lg" wire:model.defer="semester" required>
                                    <option selected>Select Semester</option>
                                    <option value="First">First</option>
                                    <option value="Second">Second</option>
                                    <option value="Third">Third</option>
                                  </select>
                                @error('semester') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="form-label"><small>Year</small></label>
                                <input type="number" wire:model.defer="year" class="form-control" min="2010" max="{{ date('Y') }}" required>
                                @error('year') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
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
<div wire:ignore.self class="modal fade" id="deleteExperienceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Delete Experience</h1>
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
                <form wire:submit.prevent="destroyExperience()">
                    <div class="modal-body">
                        <h4>Are you sure you want to delete this Experience?</h4>
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
