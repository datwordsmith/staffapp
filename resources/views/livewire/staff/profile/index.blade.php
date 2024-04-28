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
                        <img src="{{ asset('uploads/photos/'.$staff->photo) }}" class="img-fluid p-3 shadow" alt="Profile Photo">

                        <a href="#" wire:click="deletePhoto({{ $staff->id }})" class="btn btn-sm btn-danger mt-2 me-1" data-bs-toggle="modal" data-bs-target="#deletePhotoModal">
                            <i class="fa-solid fa-trash-can"></i>
                        </a>
                    @else
                        <img src="{{ asset('uploads/photos/default.jpg') }}" class="img-fluid p-3 shadow" alt="Profile Photo">
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
                        <div class="col-md-4">
                            <strong class="purple-text">Staff ID</strong>
                            <p class="text-muted mt-1">{{$user->staffId}}</p>
                        </div>
                        <div class="col-md-4">
                            <strong class="purple-text">Email</strong>
                            <p class="text-muted mt-1">{{$user->email}}</p>
                        </div>
                        <div class="col-md-4">
                            <strong class="purple-text">DOB</strong>
                            <p class="text-muted mt-1">{{$staff->dob}}</p>
                        </div>

                        <div class="col-md-4">
                            <strong class="purple-text">Faculty</strong>
                            <p class="text-muted mt-1">
                                @if ($user->department && $user->department->department && $user->department->department->faculty)
                                    {{ $user->department->department->faculty->name }}
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4">
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

        <!-- Interests-->
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

        <!-- Social Media -->
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

        <!--First Appointment-->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header text-white bg-gradient-primary pt-3"><h4>First Appointment</h4></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Post</th>
                                    <th scope="col">Salary Grade/Step</th>
                                    <th scope="col">Appointment Date</th>
                                    <th scope="col">Confirmation Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($firstAppointment as $appointment)
                                    <tr>
                                        <td class="text-wrap">{{ $appointment->post }}</td>
                                        <td class="text-wrap">{{ $appointment->grade_step }}</td>
                                        <td class="text-wrap">{{ $appointment->first_appointment }}</td>
                                        <td class="text-wrap">{{ $appointment->confirmation }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">No publications found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $firstAppointment->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!--Teaching Experience-->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header text-white bg-gradient-primary pt-3"><h4> FULAFIA Teaching Experience</h4></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Course Code</th>
                                    <th scope="col">Course Title</th>
                                    <th scope="col">Course Credit Units</th>
                                    <th scope="col">Lectures</th>
                                    <th scope="col">Semester/Year</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($experiences as $experience)
                                    <tr>
                                        <td class="text-wrap">{{ $experience->course_code }}</td>
                                        <td class="text-wrap">{{ $experience->course_title }}</td>
                                        <td class="text-wrap">{{ $experience->credit_unit }}</td>
                                        <td class="text-wrap">{{ $experience->lectures }}</td>
                                        <td class="text-wrap">{{ $experience->semester }}/{{ $experience->year }}</td>
                                    </tr>
                                @empty
                                    <tr class="">
                                        <td colspan="5" class="text-center text-danger py-5">No Experiences Listed.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $experiences->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!--Qualifications-->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header text-white bg-gradient-primary pt-3"><h4>Qualifications</h4></div>
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="pills-initial-tab" data-bs-toggle="pill" data-bs-target="#pills-initial" type="button" role="tab" aria-controls="pills-initial" aria-selected="true">First Appointment</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-others-tab" data-bs-toggle="pill" data-bs-target="#pills-others" type="button" role="tab" aria-controls="pills-others" aria-selected="false">Other Qualifications</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <!--First Qualification - Content-->
                        <div class="tab-pane fade show active" id="pills-initial" role="tabpanel" aria-labelledby="pills-initial-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                        <th scope="col" class="ps-3">Institution</th>
                                        <th scope="col" class="ps-3">Qualification</th>
                                        <th scope="col" class="ps-3">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($Iqualifications as $qualification)
                                            <tr>
                                                <td class="ps-3"> {{$qualification->institution}} </td>
                                                <td class="ps-3"> {{$qualification->qualification}} </td>
                                                <td class="ps-3"> {{$qualification->date}} </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-danger text-center">No Qualification Found</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $Iqualifications->links() }}
                            </div>
                        </div>

                        <!--Other Qualifications - Content-->
                        <div class="tab-pane fade" id="pills-others" role="tabpanel" aria-labelledby="pills-others-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                        <th scope="col" class="ps-3">Institution</th>
                                        <th scope="col" class="ps-3">Qualification</th>
                                        <th scope="col" class="ps-3">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($Aqualifications as $qualification)
                                            <tr>
                                                <td class="ps-3"> {{$qualification->institution}} </td>
                                                <td class="ps-3"> {{$qualification->qualification}} </td>
                                                <td class="ps-3"> {{$qualification->date}} </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-danger text-center">No Qualification Found</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $Aqualifications->links() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!--Awards-->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header text-white bg-gradient-primary pt-3"><h4>Awards</h4></div>
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="pills-scholarships-tab" data-bs-toggle="pill" data-bs-target="#pills-scholarships" type="button" role="tab" aria-controls="pills-scholarships" aria-selected="true">Scholarships/Prizes</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-honours-tab" data-bs-toggle="pill" data-bs-target="#pills-honours" type="button" role="tab" aria-controls="pills-honours" aria-selected="false">Honours/Distinctions</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <!--Awards - Content-->
                        <div class="tab-pane fade show active" id="pills-scholarships" role="tabpanel" aria-labelledby="pills-scholarships-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                        <th scope="col" class="ps-3">Award</th>
                                        <th scope="col" class="ps-3">Awarding Body</th>
                                        <th scope="col" class="ps-3">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($awards as $award)
                                            <tr>
                                                <td class="ps-3"> {{$award->award}} </td>
                                                <td class="ps-3"> {{$award->awarding_body}} </td>
                                                <td class="ps-3"> {{$award->date}} </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-danger text-center">No Scholarship/Prize Found</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $awards->links() }}
                            </div>
                        </div>

                        <!--Honours - Content-->
                        <div class="tab-pane fade" id="pills-honours" role="tabpanel" aria-labelledby="pills-honours-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                        <th scope="col" class="ps-3">Award</th>
                                        <th scope="col" class="ps-3">Awarding Body</th>
                                        <th scope="col" class="ps-3">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($honours as $award)
                                            <tr>
                                                <td class="ps-3"> {{$award->award}} </td>
                                                <td class="ps-3"> {{$award->awarding_body}} </td>
                                                <td class="ps-3"> {{$award->date}} </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-danger text-center">No Honours/Distinctions Found</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $honours->links() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!--Memberships-->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header text-white bg-gradient-primary pt-3"><h4>Memberships</h4></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                <th scope="col" class="ps-3">Society</th>
                                <th scope="col" class="ps-3">Class</th>
                                <th scope="col" class="ps-3">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($memberships as $membership)
                                    <tr>
                                        <td class="ps-3"> {{$membership->society}} </td>
                                        <td class="ps-3"> {{$membership->class}} </td>
                                        <td class="ps-3"> {{$membership->date}} </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-danger text-center">No Membership Found</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $memberships->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!--Conferences-->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header text-white bg-gradient-primary pt-3"><h4>Conferences</h4></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                <th scope="col" class="ps-3">Conference</th>
                                <th scope="col" class="ps-3">Location</th>
                                <th scope="col" class="ps-3">Paper Presented</th>
                                <th scope="col" class="ps-3">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($conferences as $conference)
                                    <tr>
                                        <td class="ps-3"> {{$conference->conference}} </td>
                                        <td class="ps-3"> {{$conference->location}} </td>
                                        <td class="ps-3 text-wrap"> {{$conference->paper_presented}} </td>
                                        <td class="ps-3"> {{$conference->date}} </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-danger text-center">No Conference Found</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    <div>
                        {{ $conferences->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!--Researches-->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header text-white bg-gradient-primary pt-3"><h4>Researches</h4></div>
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="pills-complete-tab" data-bs-toggle="pill" data-bs-target="#pills-complete" type="button" role="tab" aria-controls="pills-complete" aria-selected="true">Completed Researches</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-ongoing-tab" data-bs-toggle="pill" data-bs-target="#pills-ongoing" type="button" role="tab" aria-controls="pills-ongoing" aria-selected="false">Ongoing Researches</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <!--COMPLETED - Content-->
                        <div class="tab-pane fade show active" id="pills-complete" role="tabpanel" aria-labelledby="pills-complete-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Research Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($researches as $research)
                                            <tr>
                                                <td class="text-wrap ">
                                                    <small class="purple-text">Date</small>
                                                    <p class="text-purple">{{ date('d M, Y', strtotime($research->date)) }}</p>

                                                    <small class="purple-text">Topic</small>
                                                    <p>{{ $research->topic }}</p>

                                                    <small class="purple-text">Publication Number</small>
                                                    <p>{{ $research->publication_number }}</p>

                                                    <small class="purple-text">Summary</small>
                                                    <p>{{ $research->summary }}</p>

                                                    <small class="purple-text">Findings</small>
                                                    <p>{{ $research->findings }}</p>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="1">No Reseach found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $awards->links() }}
                            </div>
                        </div>

                        <!--ONGOING - Content-->
                        <div class="tab-pane fade" id="pills-ongoing" role="tabpanel" aria-labelledby="pills-ongoing-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Research Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($ongoingResearches as $research)
                                            <tr>
                                                <td class="text-wrap ">
                                                    <small class="purple-text">Date</small>
                                                    <p class="text-purple">{{ date('d M, Y', strtotime($research->date)) }}</p>

                                                    <small class="purple-text">Topic</small>
                                                    <p>{{ $research->topic }}</p>

                                                    <small class="purple-text">Summary</small>
                                                    <p>{{ $research->summary }}</p>

                                                    <small class="purple-text">Findings</small>
                                                    <p>{{ $research->findings }}</p>


                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="1">No Research found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $ongoingResearches->links() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!--Publications-->
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-header text-white bg-gradient-primary pt-3"><h4>Publications</h4></div>
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="pills-monograph-tab" data-bs-toggle="pill" data-bs-target="#pills-monograph" type="button" role="tab" aria-controls="pills-monograph" aria-selected="true">Monographs/Books</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-articles-tab" data-bs-toggle="pill" data-bs-target="#pills-articles" type="button" role="tab" aria-controls="pills-articles" aria-selected="false">Journal Articles</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-conference-tab" data-bs-toggle="pill" data-bs-target="#pills-conference" type="button" role="tab" aria-controls="pills-conference" aria-selected="false">Conference Proceedings</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <!--MONOGRAPHS - Content-->
                        <div class="tab-pane fade show active" id="pills-monograph" role="tabpanel" aria-labelledby="pills-monograph-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                        @forelse($monographs as $publication)
                                            <tr>
                                                <td class="text-wrap ">
                                                    <small class="purple-text">Title (Year)</small>
                                                    <p class="text-purple">{{ $publication->title }} ({{ $publication->year }})</p>

                                                    <small class="purple-text">Authors</small>
                                                    <p>{{ $publication->authors }}</p>

                                                    <small class="purple-text">Journal (Volume)</small>
                                                    <p>{{ $publication->journal }} {{ $publication->journal_volume }}</p>

                                                    <small class="purple-text">DOI</small>
                                                    <p>{{ $publication->doi }}</p>

                                                    <small class="purple-text">Details</small>
                                                    <p>{{ $publication->details }}</p>

                                                    <small class="purple-text">Journal (Volume)</small>
                                                    <p>{{ $publication->journal }} {{ $publication->journal_volume }}</p>

                                                    <small class="purple-text mb-2">Abstract</small>
                                                    <p class="mt-2">
                                                        {{ $publication->abstractFileName }}
                                                        @if ($publication->abstractFileName)
                                                        <button class="btn btn-sm btn-gradient-primary ms-2" wire:click="downloadAbstract('{{ $publication->abstract }}')"><i class="fas fa-cloud-download-alt"></i> Download Abstract</button>
                                                        @endif
                                                    </p>

                                                    <small class="purple-text">Evidence (Letter from the Editor)</small>
                                                    <p class="mt-2">
                                                        {{ $publication->evidenceFileName }}
                                                        @if ($publication->abstractFileName)
                                                        <button class="btn btn-sm btn-gradient-primary ms-2" wire:click="downloadEvidence('{{ $publication->evidence }}')"><i class="fas fa-cloud-download-alt"></i> Download Evidence</button>
                                                        @endif
                                                    </p>

                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="">
                                                <td colspan="6" class="text-center text-danger py-5">No Monographs/Books Listed.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div>
                                {{ $monographs->links() }}
                            </div>
                        </div>

                        <!--JOURNAL ARTICLES - Content-->
                        <div class="tab-pane fade" id="pills-articles" role="tabpanel" aria-labelledby="pills-articles-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                        @forelse($articles as $publication)
                                            <tr>
                                                <td class="text-wrap ">
                                                    <small class="purple-text">Title (Year)</small>
                                                    <p class="text-purple">{{ $publication->title }} ({{ $publication->year }})</p>

                                                    <small class="purple-text">Authors</small>
                                                    <p>{{ $publication->authors }}</p>

                                                    <small class="purple-text">Journal (Volume)</small>
                                                    <p>{{ $publication->journal }} {{ $publication->journal_volume }}</p>

                                                    <small class="purple-text">DOI</small>
                                                    <p>{{ $publication->doi }}</p>

                                                    <small class="purple-text">Details</small>
                                                    <p>{{ $publication->details }}</p>

                                                    <small class="purple-text">Journal (Volume)</small>
                                                    <p>{{ $publication->journal }} {{ $publication->journal_volume }}</p>

                                                    <small class="purple-text mb-2">Abstract</small>
                                                    <p class="mt-2">
                                                        {{ $publication->abstractFileName }}
                                                        @if ($publication->abstractFileName)
                                                        <button class="btn btn-sm btn-gradient-primary ms-2" wire:click="downloadAbstract('{{ $publication->abstract }}')"><i class="fas fa-cloud-download-alt"></i> Download Abstract</button>
                                                        @endif
                                                    </p>

                                                    <small class="purple-text">Evidence (Letter from the Editor)</small>
                                                    <p class="mt-2">
                                                        {{ $publication->evidenceFileName }}
                                                        @if ($publication->abstractFileName)
                                                        <button class="btn btn-sm btn-gradient-primary ms-2" wire:click="downloadEvidence('{{ $publication->evidence }}')"><i class="fas fa-cloud-download-alt"></i> Download Evidence</button>
                                                        @endif
                                                    </p>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="">
                                                <td class="text-center text-danger py-5">No Journal Articles Listed.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-2">
                                {{ $articles->links() }}
                            </div>
                        </div>

                        <!--CONFERENCE PROCEEDINGS - Content-->
                        <div class="tab-pane fade" id="pills-conference" role="tabpanel" aria-labelledby="pills-conference-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                        @forelse($conferenceProceedings as $publication)
                                            <tr>
                                                <td class="text-wrap ">
                                                    <small class="purple-text">Title (Year)</small>
                                                    <p class="text-purple">{{ $publication->title }} ({{ $publication->year }})</p>

                                                    <small class="purple-text">Authors</small>
                                                    <p>{{ $publication->authors }}</p>

                                                    <small class="purple-text">Journal (Volume)</small>
                                                    <p>{{ $publication->journal }} {{ $publication->journal_volume }}</p>

                                                    <small class="purple-text">DOI</small>
                                                    <p>{{ $publication->doi }}</p>

                                                    <small class="purple-text">Details</small>
                                                    <p>{{ $publication->details }}</p>

                                                    <small class="purple-text">Journal (Volume)</small>
                                                    <p>{{ $publication->journal }} {{ $publication->journal_volume }}</p>

                                                    <small class="purple-text mb-2">Abstract</small>
                                                    <p class="mt-2">
                                                        {{ $publication->abstractFileName }}
                                                        @if ($publication->abstractFileName)
                                                        <button class="btn btn-sm btn-gradient-primary ms-2" wire:click="downloadAbstract('{{ $publication->abstract }}')"><i class="fas fa-cloud-download-alt"></i> Download Abstract</button>
                                                        @endif
                                                    </p>

                                                    <small class="purple-text">Evidence (Letter from the Editor)</small>
                                                    <p class="mt-2">
                                                        {{ $publication->evidenceFileName }}
                                                        @if ($publication->abstractFileName)
                                                        <button class="btn btn-sm btn-gradient-primary ms-2" wire:click="downloadEvidence('{{ $publication->evidence }}')"><i class="fas fa-cloud-download-alt"></i> Download Evidence</button>
                                                        @endif
                                                    </p>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr class="">
                                                <td class="text-center text-danger py-5">No Conference Proceedings Listed.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-2">
                                {{ $conferenceProceedings->links() }}
                            </div>
                        </div>
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
