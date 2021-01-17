<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
       [v-cloak] {display: none}
    </style>
</head>
<body>
    <div id="app">
        
        @include('partials._navbar')       

        <div class="flex flex-col mt-16"> 
            <main class="min-h-screen flex-1 w-full mx-auto py-10" style="max-width:1280px">                
                @if(auth()->check())
                    @if (!auth()->user()->hasVerifiedEmail()) 
                        @include('partials._verify-notification') 
                    @endif    
                    
                    @if (!auth()->user()->settingsCompleted)
                        @include('partials._complete-settings-notification')    
                    @endif
                @endif
                
                @yield('content')
            </main>

            @include('partials._footer')
        </div>

        <flash message="{{ session('flash') }}"></flash>
        <loading></loading>
        @include('partials._modals')
    </div>
</body>
</html>
