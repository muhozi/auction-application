<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>You lost</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Cabin+Sketch" rel="stylesheet">
        <script src="https://use.fontawesome.com/8055ed19d7.js"></script>
        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #d57777;
                font-family: 'Cabin Sketch', cursive;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            a{
              color:#555;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            {{--@if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif  --}}

            <div class="content">
                <div class="title m-b-md">
                    Ooops! <br/>You have been lost my dear.<br/>
                    <small>Another time</small>
                </div>
                <div>
                    <h1><a href="https://github.com/muhozi"><i class="fa fa-github"></i></a>&nbsp;&nbsp;&nbsp;<a href="https://twitter.com/EmeryMuhozi"><i class="fa fa-twitter"></i></a></h1>

                </div>
            </div>

        </div>
    </body>
</html>
