<div>
    @include('livewire.staff.appraisal-request.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-address-card menu-icon"></i>
            </span> APER - Report
        </h3>
    @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
            </li>
        </ul>
        </nav>
    @endsection

    <div class="row">
        <div class="col-md-12">
            @if(isset($approvalDetail))
                <div class="alert alert-{{ $approvalDetail->status_id == 4 ? 'success' : 'danger' }}">
                    <div class="d-flex justify-content-between w-100">
                        <span>Appraisal Request {{ $approvalDetail->status->name }}!</span>
                        <button id="downloadPdf" class="btn btn-primary btn-sm"><i class="fa-solid fa-save"></i> Download</button>
                    </div>
                </div>
            @elseif (!isset($staffAction))
                <div class="alert alert-success }}">
                    <div class="d-flex justify-content-between w-100">
                        <span>Do you accept this APER evalution?</span>
                        <button class="btn btn-sm btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#acceptanceModal">
                            Accept/Reject
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="row mt-3" id="aperReport">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="row ">
                    <div class="col-md-4">
                        <img src="{{ asset('uploads/photos/' . ($user->profile->photo ?: 'default.jpg')) }}" class="img-fluid img-thumbnail p-3 shadow" alt="Profile Photo" style="max-height: 250px;">
                    </div>
                    <div class="col-md-8 mt-md-0 mt-4">
                        <h2>{{$user->profile->title->name}} {{$user->profile->firstname}} {{$user->profile->lastname}} {{$user->profile->othername}}</h2>
                        <h4 class="text-muted mb-3">{{$user->profile->rank->rank}}</h4>

                        <div class="row pt-3 border-top border-bottom mb-3">
                            <div class="col-md-3">
                                <strong class="purple-text">Staff ID</strong>
                                <p class="text-muted mt-1">{{$user->staffId}}</p>
                            </div>
                            <div class="col-md-3">
                                <strong class="purple-text">Email</strong>
                                <p class="text-muted mt-1">{{$user->email}}</p>
                            </div>
                            <div class="col-md-3">
                                <strong class="purple-text">DOB</strong>
                                <p class="text-muted mt-1">
                                    @if($user)
                                        {{$user->dob}}
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-3">
                                <strong class="purple-text">Sex</strong>
                                <p class="text-muted mt-1">
                                    @if($user)
                                        {{$user->sex}}
                                    @endif
                                </p>
                            </div>

                            @can('staff')
                                <div class="col-md-3">
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
                            @elsecan('non_academic_staff')
                                <div class="col-md-4">
                                    <strong class="purple-text">Unit</strong>
                                    <p class="text-muted mt-1">
                                        @if ($user->subunit && $user->subunit->subunit && $user->subunit->subunit->unit)
                                            {{ $user->subunit->subunit->unit->name }}
                                        @endif
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <strong class="purple-text">Sub-Unit</strong>
                                    @if ($user->subunit && $user->subunit->subunit)
                                        <p class="text-muted mt-1">{{ $user->subunit->subunit->name }}</p>
                                    @endif
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-3 small">
                <h4 class="text-center d-none d-print-block">{{$user->staffId}} APER Report</h4>
            </div>
            <!--
            <div class="col-12 mb-3 small">
                <strong>Staff: </strong>{{$user->profile->title->name}} {{$user->profile->firstname}} {{$user->profile->lastname}} {{$user->profile->othername}} ({{$user->staffId}})
            </div>
            -->
            <div class="col-12  mb-3 small">
                <strong>Appraisal Category: </strong>{{ $aper->category->category }}
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="col-12 my-3 small">
                    <strong>Evaluation Score: </strong>{{ $details->grade }}
                </div>
                <div class="col-12 mb-3 small">
                    <strong>Feedback: </strong>
                    {{ $details?->note ?? 'N/A' }}
                </div>
                <div class="col-12 mb-3 small">
                    <strong>Evaluated By: </strong>{{ $details->appraiser->profile->title->name }} {{ $details->appraiser->profile->firstname }} {{ $details->appraiser->profile->lastname }} {{ $details->appraiser->profile->othername }}
                </div>
            </div>

            <div class="col-md-4">
                @if (isset($staffAction))
                    <div class="col-12 my-3 small">
                        <strong>Staff Decision: </strong>
                        @if ($staffAction->status_id == 5)
                            <span class="badge bg-success">{{ $staffAction->status->name }}</span>
                        @elseif($staffAction->status_id == 6)
                            <span class="badge bg-danger">{{ $staffAction->status->name }}</span>
                        @else
                        @endif
                    </div>
                    <div class="col-12 mb-3 small">
                        <strong>Staff Feedback: </strong> {{ $staffAction?->note ?? 'N/A' }}
                    </div>
                    <div class="col-12 mb-3 small">
                        <strong>Staff Sign: </strong>
                    </div>
                @endif
            </div>

            <div class="col-md-4">
                @if(isset($approvalDetail))
                    <div class="col-12 my-3 small">
                        <strong>Status: </strong>
                        @if ($approvalDetail->status_id == 4)
                            <span class="badge bg-success">{{ $approvalDetail->status->name }}</span>
                        @elseif($approvalDetail->status_id == 3)
                            <span class="badge bg-danger">{{ $approvalDetail->status->name }}</span>
                        @endif
                    </div>
                    <div class="col-12 mb-3 small">
                        <strong>Approval Feedback: </strong>
                        {{ $approvalDetail?->note ?? 'N/A' }}
                    </div>
                    <div class="col-12 mb-3 small">
                        <strong>{{$approvalDetail->status->name}} By: </strong> {{ $approvalDetail->approver->profile->title->name }} {{ $approvalDetail->approver->profile->firstname }} {{ $approvalDetail->approver->profile->lastname }} {{ $approvalDetail->approver->profile->othername }}
                    </div>
                @endif
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped" id="evaluationRecord" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Evaluation</th>
                        <th>High</th>
                        <th>Score</th>
                        <th>Low</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($questions as $question)
                        <tr>
                            <td class="text-wrap">
                                <strong>{{ $question->question }}</strong>
                            </td>
                            <td class="text-wrap text-success"><small>{{ $question->high }}</small></td>

                            <td class="text-wrap">
                                {{ $details->{$question->field} }}
                            </td>

                            <td class="text-wrap text-danger"><small>{{ $question->low }}</small></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-none d-print-block">
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
                                    @if($firstAppointment->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center">No Record found</td>
                                        </tr>
                                    @else
                                        @foreach($firstAppointment as $appointment)
                                            <tr>
                                                <td class="text-wrap">{{ $appointment->rank->rank }}</td>
                                                <td class="text-wrap">{{ $appointment->grade_step }}</td>
                                                <td class="text-wrap">{{ $appointment->first_appointment }}</td>
                                                <td class="text-wrap">{{ $appointment->confirmation }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!--Appointments-->
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header text-white bg-gradient-primary pt-3"><h4>Appointment History</h4></div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="appointments">
                                <thead>
                                    <tr>
                                        <th scope="col">Post</th>
                                        <th scope="col">Salary Grade/Step</th>
                                        <th scope="col">Appointment Date</th>
                                        <th scope="col">Confirmation Date</th>
                                        <th scope="col">Last Promotion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($AppointmentHistory->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">No Records found</td>
                                        </tr>
                                    @else
                                        @foreach($AppointmentHistory as $appointment)
                                            <tr>
                                                <td class="text-wrap">{{ $appointment->post }}</td>
                                                <td class="text-wrap">{{ $appointment->grade_step }}</td>
                                                <td class="text-wrap">{{ $appointment->appointment_date }}</td>
                                                <td class="text-wrap">{{ $appointment->confirmation_date }}</td>
                                                <td class="text-wrap">{{ $appointment->last_promotion }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!--First Qualifications-->
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header text-white bg-gradient-primary pt-3"><h4>Qualifications on First Appointment</h4></div>
                    <div class="card-body">
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
                                    @if($Iqualifications->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center">No Qualifications found</td>
                                        </tr>
                                    @else
                                        @foreach ($Iqualifications as $qualification)
                                            <tr>
                                                <td class="ps-3"> {{$qualification->institution}} </td>
                                                <td class="ps-3"> {{$qualification->qualification}} </td>
                                                <td class="ps-3"> {{$qualification->date}} </td>
                                            </tr>

                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!--Other Qualifications-->
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header text-white bg-gradient-primary pt-3"><h4>Other Qualifications</h4></div>
                    <div class="card-body">
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
                                    @if($Aqualifications->isEmpty())
                                        <tr>
                                            <td colspan="3" class="text-center">No Qualifications found</td>
                                        </tr>
                                    @else
                                        @foreach ($Aqualifications as $qualification)
                                            <tr>
                                                <td class="ps-3"> {{$qualification->institution}} </td>
                                                <td class="ps-3"> {{$qualification->qualification}} </td>
                                                <td class="ps-3"> {{$qualification->date}} </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @if($user->role_as == 2)

                <!--Honours/Distinctions-->
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header text-white bg-gradient-primary pt-3"><h4>Honours/Distinctions</h4></div>
                        <div class="card-body">
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
                                        @if($honours->isEmpty())
                                            <tr>
                                                <td colspan="3" class="text-center">No Honours/Distinctions found</td>
                                            </tr>
                                        @else
                                            @foreach ($honours as $award)
                                                <tr>
                                                    <td class="ps-3"> {{$award->award}} </td>
                                                    <td class="ps-3"> {{$award->awarding_body}} </td>
                                                    <td class="ps-3"> {{$award->date}} </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
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
                                        @if($memberships->isEmpty())
                                            <tr>
                                                <td colspan="3" class="text-center">No Membership Records found</td>
                                            </tr>
                                        @else
                                            @foreach ($memberships as $membership)
                                                <tr>
                                                    <td class="ps-3"> {{$membership->society}} </td>
                                                    <td class="ps-3"> {{$membership->class}} </td>
                                                    <td class="ps-3"> {{$membership->date}} </td>
                                                </tr>
                                            @endforeach
                                        @endif
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
                                        @if($conferences->isEmpty())
                                            <tr>
                                                <td colspan="4" class="text-center">No Conferences found</td>
                                            </tr>
                                        @else
                                            @foreach ($conferences as $conference)
                                                <tr>
                                                    <td class="ps-3"> {{$conference->conference}} </td>
                                                    <td class="ps-3"> {{$conference->location}} </td>
                                                    <td class="ps-3 text-wrap"> {{$conference->paper_presented}} </td>
                                                    <td class="ps-3"> {{$conference->date}} </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Completed Researches-->
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header text-white bg-gradient-primary pt-3"><h4>Completed Researches</h4></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="researches" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Research Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($researches->isEmpty())
                                            <tr>
                                                <td class="text-center">No Completed Researches found</td>
                                            </tr>
                                        @else
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
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Ongoing Researches-->
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header text-white bg-gradient-primary pt-3"><h4>Ongoing Researches</h4></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="ongoingResearches" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Research Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($ongoingResearches->isEmpty())
                                            <tr>
                                                <td class="text-center">No Ongoing Researches found</td>
                                            </tr>
                                        @else
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
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Monographs/Books-->
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header text-white bg-gradient-primary pt-3"><h4>Monographs/Books</h4></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="monographs" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($monographs->isEmpty())
                                            <tr>
                                                <td class="text-center">No Monographs/Books found</td>
                                            </tr>
                                        @else
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
                                                        <p class="">
                                                            {{ $monograph->abstractFileName }}
                                                        </p>

                                                        <small class="purple-text">Evidence (Letter from the Editor)</small>
                                                        <p class="">
                                                            {{ $monograph->evidenceFileName }}
                                                        </p>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Journal Articles-->
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header text-white bg-gradient-primary pt-3"><h4>Journal Articles</h4></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="articles" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($articles->isEmpty())
                                            <tr>
                                                <td class="text-center">No Journal Articles found</td>
                                            </tr>
                                        @else
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
                                                        <p class="">
                                                            {{ $publication->abstractFileName }}
                                                        </p>

                                                        <small class="purple-text">Evidence (Letter from the Editor)</small>
                                                        <p class="">
                                                            {{ $publication->evidenceFileName }}
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Conference Proceedings-->
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header text-white bg-gradient-primary pt-3"><h4>Conference Proceedings</h4></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="conferenceProceedings" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($conferenceProceedings->isEmpty())
                                            <tr>
                                                <td class="text-center">No Conference Proceedings found</td>
                                            </tr>
                                        @else
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
                                                        <p class="">
                                                            {{ $publication->abstractFileName }}
                                                        </p>

                                                        <small class="purple-text">Evidence (Letter from the Editor)</small>
                                                        <p class="">
                                                            {{ $publication->evidenceFileName }}
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Accepted Papers-->
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header text-white bg-gradient-primary pt-3"><h4>Accepted Papers</h4></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="acceptedPapers" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($acceptedPapers->isEmpty())
                                            <tr>
                                                <td class="text-center">No Accepted Papers found</td>
                                            </tr>
                                        @else
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
                                                        <p class="">
                                                            {{ $paper->abstractFileName }}
                                                        </p>

                                                        <small class="purple-text">Evidence (Letter from the Editor)</small>
                                                        <p class="">
                                                            {{ $paper->evidenceFileName }}
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Submitted Papers-->
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header text-white bg-gradient-primary pt-3"><h4>Submitted Papers</h4></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="submittedPapers" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($submittedPapers->isEmpty())
                                            <tr>
                                                <td class="text-center">No Submitted Papers found</td>
                                            </tr>
                                        @else
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
                                                        <p class="">
                                                            {{ $paper->abstractFileName }}
                                                        </p>

                                                        <small class="purple-text">Evidence (Letter from the Editor)</small>
                                                        <p class="">
                                                            {{ $paper->evidenceFileName }}
                                                        </p>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Creative Works-->
                <div class="col-md-12 mb-3">
                    <div class="card">
                        <div class="card-header text-white bg-gradient-primary pt-3"><h4>Creative Works</h4></div>
                        <div class="card-body">
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
                                        @if($creativeWorks->isEmpty())
                                            <tr>
                                                <td colspan="4" class="text-center">No Creative Works found</td>
                                            </tr>
                                        @else
                                            @foreach($creativeWorks as $creativeWork)
                                                <tr>
                                                    <td class="ps-3"> {{$creativeWork->title}} </td>
                                                    <td class="ps-3"> {{$creativeWork->author}} </td>
                                                    <td class="ps-3 text-wrap"> {{$creativeWork->category}} </td>
                                                    <td class="ps-3"> {{$creativeWork->date}} </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
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
                                        @if($administrations->isEmpty())
                                            <tr>
                                                <td class="text-center">No Records found</td>
                                            </tr>
                                        @else
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
                                        @endif
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
                                        @if($services->isEmpty())
                                            <tr>
                                                <td class="text-center">No Records found</td>
                                            </tr>
                                        @else
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
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>

@section('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#acceptanceModal').modal('hide');
        });

        $('#acceptanceModal').on('hidden.bs.modal', function (e) {
            $('.modal-backdrop').remove();
        });

        new DataTable('#evaluationRecord', {
            info: false,
            ordering: false,
            paging: false,
            searching: false,
            layout: {
                topStart: {
                    // buttons: ['pdf']
                }
            }
        });

        // PDF generation script
        document.getElementById('downloadPdf').addEventListener('click', () => {
            // Temporarily show hidden elements
            const hiddenElements = document.querySelectorAll('.d-none.d-print-block');
            hiddenElements.forEach(element => element.classList.remove('d-none'));

            // Target element for PDF conversion
            const element = document.getElementById('aperReport');

            // PDF options
            const options = {
                margin:       [0.5, 0.3, 0.5, 0.3], // Margins: [top, left, bottom, right]
                filename:     'evaluationRecord.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
            };

            // Generate and download PDF
            html2pdf().set(options).from(element).save()
                .then(() => {
                    // Re-hide the elements after PDF generation
                    hiddenElements.forEach(element => element.classList.add('d-none'));
                })
                .catch(err => {
                    console.error('Error generating PDF:', err);
                });
        });

    </script>
@endsection
