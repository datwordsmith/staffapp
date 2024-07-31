<div>
    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-shape-plus menu-icon"></i>
            </span> Sub=unit: {{$subunit->name}}
        </h3>
        @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
            <span></span>Sub-units</i>
            </li>
        </ul>
        </nav>
    @endsection


    <div class="row">
        <div class="col-md-12 grid-margin ">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-2">
                    <div class="d-flex">
                        <h4 class="card-title mb-3">Non-Academic Staff</h4>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="staffTable">
                        <thead>
                            <tr>
                                <th scope="col" class="">Staff ID</th>
                                <th scope="col" class="ps-3">email</th>
                                <th scope="col" class="ps-3">Surname</th>
                                <th scope="col" class="ps-3">Firstname</th>
                                <th scope="col" class="ps-3">Title</th>
                                <th scope="col" class="ps-3 text-center">Status</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staff as $staff)
                                <tr>
                                    <td class="">
                                        {{$staff->user->staffId}}

                                    </td>
                                    <td class="ps-3"> {{$staff->user->email}} </td>
                                    <td class="ps-3"> {{$staff->user->profile->lastname}} </td>
                                    <td class="ps-3"> {{$staff->user->profile->firstname}} </td>
                                    <td class="ps-3"> {{$staff->user->profile->title->name}} </td>
                                    <td class="ps-3 text-center">
                                        @if ($staff->user->isActive)
                                            <span class="badge bg-primary">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-end">
                                        @if ($this->hasProfile($staff->user_id))
                                            <a href="{{ url('admin/profile/'.$staff->user_id) }}" class="btn btn-sm btn-primary me-2"><i class="fa-regular fa-folder-open"></i> View</a>
                                        @else
                                            <button class="btn btn-sm btn-secondary me-2 disabled"><i class="fa-regular fa-folder-open"></i> View</button>
                                        @endif
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

    <div class="row">
        <div class="col-md-12 grid-margin ">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-2">
                    <div class="d-flex">
                        <h4 class="card-title mb-3">Academic Staff</h4>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="staffTable">
                        <thead>
                            <tr>
                                <th scope="col" class="vertical-text">Staff ID</th>
                                <th scope="col" class="vertical-text">email</th>
                                <th scope="col" class="vertical-text">Fullname</th>
                                <th scope="col" class="vertical-text">Sex</th>
                                <th scope="col" class="vertical-text">Date of Birth</th>
                                <th scope="col" class="vertical-text">Current Rank</th>
                                <th scope="col" class="vertical-text">Current Salary</th>
                                <th scope="col" class="vertical-text">Date of First Appointment</th>
                                <th scope="col" class="vertical-text">Date Assumed Duty</th>
                                <th scope="col" class="vertical-text">Duty Confirmation Date</th>
                                <th scope="col" class="vertical-text">Academic Qualifications</th>
                                <th scope="col" class="vertical-text">No. of Publications</th>
                                <th scope="col" class="vertical-text">Date of Last Promotion</th>
                                <th scope="col" class="vertical-text">Evaluation/Appraisal Score</th>
                                <th scope="col" class="vertical-text">Department Appraisal</th>
                                <th scope="col" class="vertical-text">Faculty Appraisal</th>
                                <th scope="col" class="vertical-text">CAC Recommendation</th>
                                <th scope="col" class="vertical-text">A & PC Decision</th>
                                <th scope="col" class="vertical-text">Remarks</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staffdetails as $academicStaff)
                                @php
                                    $fullname = "{$academicStaff->user->profile->lastname} {$academicStaff->user->profile->firstname} {$academicStaff->user->profile->othername}";
                                @endphp
                                <tr>
                                    <td class="vertical-text">{{$academicStaff->user->staffId}}</td>
                                    <td class="vertical-text"> {{ $fullname }}</td>
                                    <td class="vertical-text"> </td>
                                    <td class="vertical-text"> {{$academicStaff->user->email}} </td>
                                    <td class="vertical-text"> {{$academicStaff->user->currentAppointment->current_appointment ?? 'Nil'}} </td>
                                    <td class="vertical-text"> </td>
                                    <td class="vertical-text"> </td>
                                    <td class="vertical-text"> </td>
                                    <td class="vertical-text"> </td>
                                    <td class="vertical-text"> </td>
                                    <td class="vertical-text"> </td>
                                    <td class="vertical-text"> </td>
                                    <td class="vertical-text"> </td>
                                    <td class="vertical-text"> </td>
                                    <td class="vertical-text"> </td>
                                    <td class="vertical-text"> </td>
                                    <td class="vertical-text"> </td>
                                    <td class="vertical-text"> </td>
                                    <td class="vertical-text"> </td>

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

@section('scripts')
    <script>
        new DataTable('#staffTable', {

        });
    </script>
@endsection
