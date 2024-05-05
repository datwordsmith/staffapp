<div>
    @include('livewire.staff.social-media.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-solid fa-hashtag menu-icon"></i>
            </span> Social Media
        </h3>
    @endsection

    <div class="row">
        <div class="col-md-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Add Social Media</h4>

                    <form wire:submit="storeSocialMedia" class="">
                        <div class="form-group">
                            <select class="form-select" wire:model.defer="socialPlatform_id" required>
                                <option value="">Select a Platform</option>
                                @foreach ($socialMediaPlatforms as $platform)
                                    <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                @endforeach
                            </select>
                            @error('socialPlatform_id')
                                <small class="error text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="text" wire:model.defer="url" class="form-control" placeholder="URL/Website/Link">
                            <small class="form-text text-primary">Eg: https://www.linkedin.com/xyz.</small>
                            @error('url') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-lg btn-gradient-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Social Media Accounts</h4>
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="table-responsive">

                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center"><i class="fa-solid fa-at me-1"></i></th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">URL</th>
                                    <th scope="col" class="ps-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($socialMedia as $account)
                                    <tr>
                                        <td class="text-center"><i class="{{ $account->icon }} fa-xl"></i></td>
                                        <td class="text-wrap">
                                            {{ $account->platform }}
                                        </td>
                                        <td>
                                            <a href="{{ $account->url }}" target="_blank">{{ $account->url }}</a>
                                        </td>
                                        <td class="">
                                            <a href="#" wire:click="deleteSocialMedia({{ $account->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteSocialMediaModal"><i class="fa-solid fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No Accounts found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#deleteSocialMediaModal').modal('hide');
        });

        var modals = ['#deleteSocialMediaModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });
    </script>
@endsection
