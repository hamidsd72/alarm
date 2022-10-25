<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('admin/plugins/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('admin/plugins/select2/select2.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('admin/css/adminlte.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- bootstrap rtl -->
    <link rel="stylesheet" href="{{asset('admin/css/bootstrap-rtl.min.css')}}">
    
    <!-- template rtl version -->
    <link rel="stylesheet" href="{{asset('admin/css/custom-style.css')}}">
    <!-- Persian Data Picker -->
    <link rel="stylesheet" href="{{asset('admin/css/persian-datepicker.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/styles/new/style.css') }}">
    <style>
        @font-face {
            font-family: 'Vazirmatn';
            src: url({{ asset('fonts/webfonts/Vazirmatn-Light.woff2') }}); /* IE9 Compat Modes */
            src: url({{ asset('fonts/webfonts/Vazirmatn-Light.woff2') }}) format('embedded-opentype'), /* IE6-IE8 */
            url({{ asset('fonts/webfonts/Vazirmatn-Light.woff2') }}) format('woff2'), /* Super Modern Browsers */
            url({{ asset('fonts/webfonts/Vazirmatn-Light.woff2') }}) format('woff'), /* Pretty Modern Browsers */
            url({{ asset('fonts/ttf/Vazirmatn-Light.ttf') }})  format('truetype'), /* Safari, Android, iOS */
        }
        body {
            font-size: 13px;
            font-family: "Vazirmatn" !important;
            line-height: 26px !important;
            color: #6c6c6c !important;
            background-color: #f0f0f0;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .btn {
            font-weight: normal !important;
            font-family: "Vazirmatn" !important;
        }
    </style>
    @yield('css')
    <style>
        .sidebar {
            overflow-y: initial;
            padding-top: 0.5rem;
        }
        .sidebar-dark-primary , .navbar-expand , .navbar-expand .navbar-nav .dropdown-menu {
            background-color: #2F2D51 !important;
        }
        .sidebar-dark-primary .sidebar a , .sidebar-dark-primary .nav-treeview>.nav-item>.nav-link , .dropdown-item , .navbar-light .navbar-nav .nav-link {
            color: white;
        }
        #lorem a { 
            color: rgba(0, 0, 0, 0.719);
        }
        a.nav-link:hover {
            color: white !important;
        }
        .card-primary.card-outline , .res_table{
            border-radius: 20px;
        }
        .main-sidebar .brand-text, .sidebar .nav-link p, .sidebar .user-panel .info {
            color: white !important;
        }
        .footer-bar-1 .active-nav i, .footer-bar-1 .active-nav span, .footer-bar-3 .active-nav i{
            color: #2F2D51 !important;
        }
        .form-control {
            height: auto !important;
        }
        .small-box .icon {
            top: 10px;
            font-size: 60px;
        }
        .btn-info {
            background: #fe5722 !important;
        }
        .btn-danger {
            background: #20364b !important;
        }
        .bg-dark {
            background: #20364b !important;
        }
        .text-dark {
            color: #20364b !important;
        }
    </style>

</head>
<body class="">

        @include('includes.bottomNavigationBar')
        @yield('content')
    </div>

</div>

<!-- jQuery -->
<script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
{{--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>--}}
{{--<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->--}}
{{--<script>--}}
{{--    $.widget.bridge('uibutton', $.ui.button)--}}
{{--</script>--}}
<!-- Bootstrap 4 -->
<script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
{{--<!-- Morris.js charts -->--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>--}}
{{--<script src="{{asset('admin/plugins/morris/morris.min.js')}}"></script>--}}
{{--<!-- Sparkline -->--}}
{{--<script src="{{asset('admin/plugins/sparkline/jquery.sparkline.min.js')}}"></script>--}}
{{--<!-- jvectormap -->--}}
{{--<script src="{{asset('admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>--}}
{{--<script src="{{asset('admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>--}}
{{--<!-- jQuery Knob Chart -->--}}
{{--<script src="{{asset('admin/plugins/knob/jquery.knob.js')}}"></script>--}}
{{--<!-- daterangepicker -->--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>--}}
{{--<script src="{{asset('admin/plugins/daterangepicker/daterangepicker.js')}}"></script>--}}
{{--<!-- datepicker -->--}}
{{--<script src="{{asset('admin/plugins/datepicker/bootstrap-datepicker.js')}}"></script>--}}

{{--<!-- Slimscroll -->--}}
{{--<script src="{{asset('admin/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>--}}
<!-- FastClick -->
{{--<script src="{{asset('admin/plugins/fastclick/fastclick.js')}}"></script>--}}
<!-- AdminLTE App -->
<script src="{{asset('admin/js/adminlte.js')}}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{asset('admin/js/demo.js')}}"></script>
<!-- Persian Data Picker -->
<script src="{{asset('admin/js/persian-date.min.js')}}"></script>
<script src="{{asset('admin/js/persian-datepicker.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('admin/plugins/select2/select2.full.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>

<script>
    new ClipboardJS('.copy_btn');
    $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
    @if(session()->has('err_message'))
    $(document).ready(function () {
        Swal.fire({
            title: "ناموفق",
            text: "{{ session('err_message') }}",
            icon: "warning",
            timer: 6000,
            timerProgressBar: true,
        })
    });
    @endif
    @if(session()->has('err_message'))
    $(document).ready(function () {
        Swal.fire({
            title: "ناموفق",
            text: "{{ session('err_message') }}",
            icon: "warning",
            timer: 6000,
            timerProgressBar: true,
        })
    });
    @endif
    @if(session()->has('flash_message'))
    $(document).ready(function () {
        Swal.fire({
            title: "موفق",
            text: "{{ session('flash_message') }}",
            icon: "success",
            timer: 6000,
            timerProgressBar: true,
        })
    })
    ;@endif
    @if (count($errors) > 0)
    $(document).ready(function () {
        Swal.fire({
            title: "ناموفق",
            icon: "warning",
            html:
                @foreach ($errors->all() as $key => $error)
                '<p class="text-right mt-2 ml-5" dir="rtl"> {{$key+1}} : '  +
                    '{{ $error }}'+
                '</p>'+
                @endforeach
                '<p class="text-right mt-2 ml-5" dir="rtl">' +
                    '</p>',
            timer:  @if(count($errors)>3)parseInt('{{count($errors)}}') * 1500 @else 6000 @endif,
            timerProgressBar: true,
        })
    });
    @endif


    $(document).ready(function () {
        $('.numberPrice').text(function (index, value) {
            return value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });
</script>
@yield('js')
</body>
</html>
