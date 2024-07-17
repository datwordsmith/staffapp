<div>

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="fa-regular fa-address-card menu-icon"></i>
            </span> APER - Evaluation
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
                <div class="alert alert-light d-flex justify-content-between align-items-center" role="alert">
                    <div>
                        <strong class="alert-heading">Key:</strong>
                        <p>5=Excellent,  4=Very Good,  3=Good,  2=Fair,  1=Poor</p>
                    </div>
                    <div>

                        <h1 class="display-4">Total Score: {{ $sumOfValues }}</h1>

                    </div>
                </div>
                @if(!$pendingEvaluation)
                    <form wire:submit="storeEvaluation">

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <th></th>
                                    <th></th>
                                    <th>5</th>
                                    <th>4</th>
                                    <th>3</th>
                                    <th>2</th>
                                    <th>1</th>
                                    <th>N/A</th>
                                    <th></th>
                                </thead>

                                <tbody>
                                    @foreach($questions as $question)
                                        <tr>
                                            <td class="text-wrap">
                                                <strong>{{ $question->question }}</strong>
                                            </td>
                                            <td class="text-wrap text-success"><small>{{ $question->high }}</small></td>
                                            @for ($i = 5; $i >= 1; $i--)
                                                <td class="text-wrap">
                                                    <input class="form-check-input" type="radio" id="{{ $question->field . $i }}" name="{{ $question->field }}" value="{{ $i }}" wire:model.live="{{ $question->field }}" required>
                                                </td>
                                            @endfor
                                            @if($question->optional)
                                                <td class="text-wrap">
                                                    <input class="form-check-input" type="radio" id="{{ $question->field . $i }}" name="{{ $question->field }}" value="0" wire:model.live="{{ $question->field }}">
                                                </td>
                                            @else
                                                <td>

                                                </td>
                                            @endif
                                            <td class="text-wrap text-danger"><small>{{ $question->low }}</small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group mt-4">
                            <label class="fw-bold">Feedback/Recommendations</label>
                            <textarea class="form-control" wire:model="note" style="height: 100px" required></textarea>
                            @error('note') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="alert alert-success d-flex justify-content-between align-items-center" role="alert">
                            <div>
                                <strong class="alert-heading">Key:</strong>
                                <p>5=Excellent,  4=Very Good,  3=Good,  2=Fair,  1=Poor</p>
                            </div>
                            <div>
                                <h4 class="">Total Score: {{ $sumOfValues }}</h4>
                            </div>
                        </div>

                        <div class="d-flex mt-3 justify-content-end">
                            <div class="">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>


                    </form>
                @endif

                @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                @endif
        </div>
    </div>
</div>

@section('scripts')
    <script>

    </script>
@endsection
