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

        <div class="col-md-12 mb-3">
            <div class="row ">
                <div class="col-md-4">
                    <img src="{{ asset('uploads/photos/' . ($user->profile->photo ?: 'default.jpg')) }}" class="img-fluid img-thumbnail p-3 shadow" alt="Profile Photo" style="max-height: 250px;">
                </div>
                <div class="col-md-8 mt-md-0 mt-4">
                    <h2>{{$user->profile->title->name}} {{$user->profile->firstname}} {{$user->profile->lastname}} {{$user->profile->othername}}</h2>
                    <h4 class="text-muted mb-3">{{$user->profile->rank->rank}}</h4>

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
                </div>
            </div>
        </div>
    </div>

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
            <div class="col-12 mb-3 small">
                <h4 class="text-center">{{$user->staffId}} APER Report</h4>
            </div>
            <div class="col-12 mb-3 small">
                <strong>Staff: </strong>{{$user->profile->title->name}} {{$user->profile->firstname}} {{$user->profile->lastname}} {{$user->profile->othername}} ({{$user->staffId}})
            </div>
            <div class="col-12  mb-3 small">
                <strong>Appraisal Category: </strong>{{ $aper->category->category }}
            </div>
            <div class="col-12 mb-3 small">
                <strong>Evaluated By: </strong>{{ $details->appraiser->profile->title->name }} {{ $details->appraiser->profile->firstname }} {{ $details->appraiser->profile->lastname }} {{ $details->appraiser->profile->othername }}
            </div>
            <div class="col-12 mb-3 small">
                <strong>Total Score: </strong>{{ $details->grade }}
            </div>
            <div class="col-12 mb-3 small">
                <strong>Feedback: </strong>
                {{ $details?->note ?? 'N/A' }}
            </div>
        </div>

        @if (isset($staffAction))
            <div class="bg-dark-subtle">
                <div class="col-12 my-3 small">
                    <strong>Staff Action: </strong>
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
            </div>
        @endif


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
            const element = document.getElementById('aperReport');

            // Optional settings
            const options = {
                margin: [0.5, 0.5, 0.6, 0.5],
                filename:     'evaluationRecord.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
            };

            // Convert and download
            html2pdf().set(options).from(element).save();
        });
    </script>
@endsection
