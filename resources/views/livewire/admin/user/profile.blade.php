<div>
    {{-- @include('livewire.admin.user.modals.academic-staff_modal-form') --}}

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-address-card menu-icon"></i>
            </span> Staff Profile
        </h3>
        @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item" aria-current="page">
                <a href="{{ url('admin/staff')}}">Staff</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Profile
            </li>
        </ul>
        </nav>
    @endsection


    <div class="row">
        <div class="col-md-12 my-4">

            {{-- <nav class="navbar navbar-expand-md bg-gradient-primary">
                <div class="container-fluid text-white">
                    <a class="navbar-brand no-color" href="#">Staff ID</a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#profileNavigation" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="mdi mdi-menu text-white"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="profileNavigation">
                        <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                        <a class="nav-link" href="#">Features</a>
                        <a class="nav-link" href="#">Pricing</a>
                        <a class="nav-link disabled">Disabled</a>
                        </div>
                    </div>
                </div>
            </nav> --}}
        </div>

        <div class="col-md-12 mb-3">
            <div class="row ">
                <div class="col-md-4">
                    <img src="{{ asset('assets/photos/'.$user->profile->photo) }}" class="img-fluid img-thumbnail p-3 shadow" alt="Profile Photo">
                </div>
                <div class="col-md-8 mt-md-0 mt-4">
                    <h2>{{$user->profile->title->name}} {{$user->profile->firstname}} {{$user->profile->lastname}} {{$user->profile->othername}}</h2>
                    <h4 class="text-muted mb-3">{{$user->profile->designation}}</h4>

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

                    <p><strong class="purple-text">Biography:</strong></p>
                    <p class="text-secondary">
                        {{$user->profile->biography}}
                    </p>

                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card">
                <div class="card-header text-white bg-gradient-primary pt-3"><h4>Interests</h4></div>
                <div class="card-body">
                    @if ($user->interests->isNotEmpty())
                        <table class="table">
                            <tbody>
                                @foreach($user->interests as $interest)
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
                                    <a href="{{ $social->url }}" target="_blank"><i class="fa-brands {{ $social->icon }} me-2"></i> {{ $social->sm }} <i class="fa-solid fa-arrow-up-right-from-square text-secondary ms-2 fa-xs"></i></a>
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
            $('#addStaffModal').modal('hide');
            $('#banStaffModal').modal('hide');
            $('#deleteStaffModal').modal('hide');
        });
    </script>
@endsection
