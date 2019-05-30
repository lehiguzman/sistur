<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistur') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/jquery.backstretch.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(e) {          
            $(".prueba").backstretch([
                { url: '{{ url('/') }}/img/fondo/fondo1.jpg' },
                { url: '{{ url('/') }}/img/fondo/fondo2.jpg' },
                { url: '{{ url('/') }}/img/fondo/fondo3.jpg' },
                { url: '{{ url('/') }}/img/fondo/fondo4.jpg' }
                ], {                    
                    fade: 1500,
                    duration: 3000
                });
        });
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body class="prueba">
    <div id="app">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
