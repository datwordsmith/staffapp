<!-- Edit Modal -->
<div wire:ignore.self class="modal fade" id="updateCreativeWorkModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Creative Work</h1>
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
                <form wire:submit="updateCreativeWork()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" wire:model.defer="title" class="form-control" placeholder="Title" required>
                            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Author</label>
                            <input type="text" wire:model.defer="author" class="form-control" placeholder="Author" required>
                            @error('author') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" wire:model.defer="category" class="form-control" placeholder="Category" required>
                            @error('category') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" wire:model.defer="date" class="form-control" required>
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
<div wire:ignore.self class="modal fade" id="deleteCreativeWorkModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Delete Creative Work</h1>
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
                <form wire:submit="destroyCreativeWork()">
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
