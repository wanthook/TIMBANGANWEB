<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Snap - PT. Indah Jaya Textile Industry</title>
        <link href="{{ asset('/assets/css/style.default.css') }}" rel="stylesheet">
        <link href="{{ asset('/assets/css/style.brown.css') }}" rel="stylesheet">
    </head>
    <body class="loginpage">
        
        
    <div class="loginpanel">
        <div class="loginpanelinner">
            <div class="logo animate0 bounceIn"><img src="{{ asset('/assets/images/ijlogo.bmp') }}" alt="" />
            </div>
            <form id="login" method="post" action="{{ url('/login') }}">
                {!! csrf_field() !!}
                @if (count($errors) > 0)
                    <!--<div class="login-alert">-->
                        <div class="alert alert-error">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    <!--</div>-->
                @endif
                <div class="inputwrapper animate1 bounceIn">
                    <input type="text" name="username" id="username" placeholder="Enter your username" />
                </div>
                <div class="inputwrapper animate2 bounceIn">
                    <input type="password" name="password" id="password" placeholder="Enter your password" />
                </div>
                <div class="inputwrapper animate3 bounceIn">
                    <button name="submit">Sign In</button>
                </div>

            </form>
        </div><!--loginpanelinner-->
    </div><!--loginpanel-->
        
        <div class="loginfooter">
            <p>&copy; <?php echo date("Y"); ?>. Snap - PT. Indah Jaya Textile Industry. All Rights Reserved.</p>
        </div>
        
        <!-- Latest compiled and minified JQuery -->
        <script src="{{ asset('/assets/js/jquery-1.9.1.js') }}"></script>
        
        <script src="{{ asset('/assets/js/jquery-migrate-1.1.1.min.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery-ui-1.9.2.min.js') }}"></script>
        <script src="{{ asset('/assets/js/modernizr.min.js') }}"></script>
        <script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/assets/js/jquery.cookie.js') }}"></script>
        <script src="{{ asset('/assets/js/custom.js') }}"></script>
    </body>
</html>