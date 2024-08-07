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
        <a class="nav-link" data-bs-toggle="collapse" href="#profile-menu" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">My Profile</span>
          <i class="menu-arrow"></i>
          <i class="fa-regular fa-address-card menu-icon"></i>
        </a>
        <div class="collapse" id="profile-menu">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ url('staff/profile')}}">Overview</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ url('staff/interests')}}">Interests</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ url('staff/socialmedia')}}">Social Media</a></li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('staff/first_appointment')}}">
            <span class="menu-title">First Appointment</span>
            <i class="fa-solid fa-user-tie menu-icon"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('staff/current_appointment')}}">
            <span class="menu-title">Current Appointment</span>
            <i class="fa-solid fa-user-tie menu-icon"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('staff/appointments')}}">
            <span class="menu-title">Appointments</span>
            <i class="fa-solid fa-user-tie menu-icon"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#qualification-menu" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Qualifications</span>
          <i class="menu-arrow"></i>
          <i class="fas fa-certificate menu-icon"></i>
        </a>
        <div class="collapse" id="qualification-menu">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{ url('staff/initial_qualifications')}}">Before Appointment</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{ url('staff/additional_qualifications')}}">Additional Qualifications</a></li>
          </ul>
        </div>
      </li>

    @can('staff')
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#publication-menu" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Publications</span>
            <i class="menu-arrow"></i>
            <i class="fa-regular fa-newspaper menu-icon"></i>
            </a>
            <div class="collapse" id="publication-menu">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ url('staff/creative_works')}}">Creative Works</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ url('staff/accepted_papers')}}">Accepted Papers</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ url('staff/submitted_papers')}}">Submitted Papers</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ url('staff/monographs_books')}}">Monographs/Books</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ url('staff/journal_articles')}}">Journal Articles</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ url('staff/conference_proceedings')}}">Conference Proceedings</a></li>
            </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('staff/teachingexperience')}}">
                <span class="menu-title">Teaching Experience</span>
                <i class="fas fa-chalkboard-teacher menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#staff-menu" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Awards</span>
            <i class="menu-arrow"></i>
            <i class="fas fa-award menu-icon"></i>
            </a>
            <div class="collapse" id="staff-menu">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ url('staff/scholarships_prizes')}}">Scholarships and Prizes</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ url('staff/honours_distinctions')}}">Honours and Distinctions</a></li>
            </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('staff/societymemberships')}}">
                <span class="menu-title">Society Memberships</span>
                <i class="fas fa-users menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('staff/conferences')}}">
                <span class="menu-title">Conferences</span>
                <i class="fa-solid fa-users-between-lines menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#research-menu" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-title">Researches</span>
            <i class="menu-arrow"></i>
            <i class="fa-solid fa-book-open-reader menu-icon"></i>
            </a>
            <div class="collapse" id="research-menu">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ url('staff/completed_researches')}}">Completed Researches</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ url('staff/ongoing_researches')}}">Ongoing Researches</a></li>
            </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('staff/university_administration')}}">
                <span class="menu-title">University Administration</span>
                <i class="fa-solid fa-briefcase menu-icon"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('staff/community_services')}}">
                <span class="menu-title">Community Service</span>
                <i class="fa-solid fa-handshake-angle menu-icon"></i>
            </a>
        </li>
    @endcan

      <li class="nav-item">
        <a class="nav-link" href="{{ url('staff/appraisal_request')}}">
            <span class="menu-title">My APER</span>
            <i class="fa-solid fa-chart-line menu-icon"></i>
        </a>
      </li>


      @canany(['is_hod_or_hou'])
        <li class="nav-item">
            <a class="nav-link" href="{{ route('evaluationlist') }}">
                <span class="menu-title">Evaluate APER Requests</span>
                <i class="fa-solid fa-edit menu-icon"></i>
            </a>
        </li>
      @endcanany


      @canany(['is_dean_or_unitHeads'])
        <li class="nav-item">
            <a class="nav-link" href="{{ route('approvallist')}}">
                <span class="menu-title">Approve APER Requests</span>
                <i class="fa-solid fa-check-circle menu-icon"></i>
            </a>
        </li>
      @endcan

    </ul>
  </nav>
