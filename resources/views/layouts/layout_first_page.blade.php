<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
	@include('includes.head')

    <link rel="stylesheet" href="{{ asset('assets/styles/css/reset.css')}}" />
	<link rel="stylesheet" href="{{ asset('assets/styles/css/animate.min.css')}}" />
	<link rel="stylesheet" href="{{ asset('assets/styles/css/bootstrap.css')}}" />
	<link rel="stylesheet" href="{{ asset('assets/styles/css/style.css')}}" />
	<link rel="stylesheet" href="{{ asset('assets/styles/css/owl.carousel.css')}}" />
	<link rel="stylesheet" href="{{ asset('assets/styles/css/settings.css')}}" />
	<link rel="stylesheet" href="{{ asset('assets/styles/css/prettyPhoto.css')}}" />
	<link rel="stylesheet" href="{{ asset('assets/styles/css/responsive.css')}}" />

    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body data-spy="scroll" data-target=".nav-menu" data-offset="50">


    @yield('content')


    <!-- JS Files -->
	
	
	<script type="text/javascript" src="{{ asset('assets/scripts/js/jquery-1.10.2.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/bootstrap.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/jquery.appear.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/scripts/js/jquery.countTo.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/waypoints.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/jquery.prettyPhoto.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/modernizr-latest.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/SmoothScroll.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/jquery.parallax-1.1.3.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/jquery.easing.1.3.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/jquery.sticky.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/owl.carousel.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/jquery.isotope.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/rev-slider/jquery.themepunch.plugins.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/scripts/js/rev-slider/jquery.themepunch.revolution.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/scripts.js')}}"></script>

	<!-- End JS Files -->

</body>
</html>
