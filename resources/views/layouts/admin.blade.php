    <!DOCTYPE html>
    <html lang="en">
      <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="{{ asset('admin/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/assets/vendors/css/vendor.bundle.base.css') }}">

        <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/assets/css/customstyle.css') }}">
        <!-- End layout styles -->
        <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}" />
        <script src="https://kit.fontawesome.com/4c207f4e5f.js" crossorigin="anonymous"></script>
        @livewireStyles
      </head>
      <body>
        <div class="container-scroller">

          @include('layouts.inc._navbar')

          <div class="container-fluid page-body-wrapper">

            @include('layouts.inc._sidebar')

            <div class="main-panel">
                <!-- content-wrapper start -->
                <div class="content-wrapper">
                    @include('layouts.inc._header')

                    @yield('content')

                </div>
                <!-- content-wrapper ends -->

                @include('layouts.inc._footer')
            </div>
            <!-- main-panel ends -->
          </div>
          <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        <script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>

        <script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script>
        <script src="{{ asset('admin/assets/js/hoverable-collapse.js') }}"></script>
        <script src="{{ asset('admin/assets/js/misc.js') }}"></script>

        @livewireScripts
        @yield('scripts')
      </body>
    </html>
