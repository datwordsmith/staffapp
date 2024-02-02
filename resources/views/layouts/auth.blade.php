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
        <style>
            body, html {
                height: 100%;
                margin: 0;
                background-color: #B66DFF20;
            }

            body {
                background-image: url('{{ asset("admin/assets/images/bkg_splash2.jpg") }}');
                background-repeat: no-repeat;
                background-size: cover;
            }

            .full-height {
                height: 100vh;
            }
        </style>
        @livewireStyles
      </head>
      <body>

        @yield('content')

        @livewireScripts
        @yield('scripts')
      </body>
    </html>
