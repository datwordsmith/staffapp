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
        <link href="{{asset('css/style.css')}}" rel="stylesheet">
        <!-- End layout styles -->
        <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}" />

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.5/css/dataTables.bootstrap5.css">

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
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.5/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.0.5/js/dataTables.bootstrap5.js"></script>

        <script src="{{ asset('admin/assets/vendors/js/vendor.bundle.base.js') }}"></script>

        <script src="{{ asset('admin/assets/js/off-canvas.js') }}"></script>
        <script src="{{ asset('admin/assets/js/hoverable-collapse.js') }}"></script>
        <script src="{{ asset('admin/assets/js/misc.js') }}"></script>

        @livewireScripts
        @yield('scripts')
      </body>
    </html>
