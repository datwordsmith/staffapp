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
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <strong class="alert-heading">Evaluated by:</strong>
                        <p>{{ $details->appraiser->staffId }}</p>
                    </div>
                    <div class="col-md-6">
                        @if(isset($approvalDetail))
                            <div class="alert alert-{{ $approvalDetail->status_id == 4 ? 'success' : 'danger' }}">
                                Appraisal Request {{ $approvalDetail->status->name }}!
                            </div>

                            <p><strong>Feedback:</strong></p>
                            <p class="text-wrap lh-base" style="text-align: justify;">
                                {{ $approvalDetail->note }}
                            </p>
                        @else
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-sm btn-gradient-primary" data-bs-toggle="modal" data-bs-target="#approvalModal">
                                    Approve/Decline
                                </button>
                            </div>
                        @endif
                    </div>

                    <div>
                        <h3>Total Score: {{ $details->grade }}</h3>
                    </div>
                </div>

                @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
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
                    <tr><td class="text-wrap"></td><td></td><td></td><td class="text-end"><strong>Evaluated By: {{ $details->appraiser->staffId }}</strong></td></tr>
                    <tr><td class="text-wrap"></td><td></td><td></td><td class="text-end"><strong>Total Score: {{ $details->grade }}</strong></td></tr>


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
            layout: {
                topStart: {
                    buttons: ['pdf']
                }
            }
        });
    </script>
@endsection
