<div>
    @include('livewire.staff.profile.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-address-card menu-icon"></i>
            </span> My Profile
        </h3>
    @endsection

    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="row ">
                <div class="col-md-4">
                    @if(!empty($staff->photo))
                        <img src="{{ asset('storage/assets/photos/'.$staff->photo) }}" class="img-fluid p-3 shadow" alt="Profile Photo">

                        <a href="#" wire:click="deletePhoto({{ $staff->id }})" class="btn btn-sm btn-danger mt-2 me-1" data-bs-toggle="modal" data-bs-target="#deletePhotoModal">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>
                    @else
                        <img src="{{ asset('assets/photos/default.jpg') }}" class="img-fluid p-3 shadow" alt="Profile Photo">
                    @endif
                    <!-- Button to trigger file input -->
                    <button type="button" class="btn btn-sm btn-success mt-2" data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">
                        <i class="fa-solid fa-camera"></i> Uplaod Photo
                    </button>

                </div>
                <div class="col-md-8 mt-md-0 mt-4">
                    <h2>{{$staff->title->name}} {{$staff->firstname}} {{$staff->lastname}} {{$staff->othername}}</h2>
                    <h4 class="text-muted mb-3">{{$staff->designation}}</h4>

                    <div class="row pt-3 border-top border-bottom mb-3">
                        <div class="col-md-6">
                            <strong class="purple-text">Staff ID</strong>
                            <p class="text-muted mt-1">{{$user->staffId}}</p>
                        </div>
                        <div class="col-md-6">
                            <strong class="purple-text">Email</strong>
                            <p class="text-muted mt-1">{{$user->email}}</p>
                        </div>

                        <div class="col-md-6">
                            <strong class="purple-text">Faculty</strong>
                            <p class="text-muted mt-1">
                                @if ($user->department && $user->department->department && $user->department->department->faculty)
                                    {{ $user->department->department->faculty->name }}
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <strong class="purple-text">Department</strong>
                            @if ($user->department && $user->department->department)
                                <p class="text-muted mt-1">{{ $user->department->department->name }}</p>
                            @endif
                        </div>
                    </div>

                    <p><strong class="purple-text">Biography:</strong> <i class="fa-regular fa-pen-to-square"></i></p>
                    <p class="text-secondary">
                        {{ $staff->biography}}
                    </p>
                    <div class="d-flex">
                        <div class="ms-auto">
                            <a href="#" wire:click="editBio({{ $staff->id }})" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#updateBioModal">
                                Update Profile <i class="fa-solid fa-pen-nib"></i>
                            </a>
                            @if(!empty($staff->biography))
                                <a href="#" wire:click="deleteBio({{ $staff->id }})" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBioModal">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header text-white bg-gradient-primary pt-3"><h4>Interests</h4></div>
                <div class="card-body">
                    @if ($interests->count() > 0)
                        <table class="table">
                            <tbody>
                                @foreach($interests as $interest)
                                <tr>
                                    <td><i class="fa-solid fa-star me-4"></i> {{ $interest->interest }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No interests found.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header text-white bg-gradient-primary pt-3"><h4>Social Media</h4></div>
                <div class="card-body social-icons">
                    @if ($socials->count() > 0)
                        <div class="row">
                            @foreach($socials as $social)
                                <div class="col-6 mb-4 pb-2 border-bottom">
                                    <a href="{{ $social->url }}" target="_blank"><i class="{{ $social->icon }} fa-xl me-2"></i> {{ $social->sm }} <i class="fa-solid fa-arrow-up-right-from-square text-secondary ms-2 fa-xs"></i></a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p>No social media accounts found.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header text-white bg-gradient-primary pt-3"><h4>Publications</h4></div>
                <div class="card-body">

                    <div class="table-responsive">
                        <div class="mb-3">
                            <input type="text" class="form-control" wire:model="search" placeholder="Search publications...">
                        </div>

                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Publications</th>
                                    <th scope="col" class="ps-3">URL <i class="fa-solid fa-arrow-up-right-from-square"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($publications as $publication)
                                    <tr>
                                        <td class="text-wrap"><p>{{ $publication->publication }}</p></td>
                                        <td class="text-wrap ps-3">
                                            <a href="{{ $publication->url }}" target="_blank">{{ $publication->url }}</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">No publications found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $publications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#updateBioModal').modal('hide');
            $('#deleteBioModal').modal('hide');
            $('#uploadPhotoModal').modal('hide');
            $('#deletePhotoModal').modal('hide');
        });
    </script>
@endsection
