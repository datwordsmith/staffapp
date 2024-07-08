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
</div>

@section('scripts')
    <script>
        new DataTable('#aperTable');
    </script>

@endsection
