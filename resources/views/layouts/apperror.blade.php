<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Aplikasi Absensi - PT. Indah Jaya Textile Industry</title>
        <link href="{{ asset('/assets/css/style.default.css') }}" rel="stylesheet">
        @yield('additional_style')
    </head>
    <body>
        <div class="mainwrapper">
            <div class="errortitle">
                @yield('error_content')
            </div>
        </div><!--mainwrapper-->
        <!-- Latest compiled and minified JQuery -->
        <script src="{{ asset('/assets/js/jquery-1.9.1.min.js') }}"></script>        
        <script src="{{ asset('/assets/js/jquery-migrate-1.1.1.min.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery-ui-1.9.2.min.js') }}"></script>
        <script src="{{ asset('/assets/js/modernizr.min.js') }}"></script>
        <script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.cookie.js') }}"></script>        
        <script src="{{ asset('/assets/js/custom.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.alerts.js') }}"></script>
        @stack('additional_js')
    </body>
</html>
