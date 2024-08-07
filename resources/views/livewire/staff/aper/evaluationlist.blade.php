<div>

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-thumbs-up menu-icon"></i>
            </span> Annual Performance Evaluation Request
        </h3>
        @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
            <span></span></i>
            </li>
        </ul>
        </nav>
    @endsection


    @section('subheader')
        <small class="purple-text"></small>
    @endsection

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
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
                        <div class="d-flex justify-content-end">
                            <button id="getReport" class="btn btn-primary btn-sm mb-2"><i class="fa-solid fa-save"></i> Download Report</button>
                        </div>

                        <table class="table table-striped table-hover" id="aperTable" style="width: 100%">
                            <thead>
                                <tr>

                                    <th scope="col" class="">Staff</th>
                                    <th scope="col" class="">Category</th>
                                    <th scope="col" class="text-center">Evaluation Grade</th>
                                    <th scope="col" class="text-center">Staff Decision</th>
                                    <th scope="col" class="text-center">Approval Status</th>
                                    <th scope="col">Date Submitted</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($apers as $aper)
                                    <tr>
                                        <td>{{ $aper->staffId }} - {{ $aper->title }}  {{ $aper->lastname }} {{$aper->firstname}}</td>
                                        <td>{{ $aper->category->category }}</td>
                                        <td class="text-center">{{ $aper->evaluation ? $aper->evaluation->grade : '-' }}</td>
                                        <td class="text-center">
                                            {{ $aper->acceptance?->status->name ?? '-' }}
                                        </td>
                                        <td class="text-center">
                                            {{ $aper->approval?->status->name ?? '-' }}
                                        </td>
                                        <td>{{ $aper->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <div class="d-flex justify-content-end">
                                                @if($aper->evaluation)
                                                    <a href="{{ route('staffaperreport', ['aperId' => $aper->id]) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa-solid fa-folder-open"></i> View
                                                    </a>
                                                @else
                                                    <a href="{{ route('evaluate_aper', ['aperId' => $aper->id]) }}" class="btn btn-sm btn-primary">
                                                        <i class="fa-solid fa-folder-open"></i> Evaluate
                                                    </a>
                                                @endif
                                            </div>
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

    <div class="row d-none" id="aperReport">
        <div class="col-md-12 grid-margin ">
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-2">
                    <div class="d-flex">
                        <h4 class="card-title mb-3">APER REPORT</h4>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="reportTable">
                        <thead>
                            <tr>
                                <th colspan="19" class="text-center">Federal University of Lafia</th>
                            </tr>
                            <tr>
                                <th colspan="19" class="text-center">{{$currentYear}} Appraisal Summary Sheet</th>
                            </tr>
                            <tr>
                                <th colspan="19" class="text-center">
                                    @can('staff')
                                        <strong>Department:</strong> {{ $admin->department->department->name}}
                                    @elsecan('non_academic_staff')
                                        <strong>Sub-unit:</strong> {{ $admin->subunit->subunit->name}}
                                    @endcan
                                </th>
                            </tr>
                            <tr>
                                <th colspan="19" class="text-center">
                                    @can('staff')
                                        <strong>Faculty:</strong> {{ $admin->department->department->faculty->name}}</th>
                                    @elsecan('non_academic_staff')
                                        <strong>Unit:</strong> {{ $admin->subunit->subunit->unit->name}}
                                    @endcan
                            </tr>

                            <tr>
                                @foreach(['Staff ID', 'Fullname', 'Email', 'Sex', 'Date of Birth', 'Current Rank', 'Current Salary Grade', 'First Appointment', 'Date Assumed Duty', 'Duty Confirmation Date', 'Academic Qualifications', 'No. of Publications', 'Date of Last Promotion', 'Evaluation/Appraisal Score', 'Department Appraisal', 'Faculty Appraisal', 'CAC Recommendation', 'A & PC Decision', 'Remarks'] as $header)
                                    <th scope="col" class="fixed-width">{{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staffdetails as $details)
                                @php
                                    $fullname = "{$details->profile->lastname} {$details->profile->firstname} {$details->profile->othername}";
                                @endphp
                                <tr>
                                    <td>{{ $details->staffId }}</td>
                                    <td>{{ $fullname }}</td>
                                    <td>{{ $details->email }}</td>
                                    <td>{{ $details->profile->sex ?? '' }}</td>
                                    <td>{{ $details->profile->dob }}</td>
                                    <td>{{ $details->currentAppointment->rank->rank ?? 'Nil' }}</td>
                                    <td>{{ $details->currentAppointment->grade_step ?? 'Nil' }}</td>
                                    <td>{{ $details->firstAppointment->rank->rank ?? 'Nil' }}</td>
                                    <td>{{ $details->firstAppointment->first_appointment ?? 'Nil' }}</td>
                                    <td>{{ $details->firstAppointment->confirmation ?? 'Nil' }}</td>
                                    <td>
                                        @foreach ($details->initialQualifications as $iquals)
                                            <p class="inside-list"><small>{{ $iquals->qualification }} - {{ $iquals->date }}</small></p>
                                        @endforeach
                                        @foreach ($details->additionalQualifications as $aquals)
                                            <p class="inside-list"><small>{{ $aquals->qualification }} - {{ $aquals->date }}</small></p>
                                        @endforeach
                                    </td>
                                    <td>
                                        <p class="inside-list"><small>Creative Works - {{ $details->creativeWorks->count() }}</small></p>
                                        <p class="inside-list"><small>Accepted Papers - {{ $details->journalPapers->where('isSubmitted', 0)->count() }}</small></p>
                                        <p class="inside-list"><small>Monographs/Books - {{ $details->staffPublications->where('category_id', 1)->count() }}</small></p>
                                        <p class="inside-list"><small>Journals - {{ $details->staffPublications->where('category_id', 2)->count() }}</small></p>
                                        <p class="inside-list"><small>Conferences - {{ $details->staffPublications->where('category_id', 3)->count() }}</small></p>
                                    </td>
                                    <td>{{ $details->Appointment->sortByDesc('appointment_date')->first()->last_promotion ?? 'Nil' }}</td>
                                    <td>
                                        <p class="inside-list"><small>Date - {{ $details->appraisalRequests->sortByDesc('created_at')->first()->created_at->format('d M, Y') ?? 'Nil' }}</small></p>
                                        <p class="inside-list"><small>Score - {{ $details->appraisalRequests->sortByDesc('created_at')->first()->evaluation->grade ?? 'Pending' }}</small></p>
                                    </td>
                                    <td>{{ $details->appraisalRequests->sortByDesc('created_at')->first()->evaluation->note ?? 'Nil' }}</td>
                                    <td>{{ $details->appraisalRequests->sortByDesc('created_at')->first()->approval->note ?? 'Nil' }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
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

        $(document).ready(function() {
            const aperTable = new DataTable('#aperTable');
            const reportTable = new DataTable('#reportTable', {
                layout: {
                    topStart: {
                        buttons: ['excel', 'print']
                    }
                }
            });

            $('#getReport').on('click', function() {
                // Trigger the Excel button click
                reportTable.button('.buttons-excel').trigger();
            });
        });

    </script>

@endsection
