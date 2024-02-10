<!-- Edit Modal -->
<div wire:ignore.self class="modal fade" id="updateBioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Update Profile</h1>
                <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form wire:submit.prevent="updateBio()">
                <div class="modal-body px-5">
                    <div class="row">
                        <div class="col-lg-6 form-group">
                            <label for="title">Title</label>
                            <select class="form-select" wire:model.defer="title_id" required>
                                <option value="">Select Title</option>
                                @foreach ($titles as $title)
                                    <option value="{{ $title->id }}">{{ $title->name }}</option>
                                @endforeach
                            </select>
                            @error('title_id')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-6 form-group">
                            <label for="lastname">Lastname</label>
                            <input type="text" wire:model.defer="lastname" class="form-control">
                            @error('lastname') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-lg-6 form-group">
                            <label for="firstname">Firstname</label>
                            <input type="text" wire:model.defer="firstname" class="form-control">
                            @error('firstname') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-lg-6 form-group">
                            <label for="othername">Othername</label>
                            <input type="text" wire:model.defer="othername" class="form-control">
                            @error('othername') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-lg-6 form-group">
                            <label for="designation">Designation</label>
                            <input type="text" wire:model.defer="designation" class="form-control">
                            @error('designation') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="bio">Biography</label>
                        <textarea wire:model="biography" class="form-control" rows="5" maxlength="{{ $maxBioCharacters }}" style="line-height: 1.5;" required></textarea>
                        <small class="text-muted">{{ strlen($this->biography) }}/{{ $maxBioCharacters }} characters</small>

                        @error('biography') <small class="text-danger">{{ $message }}</small> @enderror
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

<!-- DELETE MODAL -->
<div wire:ignore.self class="modal fade" id="deleteBioModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Delete Bio</h1>
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
                <form wire:submit.prevent="destroyBio()">
                    <div class="modal-body">
                        <h4>Are you sure you want to delete this?</h4>
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


<!-- UPLOAD PHOTO MODAL -->
<div wire:ignore.self class="modal fade" id="uploadPhotoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload New Photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($photo)
                    <div class="text-center mb-2">
                        <p><small>Photo Preview:</small></p>
                        <img class="img-thumbnail" src="{{ $photo->temporaryUrl() }}" width="100">
                    </div>
                @endif
                <form wire:submit.prevent="uploadPhoto" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="photoInput" class="form-label">Choose File</label>
                        <input type="file" wire:model="photo" class="form-control" id="photoInput">
                        @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- DELETE PHOTO MODAL -->
<div wire:ignore.self class="modal fade" id="deletePhotoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Delete Photo</h1>
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
                <form wire:submit.prevent="destroyPhoto()">
                    <div class="modal-body">
                        <h4>Are you sure you want to delete your profile photo?</h4>
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
