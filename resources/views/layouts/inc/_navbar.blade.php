<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <a class="navbar-brand brand-logo" href="../../index.html"><i class="fa-solid fa-people-group"></i> STAFF PORTAL</a>
      <a class="navbar-brand brand-logo-mini" href="../../index.html"><i class="fa-solid fa-people-group"></i></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-stretch">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="mdi mdi-menu"></span>
      </button>

      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item font-weight-bold">

            {{ Auth::user()->staffId }}

        </li>

        <li class="nav-item">

            <a class="ps-3" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-power-off fa-lg"></i>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>


      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="mdi mdi-menu"></span>
      </button>
    </div>
  </nav>
