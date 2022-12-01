<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">
    <title>DBMS - Monitoring & Maintains</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css')}}">
    <link rel="stylesheet"
          href="{{ asset('assets/plugins/select2/css/select2.min.css')}}">

    <link rel="stylesheet"
          href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet"
          href="{{ asset('assets/plugins/fontawesome/css/all.min.css')}}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">


    @viteReactRefresh
    @vite('resources/js/app.jsx')
</head>

<body class="expanded-menu">
<div id="global-loader">
    <div class="whirly-loader"></div>
</div>

<noscript>
    <div class="main-wrapper">
        <div class="error-box">
            <h1>500</h1>
            <h3 class="h2 mb-3"><i class="fas fa-exclamation-circle"></i>Internal Browser Error</h3>
            <p class="h4 font-weight-normal">Enable Javascript to use this website.</p>
        </div>
    </div>
</noscript>

<div id="root" class="main-wrapper"></div>

<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
