<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        
    <!-- DataTables -->
    <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script>
</head>

<body>

    <div id="app-admin">

        @include('includes.navbar')

        <div id="admin-main">

            <div id="admin-sidebar">

                <div id="admin-menu-back"></div>

                <div id="admin-menu-wrap">
                    
                    <div class="admin-sticky-menu">

                        <div class="container-fluid">
                            <div class="row align-items-center">
                                <div class="col-md-4"><img src="https://placeholdit.co//i/65x65?&bg=cccccc&fc=999999&text=PHOTO" class="img-fluid rounded-circle"></div>
                                <div class="col-md-8"><strong>{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</strong><br><span class="text-capitalize">{{ Auth::user()->roles->first()->role_name }}</span></div>
                            </div>
                        </div>

                        <div id="admin-menu">
                            @include('includes.menu')
                        </div>

                    </div>

                </div>
               
            </div>

            <div id="admin-content">
                @yield('heading')

                @yield('content')
            </div>

        </div>

    </div>

</body>
</html>
