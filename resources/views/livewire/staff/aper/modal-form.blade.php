<!-- Approve Modal -->
<div wire:ignore.self class="modal fade" id="approvalModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Approve/Decline APER</h1>
                <button type="button" class="btn-close" wire:click ="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div>
                <form wire:submit.prevent="storeApproval()">
                    <div class="modal-body">
                        <div class="form-group">
                            <select class="form-select form-control py-3" wire:model.live="status" required>
                                <option selected>Select Action</option>
                                <option value="4">Approve</option>
                                <option value="3">Decline</option>
                            </select>
                            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label>Feedback</label>
                            <textarea class="form-control" wire:model="note" style="height: 120px" {{ $isRequired }}></textarea>
                            @error('note') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click ="closeModal" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gradient-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

