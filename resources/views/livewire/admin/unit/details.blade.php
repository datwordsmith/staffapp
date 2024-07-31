<div>

    @section('pagename')
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-sitemap menu-icon"></i>
            </span> Unit: {{ $unit->name }}
        </h3>
    @endsection

    @section('breadcrumbs')
        <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                Units
            </li>
        </ul>
        </nav>
    @endsection


    <div class="row">
        <div class="col-md-4 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-3">{{$unit->head_title}}</h3>

                    @if ($unit->head != null)
                        <h4> {{ $unit->head->profile->title->name }} {{ $unit->head->profile->lastname }} {{ $unit->head->profile->firstname }} {{ $unit->head->profile->othername }}</h4>
                        <h5 class="text-muted mb-3">{{$unit->head->profile->rank->rank}}</h5>

                        <a href="{{ url('admin/profile/'.$unit->head->staffId) }}" class="btn btn-primary btn-sm">
                            View Profile
                        </a>
                    @else
                        <p>Not Assigned.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Sub-units</h4>
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

                        <table class="table table-striped table-hover" id="subunits">
                            <thead>
                                <tr>
                                <th scope="col" class="ps-2">Sub-unit</th>
                                <th scope="col" class="ps-2">HoU</th>
                                <th scope="col" class="ps-2"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subunits as $subunit)
                                    <tr>
                                        <td class="ps-2">
                                            {{$subunit->name}}
                                        </td>
                                        <td>
                                            @if($subunit->hou_id !== null)
                                                <a href="{{ url('admin/profile/'.$subunit->hou->staffId) }}">
                                                    {{ $subunit->hou->profile->title->name }} {{ $subunit->hou->profile->lastname }} {{ $subunit->hou->profile->firstname }} {{ $subunit->hou->profile->othername }}
                                                </a>
                                            @else
                                                Not assigned
                                            @endif
                                        </td>
                                        <td class="d-flex justify-content-end">
                                            <a href="{{ route('single_subunit', ['subunitId' => $subunit->id]) }}" class="btn btn-sm btn-primary me-2">View</a>
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
        new DataTable('#subunits', {

        });
    </script>
@endsection
