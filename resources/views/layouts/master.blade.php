<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- GLOBAL MAINLY STYLES-->
    <link href="{{ asset('backend') }}/assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('backend') }}/assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="{{ asset('backend') }}/assets/vendors/line-awesome/css/line-awesome.min.css" rel="stylesheet" />
    <link href="{{ asset('backend') }}/assets/vendors/themify-icons/css/themify-icons.css" rel="stylesheet" />
    <link href="{{ asset('backend') }}/assets/vendors/animate.css/animate.min.css" rel="stylesheet" />
    <link href="{{ asset('backend') }}/assets/vendors/toastr/toastr.min.css" rel="stylesheet" />
    <link href="{{ asset('backend') }}/assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />
    <!-- PLUGINS STYLES-->
    @yield('plugin-css')
    <!-- THEME STYLES-->
    <link href="{{ asset('backend') }}/assets/css/main.min.css" rel="stylesheet" />
    <!-- PAGE LEVEL STYLES-->
    @yield('custom-css')
    <title>@yield('title')</title>
</head>
<body>
    <div class="page-wrapper">
        <!-- START HEADER-->
        <header class="header">
            <div class="page-brand">
                <a href="index-2.html">
                    <span class="brand">Wikusama Cafe</span>
                    <span class="brand-mini"></span>
                </a>
            </div>
            <div class="flexbox flex-1">
                <!-- START TOP-LEFT TOOLBAR-->
                <ul class="nav navbar-toolbar">
                    <li>
                        <a class="nav-link sidebar-toggler js-sidebar-toggler" href="javascript:;">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>
                    </li>
                </ul>
                <!-- END TOP-LEFT TOOLBAR-->

                <!-- START TOP-RIGHT TOOLBAR-->
                @include('layouts._top-navigation')
                <!-- END TOP-RIGHT TOOLBAR-->
            </div>
        </header>
        <!-- END HEADER-->

        <!-- START SIDEBAR-->
        @include('layouts._sidebar')
        <!-- END SIDEBAR-->

        <div class="content-wrapper">
            <!-- START PAGE CONTENT-->
            <div class="page-content fade-in-up">
                @yield('page-content')
            </div>
            <!-- END PAGE CONTENT-->
            <footer class="page-footer">
                <div class="font-13">2018 © <b>Adminca</b> - Save your time, choose the best</div>
                <div>
                    <a class="px-3 pl-4" href="http://themeforest.net/item/adminca-responsive-bootstrap-4-3-angular-4-admin-dashboard-template/20912589" target="_blank">Purchase</a>
                    <a class="px-3" href="http://admincast.com/adminca/documentation.html" target="_blank">Docs</a>
                </div>
                <div class="to-top"><i class="fa fa-angle-double-up"></i></div>
            </footer>
        </div>
    </div>
    
    <!-- BEGIN PAGA BACKDROPS-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div>
    <!-- END PAGA BACKDROPS-->
    
    <!-- CORE PLUGINS-->
    <script src="{{ asset('backend') }}/assets/vendors/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('backend') }}/assets/vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="{{ asset('backend') }}/assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('backend') }}/assets/vendors/metisMenu/dist/metisMenu.min.js"></script>
    <script src="{{ asset('backend') }}/assets/vendors/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="{{ asset('backend') }}/assets/vendors/jquery-idletimer/dist/idle-timer.min.js"></script>
    <script src="{{ asset('backend') }}/assets/vendors/toastr/toastr.min.js"></script>
    <script src="{{ asset('backend') }}/assets/vendors/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="{{ asset('backend') }}/assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <!-- PAGE LEVEL PLUGINS-->
    @yield('plugin-js')
    <!-- CORE SCRIPTS-->
    <script src="{{ asset('backend') }}/assets/js/app.min.js"></script>
    <!-- PAGE LEVEL SCRIPTS-->
    <script src="{{ asset('backend') }}/assets/js/scripts/dashboard_7.js"></script>
    <script>
        $(function() {
            $( "form" ).submit(function() {
                $('.preloader-backdrop').show();
            });
        });
    </script>
    @yield('custom-js')
</body>
</html>