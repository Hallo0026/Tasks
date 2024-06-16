<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <html data-bs-theme="dark">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/sidebar.js'])

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/sidebar.css', 'resources/css/animations.css', 'resources/css/task_sidebar.css'])

</head>
<body>
    <div id="app">
        <!--<nav class="navbar navbar-expand-md default-background-color shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav me-auto">

                    </ul>

                    <ul class="navbar-nav ms-auto">

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
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
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
        </nav>-->

        @auth

            <div class="wrapper">

                <!--<aside id="sidebar" class="expand">
                    <div class="d-flex">
                        <button id="toggle-btn" type="button">
                            <img src="{{ asset('/storage/img/grid-alt.svg') }}">
                        </button>

                        <div class="sidebar-logo">
                            <a href="#">
                                {{ config('app.name', 'Laravel') }}
                            </a>
                        </div>
                    </div>

                    <ul class="sidebar-nav">


                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                                <img src="{{ asset('/storage/img/circle-plus.svg') }}" style="width: 22px;height: 22px;">
                                <span style="color: orangered;">Nova tarefa</span>
                            </a>
                        </li>


                        <li class="sidebar-item">

                            <a href="#" class="sidebar-link has-dropdown collapsed" data-bs-toggle="collapse" data-bs-target="#home" aria-expanded="false" aria-controls="home">
                                <img src="{{ asset('/storage/img/home.svg') }}">
                                <span>Home</span>
                            </a>

                            <ul id="home" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                                <li class="sidebar-item">
                                    <a href="#" class="sidebar-link">
                                        <img src="{{ asset('/storage/img/home.svg') }}">
                                        <span>Home 2</span>
                                    </a>
                                </li>
                            </ul>

                        </li>


                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">
                                <img src="{{ asset('/storage/img/home.svg') }}">
                                <span>Grupos</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">
                                <img src="{{ asset('/storage/img/home.svg') }}">
                                <span>Tags</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">
                                <img src="{{ asset('/storage/img/home.svg') }}">
                                <span>Hoje</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">
                                <img src="{{ asset('/storage/img/home.svg') }}">
                                <span>Próximos dias</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">
                                <img src="{{ asset('/storage/img/home.svg') }}">
                                <span>Concluídas</span>
                            </a>
                        </li>

                    </ul>

                    <div class="sidebar-footer">
                        <a class="sidebar-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <img src="{{ asset('/storage/img/exit.svg') }}">
                            <span>Logout</span>
                        </a>
                    </div>

                </aside>-->

                <sidebar-component app-name="{{ config('app.name', 'Laravel') }}" user-id="{{ Auth::user()->id }}"></sidebar-component>

                <div class="main p-3">
                    @yield('content')
                </div>

            </div>

        @endauth


        @guest
            <main class="py-4">
                @yield('content')
            </main>
        @endguest

        <!--<div class="main-footer default-background-color shadow-md">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div>© 2021 <a href="https://laravel.com">Laravel</a>. All rights reserved.</div>
                    </div>
                </div>
            </div>
        </div>-->

    </div> <!-- app -->

</body>
</html>
