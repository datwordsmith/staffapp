<div>
    @include('livewire.admin.aper.modal-form')

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-address-card menu-icon"></i>
            </span> APER - Approval
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
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12 mb-3">
            @if(isset($approvalDetail))
                <div class="alert alert-{{ $approvalDetail->status_id == 4 ? 'success' : 'danger' }}">
                    <div class="d-flex justify-content-between w-100">
                        <span>Appraisal Request {{ $approvalDetail->status->name }}!</span>
                        <button id="downloadPdf" class="btn btn-primary btn-sm"><i class="fa-solid fa-save"></i> Download</button>
                    </div>
                </div>
            @else
                <div class="d-flex justify-content-end">
                    <button class="btn btn-sm btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#approvalModal">
                        Approve/Decline
                    </button>
                </div>
            @endif

            @if (session('message'))
                <div class="alert alert-success" role="alert">
                    {{ session('message') }}
                </div>
            @endif
        </div>

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
                <strong>Evaluated By: </strong>{{ $details->appraiser->staffId }}
            </div>
            <div class="col-12 mb-3 small">
                <strong>Total Score: </strong>{{ $details->grade }}
            </div>
            <div class="col-12 mb-3 small">
                <strong>Feedback: </strong>
                {{ $details->note }}
            </div>

            @if(isset($approvalDetail))
            <hr>
                <div class="col-12 mb-3 small">
                    <strong>{{$approvalDetail->status->name}} By: </strong>{{ $approvalDetail->approver->staffId }}
                </div>
                <div class="col-12 mb-3 small">
                    <strong>Approval Feedback: </strong>
                    {{ $approvalDetail->note }}
                </div>
            @endif
        </div>

        <div class="table-responsive" id="aperReport">
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
            $('#approvalModal').modal('hide');
        });

        $('#approvalModal').on('hidden.bs.modal', function (e) {
            $('.modal-backdrop').remove();
        });

        new DataTable('#evaluationRecord', {
            info: false,
            ordering: false,
            paging: false,
            searching: false,
            layout: {
                topStart: {
                    //buttons: ['pdf']
                }
            }
        });
    </script>
@endsection
