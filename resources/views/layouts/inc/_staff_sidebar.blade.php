<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
          <div class="nav-profile-image">
            <img src="{{ asset('admin/assets/images/faces/face1.jpg') }}" alt="profile">
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
        <a class="nav-link" href="{{ url('staff/profile')}}">
            <span class="menu-title">My Profile</span>
            <i class="fa-regular fa-address-card menu-icon"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('staff/interests')}}">
            <span class="menu-title">Interests</span>
            <i class="fa-regular fa-thumbs-up menu-icon"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('staff/socialmedia')}}">
            <span class="menu-title">Social Media</span>
            <i class="fa-solid fa-hashtag menu-icon"></i>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ url('staff/publications')}}">
            <span class="menu-title">Publications</span>
            <i class="fa-regular fa-newspaper menu-icon"></i>
        </a>
      </li>

    </ul>
  </nav>