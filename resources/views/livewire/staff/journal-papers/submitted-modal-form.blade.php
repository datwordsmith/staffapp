<!-- Add Modal -->
<div wire:ignore.self class="modal fade" id="addPaperModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Add New Paper</h1>
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
                <form wire:submit.prevent="storePaper" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label"><small>Title of Paper</small></label>
                                <input type="text" wire:model.defer="title" class="form-control" placeholder="Title of Paper" required>
                                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="form-label"><small>Author(s)</small></label>
                                <input type="text" wire:model.defer="authors" class="form-control" placeholder="Author(s)" required>
                                @error('author') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-2 form-group">
                                <label class="form-label"><small>Year</small></label>
                                <select wire:model.defer="year" class="form-select form-control" required>
                                    <option value="">Select Year</option>
                                    @for ($y = date('Y'); $y >= 2010; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                                @error('year') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9 form-group">
                                <label class="form-label"><small>Name of Learned Journal</small></label>
                                <input type="text" wire:model.defer="journal" class="form-control" placeholder="Name of Learned Journal" required>
                                @error('journal') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-3 form-group">
                                <label class="form-label"><small>Volume of Learned Journal</small></label>
                                <input type="text" wire:model.defer="journal_volume" class="form-control" placeholder="Volume of Journal" required>
                                @error('journal_volume') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label"><small>Upload Abstract (pdf only)</small></label>
                                <input type="file" wire:model="abstract" class="form-control" accept=".pdf" required>
                                @error('abstract') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="form-label"><small>Upload photocopy of the letter from the Editor (pdf only)</small></label>
                                <input type="file" wire:model="evidence" class="form-control" accept=".pdf" required>
                                @error('evidence') <small class="text-danger">{{ $message }}</small> @enderror
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
<div wire:ignore.self class="modal fade" id="updatePaperModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-4">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Update Paper</h1>
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
                <form wire:submit.prevent="updatePaper" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label"><small>Title of Paper</small></label>
                                <input type="text" wire:model.defer="title" class="form-control" placeholder="Title of Paper" required>
                                @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-4 form-group">
                                <label class="form-label"><small>Author(s)</small></label>
                                <input type="text" wire:model.defer="authors" class="form-control" placeholder="Author(s)" required>
                                @error('authors') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-2 form-group">
                                <label class="form-label"><small>Year</small></label>
                                <select wire:model.defer="year" class="form-control form-select" required>
                                    <option value="">Select Year</option>
                                    @for ($y = date('Y'); $y >= 2010; $y--)
                                        <option value="{{ $y }}">{{ $y }}</option>
                                    @endfor
                                </select>
                                @error('year') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-9 form-group">
                                <label class="form-label"><small>Name of Learned Journal</small></label>
                                <input type="text" wire:model.defer="journal" class="form-control" placeholder="Name of Learned Journal" required>
                                @error('journal') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-3 form-group">
                                <label class="form-label"><small>Volume of Learned Journal</small></label>
                                <input type="text" wire:model.defer="journal_volume" class="form-control" placeholder="Volume of Journal" required>
                                @error('journal_volume') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="form-label"><small>Upload Abstract (pdf only)</small></label>
                                <input type="file" wire:model="abstract" class="form-control" accept=".pdf">
                                @error('abstract') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <label class="form-label"><small>Upload photocopy of the letter from the Editor (pdf only)</small></label>
                                <input type="file" wire:model="evidence" class="form-control" accept=".pdf">
                                @error('evidence') <small class="text-danger">{{ $message }}</small> @enderror
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
<div wire:ignore.self class="modal fade" id="deletePaperModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Delete Journal Paper</h1>
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
                <form wire:submit.prevent="destroyPaper()">
                    <div class="modal-body">
                        <h4>Are you sure you want to delete this Paper?</h4>
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
