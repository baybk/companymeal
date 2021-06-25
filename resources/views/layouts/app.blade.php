<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
            text-decoration-line: underline;
            font-weight: 300;
            padding-left: 1rem;
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
        }

        .onecb {
            /* Double-sized Checkboxes */
            -ms-transform: scale(1.8); /* IE */
            -moz-transform: scale(1.8); /* FF */
            -webkit-transform: scale(1.8); /* Safari and Chrome */
            -o-transform: scale(1.8); /* Opera */
            transform: scale(1.8);
            padding: 10px;
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
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span> Hôm nay: {{ date('d-m-Y H:i') }} </span>
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
                                @if (Auth::user()->role == 'admin') 
                                    <a class="navbarDropdown" href="/admin/orders">Order trừ số dư</a>
                                    <a class="navbarDropdown" href="/register">Đăng kí thêm user</a>
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
</body>
</html>
