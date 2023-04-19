<!DOCTYPE HTML>
<html lang="fa" dir="rtl">

    @include('includes.head')

    <style>
        body {
            max-width: 540px;
            margin: auto;
        }
    </style>
    @if($pie??'')
        <style>
            .pie {
                float: right;
                width: 40px; height: 40px;
                border-radius: 50%;
                background: mediumseagreen;
                background-image:
                linear-gradient(to right, transparent 50%, red 0);
            }
            .pie::before {
                content: "";
                display: block;
                margin-left: 50%;
                height: 100%;
                border-radius: 0 100% 100% 0 / 50%;
                transform-origin: left;
                @if($pie<181)
                    background: mediumseagreen;
                    transform: rotate({{$pie}}deg);
                @elseif($pie>180)
                    background: red;
                    transform: rotate({{$pie-180}}deg); 
                @endif
            }
            .pie2 {
                position: absolute;
                right: 24px;
                margin-top: 8px;
                height: 24px;
                background: #ececec;
                padding: 0px 6px;
                border-radius: 50px;
                font-weight: bold;
            }
        </style>
    @endif

    <style>
        #mamad span:hover img {
            padding: 18px;
            transition: 0.4s;
        }
        #mamad span img {
            padding: 12px;
        }
        #perDate , #lorem-box { 
            display: none; 
        }
        .form-text img {
            position: relative;
            right: -44px;
            top: 2px;
        }
        .checkbox-boxed + .checkbox-lable .image-boxed {
            font-weight: bold;
        }
        [data-gradient=body-default] #page, .background-changer .body-default {
            background: #F3F7FA !important;
        }
        .theme-light #preloader {
            background: #F3F7FA !important;
        }
        .btn-info {
            background-color: #80D4FF;
            box-shadow: 0 3px 10px rgb(128 212 255 / 50%);
            -webkit-box-shadow: 0 3px 10px rgb(128 212 255 / 50%);
            color: white;
        }
        button.btn:hover , a.btn:hover {
            color: white !important;
        }
        body , main , .page-content {
            /* background: #F3F7FA !important; */
            background: #ececec !important;
        }
        .btn-info {
            background: #fe5722 !important;
        }
        .btn-danger {
            background: #e71717 !important;
        }
        .flex-shrink-0 h4.mb-4 {
            color: #20364b;
        }
        .flex-shrink-0 .floating-form-group > .floating-label {
            width: 100%;
        }
        .flex-shrink-0 .floating-form-group .floating-input:focus + .floating-label, .floating-form-group .floating-input:focus:active + .floating-label{
            color: #20364b;
        }
        .bg-dark {
            background: #20364b !important;
        }
        .text-dark {
            color: #20364b !important;
        }
        .balabala div {
            background: #20364b;
            color: white;
            border-radius: 16px;
        }
        .balabala div img.img-fluid {
            border-radius: 15px 15px 0px 0px;
            height: 80px;
        }
        .footer .box .fab , .footer .box .fa {
            color: #20364b !important;
        }
        #demo .splide .splide__slide img {
            height: 120px !important;
        }
        #demo .splide--draggable > .splide__track > .splide__list > .splide__slide {
            -webkit-user-select: none;
            user-select: none;
            width: 220px !important;
        }
        .runningJob {
            position: fixed;
            top: 60px;
            right: 0px;
            z-index: 99;
            border-radius: 20px 0px 0px 20px;
            padding: 2px;
            padding-left: 6px;
            background: white;
            border: 1px solid #dee2e6;
        }
        @media only screen and (min-width: 992px) {
            .runningJob {
                padding: 12px 56px;
                font-size: 16px;
                border-radius: 30px 0px 0px 30px;
            }
        }
        .card {
            box-shadow: none;
        }
        .inline-left-logo {
            float: left;
            position: relative;
            top: -42px;
            left: 2px;
        }
        .datepicker-plot-area .datepicker-day-view .month-grid-box .header {
            display: contents !important;
        }
        .datepicker-plot-area .datepicker-day-view .table-days td {
            padding: 1px;
        }
        .datepicker-plot-area .datepicker-day-view .month-grid-box .header .header-row {
            height: 28px;
        }
        .datepicker-plot-area .datepicker-day-view .table-days td span {
            border-radius: 50px;
            border: 1px solid #b8860b78;
        }
    </style>

    {{-- <body class="theme-light body-scroll d-flex flex-column h-100 menu-overlay" data-highlight="highlight-red" data-gradient="body-default"> --}}
    <body class="theme-light body-scroll d-flex flex-column h-100 menu-overlay">
        @include('includes.preLoader')
        <div id="page" >
            
            @if (auth()->user())
                @include('includes.header')
                @include('includes.bottomNavigationBar')
                <div id="offline_start_job_alert"></div>
            @endif
            @if (session()->has('message'))
                <div class="text-center p-0 m-0 mt-5 pt-4 pb-2 alert alert-{{session()->get('status') }}" role="alert">
                    {!! session()->get('message') !!}
                    <button type="button" class="close h6" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
            @elseif (session()->has('flash_message'))
                <div class="text-center p-0 m-0 mt-5 pt-4 pb-2 alert alert-success" role="alert">
                    {!! session()->get('flash_message') !!}
                    <button type="button" class="close h6" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
            @elseif (session()->has('err_message'))
                <div class="text-center p-0 m-0 mt-5 pt-4 pb-2 alert alert-danger" role="alert">
                    {!! session()->get('err_message') !!}
                    <button type="button" class="close h6" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
            @endif
            
            {{-- <div class="container-fluid h-100 loader-display">
                <div class="row h-100">
                    <div class="align-self-center col">
                        <div class="logo-loading">
                            <div class="icon icon-100 text-white mb-4">
                                <img src="{{ url(\App\Model\Setting::find(1)->icon_site) }}" alt="در حال بارگذاری">
                            </div>
                            <div class="h6">در حال بارگذاری</div>
                            <div class="loader-ellipsis">
                                <div></div>
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="page-content header-clear-medium" style="padding-top: 0px !important;">
                <main class="flex-shrink-0 pt-4">
                    @yield('content')
                </main>
            </div>
        </div>   
        @include('includes.js')
        <script src="{{asset('assets/scripts/js/sweetalert2-10.js')}}"></script>
        <script>
            setTimeout(function() { $(".alert").alert('close') }, 5000);
        
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
        </script>
    </body>
