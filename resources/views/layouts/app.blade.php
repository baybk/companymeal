<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('img/mealfav.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Quản lí tiền cơm') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        .name {
            font-size: 18px;
            color: #38c172;
            /* text-decoration-line: underline; */
            font-weight: 300;
            padding-left: 1rem;
            display: inline-block;
            margin-right: 2rem;
            width: 15rem;
        }

        .mytable {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        .mytd, .myth {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        }

        h4 {
            margin-top: 2rem;
        }

        .subtract {
            font-size: 1.5rem;
        }

        .navbarDropdown {
            padding: 5px;
            background: cornflowerblue;
            border-radius: 8px;
            margin-right: 4px;
            color: #f8fafc;
        }

        .onepeo {
            margin-bottom: 0.7rem;
            border-bottom: 1px solid #eee;
            padding-bottom: 3px;
        }

        .onecb {
            /* Double-sized Checkboxes */
            -ms-transform: scale(1.8); /* IE */
            -moz-transform: scale(1.8); /* FF */
            -webkit-transform: scale(1.8); /* Safari and Chrome */
            -o-transform: scale(1.8); /* Opera */
            transform: scale(1.8);
            padding: 10px;
            margin-right: 1rem;
        }

        .paginate {
            float: right;
            margin-top: 1rem;
        }
        .balance-total {
            display: inline-block;
            float: right;
        }

        .h5-guide {
            color: #c51f1a;
            margin-bottom: 1rem;
        }

        .onemoney {
            font-family: -webkit-pictograph;
        }

        .submit-order-1 {
            width: 60%;
            background: #1472ed;
            color: #fff;
            outline: none;
            border: none;
            display: block;
            padding: 0.7rem 0.3rem;
            border-radius: 0.3rem;
            font-size: 1rem;
            margin: 0px auto 13px auto;
        }

        .submit-order-3 {
            float: right;
            min-width: 30%;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        .submit-order-2 {
            min-width: 30%;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }
        .red {
            color:#c51f1a !important;
        }
        .linethrough {
            text-decoration: line-through !important;
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    @if (isAdminUserHelper() == 'admin')
                    <span style="color:#3490dc;"> Team: {{ getCurrentTeamhelper() ? getCurrentTeamhelper()->name : '' }} </span> <br>
                    @endif
                    <span style="font-size: 0.8rem"> Bây giờ: {{ date('d-m-Y H:i') }} </span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <a class="navbarDropdown" href="/home">Home</a>
                                @if (isAdminUserHelper() == 'admin') 
                                    <a class="navbarDropdown" href="{{ route('admin.orders2') }}">Yêu cầu trừ số dư</a>
                                    <a class="navbarDropdown" href="{{ route('register') }}">Đăng kí thêm user</a>
                                    <a style="display:none" class="navbarDropdown" href="{{ route('admin.orders') }}">Beta</a>
                                @endif

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @yield('js')
</body>
</html>
