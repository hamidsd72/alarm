<!DOCTYPE HTML>
<html lang="en" dir="rtl">

@include('includes.head')

<style>
    body {
        max-width: 540px;
        margin: auto;
    }
</style>
<style>
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
</style>

<body class="theme-light body-scroll d-flex flex-column h-100 menu-overlay" data-highlight="highlight-red" data-gradient="body-default">
@include('includes.preLoader')

<div id="page" >
    
    @if (auth()->user())
        @include('includes.header')
        @include('includes.bottomNavigationBar')
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
        <div id="offline_start_job_alert"></div>
    @endif
    
    {{-- <div class="container-fluid h-100 loader-display">
        <div class="row h-100">
            <div class="align-self-center col">
                <div class="logo-loading">
                    <div class="icon icon-100 text-white mb-4">
                        <img src="{{ asset('assets/app/icons/fav.png') }}" alt="welcome" style="width: 100px;border-radius: 50px;">
                    </div>
                    <div class="h6" style="color: #2F2D51 !important">آی مشاور</div>
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
    <script>
        setTimeout(function() { $(".alert").alert('close') }, 5000);
    </script>
</body>
  