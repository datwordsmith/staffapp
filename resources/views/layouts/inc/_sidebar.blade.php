<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
          <div class="nav-profile-image">
            @if (Auth::user()->Profile && Auth::user()->Profile->photo)
                <img src="{{ asset('uploads/photos/' . Auth::user()->Profile->photo) }}" alt="profile">
            @else
                <img src="{{ asset('uploads/photos/default.jpg') }}" alt="profile">
            @endif
            <span class="login-status online"></span>
            <!--change to offline or busy as needed-->
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2">{{ Auth::user()->staffId }}</span>
            <span class="text-secondary text-small text-wrap">{{ Auth::user()->email }}</span>
          </div>
          {{-- <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i> --}}
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#staff-menu" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Staff</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-account-group menu-icon"></i>
        </a>
        <div class="collapse" id="staff-menu">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ route('academicstaff') }}">Academic Staff</a></li>
            {{-- <li class="nav-item"> <a class="nav-link" href="">Non-academic Staff</a></li> --}}
            <li class="nav-item"> <a class="nav-link" href="{{ route('non-academic-staff') }}">Non-academic Staff</a></li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/titles')}}">
          <span class="menu-title">Titles</span>
          <i class="mdi mdi-contacts menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/ranks')}}">
          <span class="menu-title">Ranks</span>
          <i class="mdi mdi-chevron-triple-up menu-icon"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#units-menu" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Units</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-sitemap menu-icon"></i>
        </a>
        <div class="collapse" id="units-menu">
          <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="{{ route('allunits')}}">Units</a></li>
              <li class="nav-item"> <a class="nav-link" href="{{ route('sub_units') }}">Sub Units</a></li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#faculty-menu" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Faculties</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-sitemap menu-icon"></i>
        </a>
        <div class="collapse" id="faculty-menu">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ url('admin/faculties')}}">Faculties</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ url('admin/departments')}}">Departments</a></li>
            {{-- <li class="nav-item"> <a class="nav-link" href="{{ url('admin/programmes')}}">Programmes</a></li> --}}
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/social_media')}}">
          <span class="menu-title">Social Media</span>
          <i class="fa-solid fa-hashtag menu-icon"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('admin/appraisal_requests')}}">
          <span class="menu-title">Appraisal Requests</span>
          <i class="fa-solid fa-chart-line menu-icon"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="">
          <span class="menu-title">Portal Admin</span>
          <i class="fa-solid fa-users-gear menu-icon"></i>
        </a>
      </li>




    </ul>
  </nav>
