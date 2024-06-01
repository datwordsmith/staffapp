<section class="team" id="team">
    <div class="container">

        <div class="card mt-3 borderless">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="search" wire:model="search" placeholder="Search...">
                            <label for="search">Search</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @forelse ($allstaff as $user)
                        <div class="col-lg-4 col-md-6">
                            <div class="team-member text-center shadow">
                                <div class="member-photo pt-4">
                                    <img class="img-fluid" src="{{ asset('uploads/photos/' . ($user->profile->photo ?: 'default.jpg')) }}" alt="{{ $user->staffId }}" style="width: 200px; height: 200px;"> <!-- Adjust width and height as needed -->

                                </div>
                                <div class="member-content">
                                    <h3 class="my-primary"><strong>{{$user->profile->title->name}} {{$user->profile->lastname}}</strong></h3>
                                    <h3 class="text-secondary">{{$user->profile->firstname}} {{$user->profile->othername}}</h3>
                                    <span>- {{$user->profile->rank->rank}} -</span>
                                    <!--<p>{{ Str::limit($user->profile->biography, $limit = 50, $end = '...') }}</p>-->
                                    <p><a href="{{ url('profile/'.$user->staffId) }}" class="btn btn-sm btn-primary me-2"><i class="fa-regular fa-folder-open"></i> View Profile</a></p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-lg-6 mx-auto mt-3 text-center d-flex justify-content-center">
                            <div class="alert alert-danger" role="alert">
                                {{$search}} not found.
                            </div>
                        </div>
                    @endforelse
                    <!-- end team member -->
                </div> <!-- End row -->
            </div>
        </div>


        <div>
            {{ $allstaff->links() }}
        </div>



    </div> <!-- End container -->
</section> <!-- End section -->

@section('scripts')

@endsection
