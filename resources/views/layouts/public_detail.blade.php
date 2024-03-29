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

  <script src="https://kit.fontawesome.com/4c207f4e5f.js" crossorigin="anonymous"></script>
  @livewireStyles
</head>
<body id="body">

<!--
Fixed Navigation
==================================== -->
<header class="navigation fixed-top sticky-header">
  <div class="container">
    <!-- main nav -->
    <nav class="navbar navbar-expand-lg navbar-light px-0">
      <!-- logo -->
      <a class="navbar-brand logo" href="{{route('home')}}">
        <h2 class="my-primary">STAFF PORTAL</h2>
      </a>
      <!-- /logo -->
      <button class="navbar-toggler btn-white" type="button" data-toggle="collapse" data-target="#navigation"
        aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon text-white"></span>
      </button>

      <div class="collapse navbar-collapse ms-auto" id="navigation">
        <a class="btn btn-primary ms-auto" href="{{ url('/login')}}"><i class="bi bi-box-arrow-in-right"></i> Login</a>
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

 <section class="single-page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2>Staff Profile</h2>
			</div>
		</div>
	</div>
</section>



<!-- Start Our Team
		=========================================== -->
        @yield('content')



<footer id="footer" class="text-white">
  <div class="top-footer">
    <div class="container">
      <div class="row justify-content-around">
        <div class="col text-center text-white">
            LOGO
        </div>
      </div>
    </div> <!-- end container -->
  </div>
  <div class="footer-bottom">
    <h6>&copy; Copyright 2024. All rights reserved.</h6>
    <p>Federal University, Lafia</p>
    <small><a href="https://fulafia.edu.ng/" target="_blank">www.fulafia.edu.ng</a></small>
  </div>
</footer> <!-- end footer -->

@livewireScripts
@yield('scripts')

</body>
</html>
