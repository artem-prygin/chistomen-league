<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta property="og:title" content="ЭкоЛига">
    <meta property="vk:image" content="https://sun9-33.userapi.com/c858324/v858324477/1d52d1/YX9smqFyB2E.jpg"/>
    <title>@yield('title') | {{config('app.name')}}</title>
    <link rel="icon" href="{{ asset('img/logo.svg') }}" type="image/x-icon"/>

    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.fancybox.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    @auth
        @if(\Request::route()->getName() !== 'profile.show')
        <script>
            window.addEventListener('DOMContentLoaded', (event) => {
                document.body.classList.add('<?=auth()->user()->usermeta->getGroup->theme?>-bg');
            });
        </script>
            @endif
    @endauth
</head>
<body>
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}

            <img src="{{ asset('img/logo.png') }}" alt="logo" style="width: 40px">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav m-auto">
                <li class="nav-item map-link">
                    <a class="nav-link @if(\Request::route()->getName() === 'map') {{__('nav-link__active')}} @endif"
                       href="{{ route('map') }}">Карта Лиги</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(\Request::route()->getName() === 'league') {{__('nav-link__active')}} @endif"
                       href="{{ route('league') }}">Участники Лиги</a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link @if(\Request::route()->getName() === 'login') {{__('nav-link__active')}} @endif"
                           href="{{ route('login') }}">{{ __('Войти') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link @if(\Request::route()->getName() === 'register') {{__('nav-link__active')}} @endif"
                               href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle
                        @if(\Request::route()->getName() === 'profile.index') {{__('nav-link__active')}} @endif" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile.index') }}">Профиль</a>
                            <a class="dropdown-item" href="{{ route('posts.create') }}">Добавить пост</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Выйти') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<div id="app">
    <main>
        @yield('content')
    </main>
</div>


<footer class="footer">
    <p>Сделано просто и с любовью на Laravel</p>
    <p>
        Разработчик: <a href="https://vk.com/gribgribych" target="_blank">Артем Прыгин aka Гриб Грибыч</a>
    </p>
</footer>


<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
