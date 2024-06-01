<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Fulafia | Staff Portal</title>

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/assets/images/favicon.png') }}" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="{{ asset('admin/assets/css/allstaff.css') }}">

  <link href="{{asset('css/style.css')}}" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/3.0.2/css/buttons.bootstrap5.css">

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.3/css/all.min.css">

  @livewireStyles
</head>
<body id="body">

<!--
Fixed Navigation
==================================== -->
<header class="navigation fixed-top">
  <div class="container">

    <!-- main nav -->
    <nav class="navbar navbar-expand-lg navbar-light px-0">
      <!-- logo -->
      <a class="navbar-brand logo" href="{{route('home')}}">
        <h2 class="my-primary">STAFF PORTAL</h2>
      </a>
      <!-- /logo -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse ms-auto" id="navigation">
        <ul class="navbar-nav ms-auto">
            @auth
                <li class="nav-item">
                    @can('superadmin')
                    <a class="btn btn-success" href="{{url('admin/academicstaff')}}"><i class="bi bi-person"></i> Dashboard</a>
                    @elsecan('admin')
                    <a class="btn btn-success" href="{{url('admin/academicstaff')}}"><i class="bi bi-person"></i> Dashboard</a>
                    @elsecan('staff')
                        <a class="btn btn-info" href="{{ url('staff/profile') }}"><i class="bi bi-person"></i> My Profile</a>
                    @elsecan('non_academic_staff')
                        <a class="btn btn-info" href="{{ url('staff/profile') }}"><i class="bi bi-person"></i> My Profile</a>
                    @endcan

                    <button type="button" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger">
                        <i class="bi bi-power"></i>
                    </button>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @else
                <li class="nav-item">
                    <a class="btn btn-primary ms-auto" href="{{ url('/login') }}"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                </li>
            @endauth
        </ul>
      </div>
    </nav>
    <!-- /main nav -->
  </div>
</header>
<!--
End Fixed Navigation
==================================== -->

 <!--
Welcome Slider
==================================== -->

<!---->
<section class="hero-area">
    <div class="container text-white">
        <div class="row">
            <div class="col-12 col-lg-6">
               <h1>Welcome to the Staff Portal</h1>
               <p class="pt-5">Lorem ipsum dolor sit amet. Est minima iusto qui quisquam suscipit aut doloremque eligendi sit velit reiciendis ab magni error et enim numquam qui voluptas beatae. Est autem iusto id Quis repellendus hic illo consequuntur nam consequatur consequatur.</p>
               <div class="pt-2">
                   <a class="btn btn-primary" href="https://fulafia.edu.ng/" target="_blank"><i class="bi bi-browser-edge"></i> University Website</a>
               </div>
            </div>
        </div>
    </div>
</section>

 <!--
 <section class="single-page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2>About Us</h2>
			</div>
		</div>
	</div>
</section>
-->


<!-- Start Our Team
		=========================================== -->
        @yield('content')



<footer id="footer" class="text-white">

  <div class="footer-bottom">
    <h6>&copy; Copyright 2024. All rights reserved.</h6>
    <p>Federal University, Lafia</p>
    <small><a href="https://fulafia.edu.ng/" target="_blank">www.fulafia.edu.ng</a></small>
  </div>
</footer> <!-- end footer -->

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap5.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>

    <script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>

    <script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('admin/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('admin/assets/js/misc.js') }}"></script>

    @livewireScripts
    @yield('scripts')

</body>
</html>
