<div>
    @include('livewire.admin.social-media.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-strong fa-hashtag menu-icon"></i>
            </span> Social Media Platforms
        </h3>
        @endsection

    <div class="row">
        <div class="col-md-5 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Add New Platform</h4>

                <form wire:submit.prevent="storePlatform" class="">
                    <div class="form-group">
                        <label for="platform">Platform</label>
                        <input type="text" wire:model.defer="name" class="form-control" placeholder="Social Media Platform">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="icon">Icon</label>
                        <input type="text" wire:model.defer="icon" class="form-control" placeholder="Icon Class">
                        <small>Eg: <em class="text-secondary">"fa-brands fa-facebook"</em></small>
                        <p><small><a href="fontawesome.com/v6/search?o=r&m=free&f=brands" target="_blank">See More Icon Classes</a></small></p>
                        @error('icon') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-lg btn-gradient-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>
        </div>
        <div class="col-md-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">Social Media Platforms</h4>
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
                    <div class="">
                        <input type="text" class="form-control" wire:model="search" placeholder="Search...">
                    </div>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                            <th scope="col" class="ps-3">Icon</th>
                            <th scope="col" class="ps-3">Platform</th>
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($platforms as $platform)
                                <tr>
                                    <td class="ps-3"> <i class="{{$platform->icon}} fa-xl"></i></td>
                                    <td class="ps-3"> {{$platform->name}} </td>
                                    <td class="d-flex justify-content-end">
                                        <a href="#" wire:click="editPlatform({{ $platform->id }})" class="btn btn-sm btn-warning me-2" data-bs-toggle="modal" data-bs-target="#updatePlatformModal"><i class="fa-solid fa-pen-nib"></i></a>
                                        <a href="#" wire:click="deletePlatform({{ $platform->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deletePlatformModal"><i class="fa-solid fa-trash-can"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-danger text-center">No Platforms Found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <div>
                    {{ $platforms->links() }}
                </div>

            </div>
        </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#updatePlatformModal').modal('hide');
            $('#deletePlatformModal').modal('hide');
        });
    </script>
@endsection
