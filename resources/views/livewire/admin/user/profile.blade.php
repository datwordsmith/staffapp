<div>

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
            <li class="breadcrumb-item active" aria-current="page">
                Profile
            </li>
        </ul>
        </nav>
    @endsection

    <div class="row">
        <div class="col-md-12">
            @if($pendingEvaluation)
                <div class="alert alert-warning d-flex justify-content-between align-items-center" role="alert">
                    <div>
                        <strong class="alert-heading">Evaluation Request</strong>
                        for Annual Performance Evaluation Report (APER)
                    </div>
                    <div>
                        <a href="{{ route('evaluate', ['aperId' => $pendingEvaluation->id]) }}" class="btn btn-sm btn-warning">
                            Evaluate
                        </a>
                    </div>
                </div>
            @elseif($pendingApproval)
                <div class="alert alert-danger d-flex justify-content-between align-items-center" role="alert">
                    <div>
                        <strong class="alert-heading">Approval Request</strong>
                        for Annual Performance Evaluation Report (APER)
                    </div>
                    <div>
                        <a href="{{ route('approval', ['aperId' => $pendingApproval->id]) }}" class="btn btn-sm btn-info">
                            Approve/Decline
                        </a>
                    </div>
                </div>
            @elseif($isApproved)
                {{--<div class="alert alert-info d-flex justify-content-between align-items-center" role="alert">
                    <div>
                        <strong class="alert-heading">View Request</strong>
                        for Annual Performance Evaluation Report (APER)
                    </div>
                    <div>
                        <a href="{{ route('aperreport', ['aperId' => $isApproved->id]) }}" class="btn btn-sm btn-info">
                            View
                        </a>
                    </div>
                </div> --}}
            @else
            @endif
        </div>

        <div class="col-md-12 mb-3">
            <div class="row ">
                <div class="col-md-4">
                    <img src="{{ asset('uploads/photos/' . ($user->profile->photo ?: 'default.jpg')) }}" class="img-fluid img-thumbnail p-3 shadow" alt="Profile Photo">
                </div>
                <div class="col-md-8 mt-md-0 mt-4">
                    <h2>{{$user->profile->title->name}} {{$user->profile->firstname}} {{$user->profile->lastname}} {{$user->profile->othername}}</h2>
                    <h4 class="text-muted mb-3">{{$user->profile->rank->rank}}</h4>

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
                            <p class="text-muted mt-1">
                                {{$user->profile->dob}}
                            </p>
                        </div>
                        @if($user->role_as == 2)
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
                        @elseif($user->role_as == 3)
                            <div class="col-md-4">
                                <strong class="purple-text">Unit</strong>
                                <p class="text-muted mt-1">
                                    {{ $user->unit->unit->name }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <p><strong class="purple-text">Biography: </strong></p>
                    <p class="text-secondary">
                        {{$user->profile->biography}}
                    </p>

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
                                @foreach($firstAppointment as $appointment)
                                    <tr>
                                        <td class="text-wrap">{{ $appointment->post }}</td>
                                        <td class="text-wrap">{{ $appointment->grade_step }}</td>
                                        <td class="text-wrap">{{ $appointment->first_appointment }}</td>
                                        <td class="text-wrap">{{ $appointment->confirmation }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                          <button class="nav-link active" id="pills-initial-tab" data-bs-toggle="pill" data-bs-target="#pills-initial" type="button" role="tab" aria-controls="pills-initial" aria-selected="true">Qualifications on First Appointment</button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="pills-others-tab" data-bs-toggle="pill" data-bs-target="#pills-others" type="button" role="tab" aria-controls="pills-others" aria-selected="false">Other Qualifications</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <!--First Qualification - Content-->
                        <div class="tab-pane fade show active" id="pills-initial" role="tabpanel" aria-labelledby="pills-initial-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="Iqualifications" style="width: 100%">
                                    <thead>
                                        <tr>
                                        <th scope="col" class="ps-3">Institution</th>
                                        <th scope="col" class="ps-3">Qualification</th>
                                        <th scope="col" class="ps-3">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Iqualifications as $qualification)
                                            <tr>
                                                <td class="ps-3"> {{$qualification->institution}} </td>
                                                <td class="ps-3"> {{$qualification->qualification}} </td>
                                                <td class="ps-3"> {{$qualification->date}} </td>
                                            </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!--Other Qualifications - Content-->
                        <div class="tab-pane fade" id="pills-others" role="tabpanel" aria-labelledby="pills-others-tab" tabindex="0">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="Aqualifications" style="width: 100%">
                                    <thead>
                                        <tr>
                                        <th scope="col" class="ps-3">Institution</th>
                                        <th scope="col" class="ps-3">Qualification</th>
                                        <th scope="col" class="ps-3">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($Aqualifications as $qualification)
                                            <tr>
                                                <td class="ps-3"> {{$qualification->institution}} </td>
                                                <td class="ps-3"> {{$qualification->qualification}} </td>
                                                <td class="ps-3"> {{$qualification->date}} </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @if($user->role_as == 2)
            <!--Teaching Experience-->
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header text-white bg-gradient-primary pt-3"><h4> FULAFIA Teaching Experience</h4></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="experiences">
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
                                    @foreach($experiences as $experience)
                                        <tr>
                                            <td class="text-wrap">{{ $experience->course_code }}</td>
                                            <td class="text-wrap">{{ $experience->course_title }}</td>
                                            <td class="text-wrap">{{ $experience->credit_unit }}</td>
                                            <td class="text-wrap">{{ $experience->lectures }}</td>
                                            <td class="text-wrap">{{ $experience->semester }}/{{ $experience->year }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                                    <table class="table table-striped table-hover" id="awards"  style="width: 100%">
                                        <thead>
                                            <tr>
                                            <th scope="col" class="ps-3">Award</th>
                                            <th scope="col" class="ps-3">Awarding Body</th>
                                            <th scope="col" class="ps-3">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($awards as $award)
                                                <tr>
                                                    <td class="ps-3"> {{$award->award}} </td>
                                                    <td class="ps-3"> {{$award->awarding_body}} </td>
                                                    <td class="ps-3"> {{$award->date}} </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!--Honours - Content-->
                            <div class="tab-pane fade" id="pills-honours" role="tabpanel" aria-labelledby="pills-honours-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="honours" style="width: 100%">
                                        <thead>
                                            <tr>
                                            <th scope="col" class="ps-3">Award</th>
                                            <th scope="col" class="ps-3">Awarding Body</th>
                                            <th scope="col" class="ps-3">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($honours as $award)
                                                <tr>
                                                    <td class="ps-3"> {{$award->award}} </td>
                                                    <td class="ps-3"> {{$award->awarding_body}} </td>
                                                    <td class="ps-3"> {{$award->date}} </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
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
                            <table class="table table-striped table-hover" id="memberships" style="width: 100%">
                                <thead>
                                    <tr>
                                    <th scope="col" class="ps-3">Society</th>
                                    <th scope="col" class="ps-3">Class</th>
                                    <th scope="col" class="ps-3">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($memberships as $membership)
                                        <tr>
                                            <td class="ps-3"> {{$membership->society}} </td>
                                            <td class="ps-3"> {{$membership->class}} </td>
                                            <td class="ps-3"> {{$membership->date}} </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
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
                            <table class="table table-striped table-hover" id="conferences" style="width: 100%">
                                <thead>
                                    <tr>
                                    <th scope="col" class="ps-3">Conference</th>
                                    <th scope="col" class="ps-3">Location</th>
                                    <th scope="col" class="ps-3">Paper Presented</th>
                                    <th scope="col" class="ps-3">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($conferences as $conference)
                                        <tr>
                                            <td class="ps-3"> {{$conference->conference}} </td>
                                            <td class="ps-3"> {{$conference->location}} </td>
                                            <td class="ps-3 text-wrap"> {{$conference->paper_presented}} </td>
                                            <td class="ps-3"> {{$conference->date}} </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
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
                                    <table class="table table-striped table-hover" id="researches" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">Research Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($researches as $research)
                                                <tr>
                                                    <td class="">
                                                        <small class="purple-text">Date</small>
                                                        <p class="text-purple">{{ date('d M, Y', strtotime($research->date)) }}</p>

                                                        <small class="purple-text">Topic</small>
                                                        <p>{{ $research->topic }}</p>

                                                        <small class="purple-text">Publication Number</small>
                                                        <p>{{ $research->publication_number }}</p>

                                                        <small class="purple-text">Summary</small>
                                                        <p class="text-wrap">{{ $research->summary }}</p>

                                                        <small class="purple-text">Findings</small>
                                                        <p>{{ $research->findings }}</p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!--ONGOING - Content-->
                            <div class="tab-pane fade" id="pills-ongoing" role="tabpanel" aria-labelledby="pills-ongoing-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="ongoingResearches" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">Research Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($ongoingResearches as $research)
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
                                            @endforeach
                                        </tbody>
                                    </table>
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
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-acceptedPapers-tab" data-bs-toggle="pill" data-bs-target="#pills-acceptedPapers" type="button" role="tab" aria-controls="pills-acceptedPapers" aria-selected="false">Accepted Papers</button>
                            </li>
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-submittedPapers-tab" data-bs-toggle="pill" data-bs-target="#pills-submittedPapers" type="button" role="tab" aria-controls="pills-submittedPapers" aria-selected="false">Submitted Papers</button>
                            </li>
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-creativeWorks-tab" data-bs-toggle="pill" data-bs-target="#pills-creativeWorks" type="button" role="tab" aria-controls="pills-creativeWorks" aria-selected="false">Creatve Works</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <!--MONOGRAPHS - Content-->
                            <div class="tab-pane fade show active" id="pills-monograph" role="tabpanel" aria-labelledby="pills-monograph-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="monographs" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($monographs as $monograph)
                                                <tr>
                                                    <td class="text-wrap ">
                                                        <small class="purple-text">Title (Year)</small>
                                                        <p class="text-purple">{{ $monograph->title }} ({{ $monograph->year }})</p>

                                                        <small class="purple-text">Authors</small>
                                                        <p>{{ $monograph->authors }}</p>

                                                        <small class="purple-text">Journal (Volume)</small>
                                                        <p>{{ $monograph->journal }} {{ $monograph->journal_volume }}</p>

                                                        <small class="purple-text">DOI</small>
                                                        <p>{{ $monograph->doi }}</p>

                                                        <small class="purple-text">Details</small>
                                                        <p>{{ $monograph->details }}</p>

                                                        <small class="purple-text mb-2">Abstract</small>
                                                        <p class="mt-2">
                                                            {{ $monograph->abstractFileName }}
                                                            @if ($monograph->abstractFileName)
                                                            <button class="btn btn-sm btn-gradient-primary ms-2" wire:click="downloadAbstract('{{ $monograph->abstract }}')"><i class="fas fa-cloud-download-alt"></i> Download Abstract</button>
                                                            @endif
                                                        </p>

                                                        <small class="purple-text">Evidence (Letter from the Editor)</small>
                                                        <p class="mt-2">
                                                            {{ $monograph->evidenceFileName }}
                                                            @if ($monograph->abstractFileName)
                                                            <button class="btn btn-sm btn-gradient-primary ms-2" wire:click="downloadEvidence('{{ $monograph->evidence }}')"><i class="fas fa-cloud-download-alt"></i> Download Evidence</button>
                                                            @endif
                                                        </p>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!--JOURNAL ARTICLES - Content-->
                            <div class="tab-pane fade" id="pills-articles" role="tabpanel" aria-labelledby="pills-articles-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="articles" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($articles as $publication)
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
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!--CONFERENCE PROCEEDINGS - Content-->
                            <div class="tab-pane fade" id="pills-conference" role="tabpanel" aria-labelledby="pills-conference-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="conferenceProceedings" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($conferenceProceedings as $publication)
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
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!--ACCEPTED PAPERS - Content-->
                            <div class="tab-pane fade" id="pills-acceptedPapers" role="tabpanel" aria-labelledby="pills-acceptedPapers-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="acceptedPapers" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($acceptedPapers as $paper)
                                                <tr>
                                                    <td class="text-wrap ">
                                                        <small class="purple-text">Title (Year)</small>
                                                        <p class="text-purple">{{ $paper->title }} ({{ $paper->year }})</p>

                                                        <small class="purple-text">Authors</small>
                                                        <p>{{ $paper->authors }}</p>

                                                        <small class="purple-text">Journal (Volume)</small>
                                                        <p>{{ $paper->journal }} {{ $paper->journal_volume }}</p>

                                                        <small class="purple-text mb-2">Abstract</small>
                                                        <p class="mt-2">
                                                            {{ $paper->abstractFileName }} <button class="btn btn-sm btn-gradient-primary ms-2" wire:click="downloadAbstract('{{ $paper->abstract }}')"><i class="fas fa-cloud-download-alt"></i> Download Abstract</button>
                                                        </p>

                                                        <small class="purple-text">Evidence (Letter from the Editor)</small>
                                                        <p class="mt-2">
                                                            {{ $paper->evidenceFileName }} <button class="btn btn-sm btn-gradient-primary ms-2" wire:click="downloadEvidence('{{ $paper->evidence }}')"><i class="fas fa-cloud-download-alt"></i> Download Evidence</button>
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!--SUBMITTED PAPERS - Content-->
                            <div class="tab-pane fade" id="pills-submittedPapers" role="tabpanel" aria-labelledby="pills-submittedPapers-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="submittedPapers" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($submittedPapers as $paper)
                                                <tr>
                                                    <td class="text-wrap ">
                                                        <small class="purple-text">Title (Year)</small>
                                                        <p class="text-purple">{{ $paper->title }} ({{ $paper->year }})</p>

                                                        <small class="purple-text">Authors</small>
                                                        <p>{{ $paper->authors }}</p>

                                                        <small class="purple-text">Journal (Volume)</small>
                                                        <p>{{ $paper->journal }} {{ $paper->journal_volume }}</p>

                                                        <small class="purple-text mb-2">Abstract</small>
                                                        <p class="mt-2">
                                                            {{ $paper->abstractFileName }} <button class="btn btn-sm btn-gradient-primary ms-2" wire:click="downloadAbstract('{{ $paper->abstract }}')"><i class="fas fa-cloud-download-alt"></i> Download Abstract</button>
                                                        </p>

                                                        <small class="purple-text">Evidence (Letter from the Editor)</small>
                                                        <p class="mt-2">
                                                            {{ $paper->evidenceFileName }} <button class="btn btn-sm btn-gradient-primary ms-2" wire:click="downloadEvidence('{{ $paper->evidence }}')"><i class="fas fa-cloud-download-alt"></i> Download Evidence</button>
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!--CREATIVE WORKS - Content-->
                            <div class="tab-pane fade" id="pills-creativeWorks" role="tabpanel" aria-labelledby="pills-creativeWorks-tab" tabindex="0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover" id="creativeWorks" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="ps-3">Title</th>
                                                <th scope="col" class="ps-3">Author</th>
                                                <th scope="col" class="ps-3">Category</th>
                                                <th scope="col" class="ps-3">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($creativeWorks as $creativeWork)
                                                <tr>
                                                    <td class="ps-3"> {{$creativeWork->title}} </td>
                                                    <td class="ps-3"> {{$creativeWork->author}} </td>
                                                    <td class="ps-3 text-wrap"> {{$creativeWork->category}} </td>
                                                    <td class="ps-3"> {{$creativeWork->date}} </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!--Administrations-->
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header text-white bg-gradient-primary pt-3"><h4>University Administration</h4></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="administrations" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Administration Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($administrations as $administration)
                                        <tr>
                                            <td class="text-wrap ">
                                                <small class="purple-text">Year</small>
                                                <p class="text-purple">{{ $administration->date }}</p>

                                                <small class="purple-text">Duty</small>
                                                <p>{{ $administration->duty }}</p>

                                                <small class="purple-text">Experience</small>
                                                <p>{{ $administration->experience }}</p>

                                                <small class="purple-text">Commending Officer</small>
                                                <p>{{ $administration->commending_officer }}</p>

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!--Community Services-->
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header text-white bg-gradient-primary pt-3"><h4>Community Service</h4></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="services" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($services as $service)
                                        <tr>
                                            <td class="text-wrap ">
                                                <small class="purple-text">Year</small>
                                                <p class="text-purple">{{ $service->date }}</p>

                                                <small class="purple-text">Duty</small>
                                                <p>{{ $service->duty }}</p>

                                                <small class="purple-text">Experience</small>
                                                <p>{{ $service->experience }}</p>

                                                <small class="purple-text">Commending Officer</small>
                                                <p>{{ $service->commending_officer }}</p>

                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#addStaffModal').modal('hide');
            $('#banStaffModal').modal('hide');
            $('#deleteStaffModal').modal('hide');
        });

        var modals = ['#addStaffModal', '#banStaffModal', '#deleteStaffModal'];
        modals.forEach(function(modalId) {
            $(modalId).on('hidden.bs.modal', function () {
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
            });
        });


        const tables = [
            '#experiences',
            '#awards',
            '#honours',
            '#memberships',
            '#conferences',
            '#Iqualifications',
            '#Aqualifications',
            '#researches',
            '#ongoingResearches',
            '#monographs',
            '#articles',
            '#conferenceProceedings',
            '#administrations',
            '#acceptedPapers',
            '#submittedPapers',
            '#services',
            '#creativeWorks'
            ];

        tables.forEach(tableId => {
            new DataTable(tableId);
        });
    </script>
@endsection
