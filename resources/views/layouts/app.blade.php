<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') {{ config('app.name', 'Auction') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <style type="text/css">
        @if(Route::currentRouteName() == 'home')
            .navbar{
                margin-bottom: 0px;
                background-color: transparent;
                border-color: transparent;
            }
            #app{
                background-image: url(./img/header.jpg);background-size: cover;background-blend-mode: overlay;background-color: rgba(0, 0, 0, 0.73);
                height: 100vh;
            }
        @endif
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    {{-- Branding Image --}}
                    @if(Route::currentRouteName() != 'home')
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <div class="col-xs-3 nopadding"><img src="{{asset('img/Icon.png')}}" class="img-responsive" style="height: 30px;"/></div><div class="col-xs-9 head-title nopadding">{{ config('app.name', 'Auction') }}&nbsp;&nbsp;<small style="font-size:14px;">Sell & &nbsp;<span style="padding-left: 25px;">Buy</span></small></div>
                    </a>
                    @endif
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}" {!! (Route::currentRouteName() == 'home')?'class="up-button"':'' !!}>Login</a></li>
                            <li><a href="{{ route('register') }}" {!! (Route::currentRouteName() == 'home')?'class="up-button"':'' !!}>Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {!! '<i class="ion-ios-contact-outline" style="font-size:20px;"></i> '. Auth::user()->firstname . "&nbsp;" .Auth::user()->lastname !!} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        {{--<a href="#">
                                            settings
                                        </a>--}}

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
        @if(Route::currentRouteName() != 'home')
            <div class="footer text-center">{{date('Y',time())}}</div>
        @endif
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield("bottom_scripts")
</body>
</html>
