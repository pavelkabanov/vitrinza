<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'Laravel') }} – 

        @yield('title')
    </title>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">

    <!-- Scripts -->
    
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};

        window.vitrinza = {
            url: '{{ config('app.url') }}',
            user: {
                id: {{ Auth::check() ? Auth::user()->id : 'null' }},
                authenticated: {{ Auth::check() ? 'true' : 'false' }}
            }
        };
    </script>
</head>

<body>

    @include ('layouts.partials._analytics')

    <div id="app">

        <div class="top">
            <div class="logo">
                <a href="{{ url('/') }}"><span>Vitrinza</span></a>
            </div>

            <div class="logins">
                @if (Auth::guest())
                    <div class="user-sign">
                        <span class="glyphicon glyphicon-user dropbtn"></span>

                        <div class="top-dropdown dropdown-categories">
                            <a href="{{ url('/login') }}">Войти</a>
                            <a href="{{ url('/register') }}">Регистрация</a>
                        </div>
                    </div>
                    
                    <div class="list">
                        <a href="{{ url('/login') }}"><span class="glyphicon glyphicon-log-in"></span>Войти</a>
                        <a href="{{ url('/register') }}"><span class="glyphicon glyphicon-user"></span>Регистрация</a>
                    </div>
                @else
                    <div class="user-sign">
                        <a href="{{ url('/home') }}"><span class="glyphicon glyphicon-user dropbtn"></span></a>
                    </div>

                    <div class="list">
                        <a href="{{ url('/home') }}"><span class="glyphicon glyphicon-user"></span>Мой профиль</a>
                    </div>
                @endif
                
            </div>

            <div class="categories">
                <a href="#" onclick="event.preventDefault()" class="dropbtn">Категории<span class="glyphicon glyphicon-menu-down dropbtn"></span></a>
                
                <span class="glyphicon glyphicon-menu-hamburger categories-hamburger dropbtn"></span>
            
                <div class="top-dropdown dropdown-categories">
                    @foreach ($categories as $category)
                        <a href="{{ url('/category/' . $category->slug) }}">{{ $category->title }}</a>
                    @endforeach
                </div>
            
            </div>

            <div class="search">
                <input placeholder="Поиск ...">

                <div class="search-sign">
                    <span class="glyphicon glyphicon-search dropbtn"></span>
                    <div class="top-dropdown dropdown-search">
                        <input placeholder="Поиск ...">
                    </div>
                </div>
            </div>

        </div>

        @include ('layouts.partials._notifications')

        @yield('content')

        <div class="bottom" style="position: absolute; bottom: 0; width: 100%;">
            <div class="trademark">
                2017 {{ config('app.name') }}
            </div>
        </div>
        
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>

    <script type="text/javascript" src="{{ URL::asset('js/top-dropdowns.js') }}"></script>

    @yield('js-scripts')
</body>
</html>
