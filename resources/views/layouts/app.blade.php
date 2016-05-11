<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Aplikasi Dokumen Manajer - PT. Indah Jaya Textile Industry</title>
        <link href="{{ asset('/assets/css/style.default.css') }}" rel="stylesheet">
        <link href="{{ asset('/assets/css/style.brown.css') }}" rel="stylesheet">
        @yield('additional_style')
    </head>
    <body>
        <div class="mainwrapper">
    
            <!-- START HEAD -->
            <div class="header">
                <div class="logo">
                    <a href="{{ url('/home') }}"><img src="{{ asset('/assets/images/logo.png') }}" alt="" /></a>
                </div>

                <!-- START HEAD INNER -->
                <div class="headerinner">
                    <!-- START HEAD MENU -->
                    <ul class="headmenu">
                        <li class="odd"></li>
                        <li class="right">
                            <div class="userloggedinfo">
                                <img src="{{ asset('/assets/images/photos/polos.png') }}" alt="" />
                                <div class="userinfo">
                                    <h5>{{{ Auth::user()->name }}} <small>- {{{ Auth::user()->type }}}</small></h5>
                                    <ul>
        <!--                                <li><a href="editprofile.html">Edit Profile</a></li>
                                        <li><a href="">Account Settings</a></li>-->
                                        <li><a href="{{ route('logout') }}">Sign Out</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul><!-- END HEAD MENU -->
                </div><!-- END HEAD INNER -->
            </div><!-- END HEAD-->
            <!-- START LEFT PANEL -->
            <div class="leftpanel">

                <!-- START LEFT MENU -->
                <div class="leftmenu">        
                    <ul class="nav nav-tabs nav-stacked">
                        <li class="nav-header">Navigation</li>
                        <!--<li><a href="{{ url('/home') }}"><span class="iconfa-laptop"></span> Dashboard</a></li>-->
                        {!! isset($menu) ? $menu : '' !!}    
                    </ul>
                </div><!-- END LEFT MENU -->
            </div><!-- END LEFT PANEL -->    <!-- START RIGHT PANEL -->
            <div class="rightpanel">

                <!-- START NAVIGATOR -->
                <ul class="breadcrumbs">
                    @yield('navigator')           
                </ul>
                <!-- END NAVIGATOR -->

                <!-- START PAGE HEADER -->
                <div class="pageheader">
                    @yield('pageheader')
                </div><!-- END PAGE HEADER -->		

                <!-- START MAIN CONTENT -->
                <div class="maincontent">
                    <!-- START MAIN CONTAINER -->
                    <div class="maincontentinner">
                        @yield('maincontent')

                        <div class="footer">
                            <div class="footer-left">
                                <span>&copy; <?php echo date("Y"); ?>. Aplikasi Dokumen Manajer - PT. Indah Jaya Textile Industry. All Rights Reserved.</span>
                            </div>
                            <div class="footer-right">
                                <span>Created by: Taufiq Hari Widodo (Ext. 383)</span>
                            </div>
                        </div><!--footer-->
                    </div><!-- START MAIN CONTAINER -->
                </div><!-- END MAINCONTENT -->

            </div><!-- END RIGHT PANEL -->

        </div><!--mainwrapper-->
        <!-- Latest compiled and minified JQuery -->
        <!--<script src="{{ asset('/assets/js/jquery-1.9.1.min.js') }}"></script>-->    
        <script src="{{ asset('/assets/js/jquery-2.2.2.min.js') }}"></script>
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
