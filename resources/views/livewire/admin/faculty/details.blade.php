<div>

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-sitemap menu-icon"></i>
            </span> Faculty: {{ $faculty->name }}
        </h3>
    @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                Faculties
            </li>
        </ul>
        </nav>
    @endsection


    <div class="row">
        <div class="col-md-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-3">Dean</h3>

                    @if ($faculty->dean != null)
                        <h4> {{ $faculty->dean->profile->title->name }} {{ $faculty->dean->profile->lastname }} {{ $faculty->dean->profile->firstname }} {{ $faculty->dean->profile->othername }}</h4>
                        <h5 class="text-muted mb-3">{{$faculty->dean->profile->rank->rank}}</h5>

                        <a href="{{ url('admin/profile/'.$faculty->dean->staffId) }}" class="btn btn-primary btn-sm">
                            View Profile
                        </a>
                    @else
                        <p>No Dean Assigned.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Departments</h4>
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

                        <table class="table table-striped table-hover" id="facultyDepartments">
                            <thead>
                                <tr>
                                <th scope="col" class="ps-2">Department</th>
                                <th scope="col" class="ps-2">HOD</th>
                                <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($departments as $department)
                                    <tr>
                                        <td class="ps-2">
                                            {{$department->name}}
                                        </td>
                                        <td>
                                            @if($department->hod_id !== null)
                                                <a href="{{ url('admin/profile/'.$department->hod->staffId) }}">
                                                    {{ $department->hod->profile->title->name }} {{ $department->hod->profile->lastname }} {{ $department->hod->profile->firstname }} {{ $department->hod->profile->othername }}
                                                </a>
                                            @else
                                                Not assigned
                                            @endif
                                        </td>
                                        <td class="d-flex justify-content-end">
                                            <a href="{{ route('department', ['departmentId' => $department->id]) }}" class="btn btn-sm btn-primary me-2">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-danger text-center">No Departments Found</td>
                                    </tr>
                                @endforelse

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
        new DataTable('#facultyDepartments', {

        });
    </script>
@endsection
