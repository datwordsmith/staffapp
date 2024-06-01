<div>
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
                    Appraisal Request {{ $approvalDetail->status->name }}!
                </div>
            @endif
        </div>
    </div>

    <div class="row mt-3">

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
                    <tr>
                        <td colspan="4">
                            <strong>Staff: </strong>{{$user->profile->title->name}} {{$user->profile->firstname}} {{$user->profile->lastname}} {{$user->profile->othername}} ({{$user->staffId}})
                        </td>
                        <td class="d-none"></td>
                        <td class="d-none"></td>
                        <td class="d-none"></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <strong>Appraisal Category: </strong>{{ $aper->category->category }}
                        </td>
                        <td class="d-none"></td>
                        <td class="d-none"></td>
                        <td class="d-none"></td>
                    </tr>
                    <tr>
                        <td colspan="4"><strong>Evaluated By: </strong>{{ $details->appraiser->staffId }}</td>
                        <td class="d-none"></td>
                        <td class="d-none"></td>
                        <td class="d-none"></td>
                    </tr>
                    <tr>
                        <td colspan="4"><strong>Total Score: </strong>{{ $details->grade }}</td>
                        <td class="d-none"></td>
                        <td class="d-none"></td>
                        <td class="d-none"></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <strong>Feedback: </strong>
                            <p class="text-wrap">
                                <small>
                                    {{ $approvalDetail->note }}
                                    In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available.
                                </small>
                            </p>
                        </td>
                        <td class="d-none"></td>
                        <td class="d-none"></td>
                        <td class="d-none"></td>
                    </tr>
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
