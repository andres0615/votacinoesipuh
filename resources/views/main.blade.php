<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ipuh</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=Arimo" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('stylesheets/font-awesome/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('stylesheets/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/easy-autocomplete.css') }}">
    <link rel="stylesheet" href="{{ asset('css/easy-autocomplete.themes.css') }}">
    <script src="{{ asset('javascripts/jquery/jquery-1.12.4.min.js') }}" ></script>
    {{-- <script src="{{ asset('javascripts/jquery/jquery-1.11.1.min.js') }}" ></script> --}}
    <script>
        //var jq1111 = jQuery.noConflict( true );
    </script>
    <script src="{{ asset('javascripts/bootstrap.min.js') }}" ></script>
    <script src="{{ asset('javascripts/plugins/jquery.bootstrap-dropdown-hover.min.js') }}" ></script>
    <script src="{{ asset('javascripts/plugins/jquery-validate.js') }}" ></script>
    <script src="{{ asset('javascripts/main.js') }}" ></script>
    <script src="{{ asset('js/jquery.easy-autocomplete.js') }}" ></script>
    @yield('assets')

</head>
<body>

<div class="container">

<header style="margin-top: 1em;" >
    <div class="row">
        <div class="col-lg-6 col-md-6 col-md-12 col-xs-12 text-center visible-lg" style="top:2em;">
                <h2 style="text-shadow: 0 0.5px 0.5px #278838, 0 0.5px 0 #278838; color: #616161;"  >Iglesia Pentecostal Unida Hispana .Inc</h2>
        </div>
        <div class="col-lg-6 col-md-6 col-md-12 col-xs-12 text-center hidden-lg" >
                <h2 style="text-shadow: 0 0.5px 0.5px #278838, 0 0.5px 0 #278838; color: #616161;"  >Iglesia Pentecostal Unida Hispana .Inc</h2>
        </div>
        <div class="col-lg-6 col-md-6 col-md-12 col-xs-12">
            <div class="pull-right hidden-md hidden-xs" >
                <img src="{{ asset('img/logoipuh.png') }}" style="max-width: 150px;" />
            </div>
            <div class="visible-md visible-xs text-center" >
                <img src="{{ asset('img/logoipuh.png') }}" />
            </div>
        </div>
    </div>
</header>

<br />

@include('navbar')

@yield('content')

</div>


<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

</body>
</html>