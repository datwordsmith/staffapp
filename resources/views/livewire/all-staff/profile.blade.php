<section class="team" id="team">
    <div class="container">
        <div class="row">

            <div class="col-md-12 mb-3">
                <div class="row ">
                    <div class="col-md-4">
                        <img src="{{ asset('uploads/photos/' . ($user->profile->photo ?: 'default.jpg')) }}" class="img-fluid p-3 shadow" alt="Profile Photo">
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

                        <div>
                            @if ($socials->count() > 0)
                                @foreach($socials as $social)
                                    <a href="{{ $social->url }}" target="_blank"><i class="fa-brands {{ $social->icon }} fa-xl me-2"></i></a>
                                @endforeach
                            @else

                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card borderless shadow">
                    <div class="card-header text-white bkg-primary pt-3"><h4>Interests</h4></div>
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

            <div class="col-md-8 mb-3">
                <div class="card borderless shadow">
                    <div class="card-header text-white bkg-primary pt-3"><h4>Publications</h4></div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="search" wire:model="search" placeholder="Search...">
                                <label for="search">Search</label>
                            </div>

                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Publications</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($publications as $publication)
                                        <tr>
                                            <td class="text-wrap p-3">
                                                <p>{{ $publication->publication }}</p>

                                                <div>
                                                    <a href="{{ $publication->url }}" target="_blank">{{ $publication->url }}</a>
                                                </div>

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
    </div> <!-- End container -->
</section> <!-- End section -->

@section('scripts')

@endsection
