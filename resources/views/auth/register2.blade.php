@extends('layouts.app')
@section('content')
<style>
    body {
        max-width: 100%;
    }
    .main-page-guest {
        max-width: 1380px;
    }
    .page-content {
        padding-top: 0px !important;
    }
    .page-content .header-clear-medium {
        padding-top: 0px !important;
    }
    .home-guest .head p {
        line-height: 1.5;
        margin-bottom: 16px !important;
    }
    .head-c p {
        text-align: justify !important;
        line-height: 28px;
        font-size: 14px;
    }
    .home-guest .foter p {
        color: white !important;
        text-align: center !important;
        max-width: 887px;
        margin: auto;
        font-size: 15px !important;
    }
    .home-guest-big .foter p {
        color: white !important;
        text-align: center !important;
        margin-bottom: 0px;
    }
    .home-guest #demo2 .carousel-inner .carousel-item img {
        width: 100%;
        height: 480px;
        border-radius: 20px;
    }
    .home-guest #demo2 .carousel-caption {
        position: absolute;
        right: 40px;
        bottom: 40px;
        color: #fff;
        text-align: center;
        background: #00000090;
        background: ##428754;
        border-radius: 20px;
        width: 360px;
        height: 70px;
    }
    .home-guest #demo2 .carousel-caption h4 {
        font-size: 24px;
        font-weight: bold;
    }
    .home-guest #title-one p {
        text-align: right !important;
    }
    .home-guest #text_rule p {
        text-align: justify !important;
        color: white !important;
        font-size: 18px !important;
    }
    .home-guest-big #text_rule p {
        /* text-align: center !important; */
        color: white !important;
        font-size: 14px !important;
    }
    #navigation { 
        position: fixed;
        background: #2f665f;
        width: 100%;
        z-index: 99;
    }
    .nav-99 {
        z-index: 99;
    }
    .home-guest #navigation li {
        padding: 4px 10px;
        margin: 0px 8px;
        border-radius: 10px;
        /* background: white; */
    }
    .bg-custom-green {
        background: #2f665f!important;
    }
    .bg-custom-green {
        background: #2f665f !important;
    }
    .home-guest #navigation a {
        color: white !important;
        /* color: #2f665f !important; */
        font-weight: bold;
    }
    .home-guest-big .navigation {
        position: fixed;
        width: 100%;
        padding: 12px 2px;
    }
    .home-guest-big .navigation a {
        padding: 4px 10px;
        margin: 0px 8px;
        border-radius: 10px;
        background: white;
        color: #2f665f !important;
        font-weight: bold;
    }
    .logo-custom-one {
        position: absolute;
        left: 30px;
        top: 6px;
    }
    .logo-custom-one-sm {
        position: absolute;
        left: 10px;
        top: 0px;
    }
    .logo-custom-one img {
        width: 60px;
    }
    .logo-custom-one-sm img {
        width: 46px;
    }
    #demo .carousel-inner .carousel-item img {
        height: 180px;
    }
    #serviceCat div.card-style img {
        max-height: 180px; 
    }
    .carousel-inner {
        border-radius: 30px;
    }
</style>

    <div class="home-guest d-none d-lg-block">
        
        <section id="navigation" class="shadow" >
            <div class="content navigation">
                <div class="nav-menu">
                    <ul class="nav main-nav">
                        <li class="active"><a class="scroll" href="#slider-one">تازه ها</a></li>
                        <li><a class="scroll" href="#i-moshaver">آی مشاور</a></li>
                        {{-- <li><a class="scroll" href="#title-one">درباره ما</a></li> --}}
                        <li><a class="scroll" href="#text_rule">درباره ما ۲</a></li>
                        <li><a class="scroll" href="#serviceCat">کارکاه ها</a></li>
                        <li><a class="scroll" href="#foter">تماس با ما</a></li>
                        <li><a href="{{route('user.home-guost-pwa')}}" class="" > راهنمای نصب اپلیکیشن</a></li>
                    </ul>
                    <div class="logo-custom-one"><img src="{{asset('assets/images/logo.png')}}" alt="imshaaver.ir"></div>
                </div>
            </div>
        </section>

        <section id="slider-one" class="container my-lg-5 p-0">
            <div id="demo2" class="carousel slide" data-ride="carousel">
                <ul class="carousel-indicators">
                    @for ($i = 0; $i < $sliders->count(); $i++)
                        @if ($i == 0)
                            <li data-target="#demo" data-slide-to="0" class="active"></li> 
                        @else
                            <li data-target="#demo" data-slide-to="{{$i}}"></li>
                        @endif
                    @endfor
                </ul>
                <div class="carousel-inner">
                    @foreach ($sliders as $slider)
                        @if ($sliders[0]->id == $slider->id)

                            <div class="carousel-item active">
                                <a href="{{$slider->link}}" target="_blank" >
                                    <img src="{{$slidersPhotos->where('pictures_id', $slider->id)->first()->path}}" alt="Los Angeles" ">
                                    <div class="carousel-caption ">
                                        <h4 class="text-light">{{$slider->title}}</h4>
                                    </div>   
                                </a>
                            </div>
                            
                        @else
                        
                            <div class="carousel-item">
                                <a href="{{$slider->link}}" target="_blank" >
                                    <img src="{{$slidersPhotos->where('pictures_id', $slider->id)->first()->path}}" alt="Los Angeles" ">
                                    <div class="carousel-caption ">
                                        <h4 class="text-light">{{$slider->title}}</h4>
                                    </div>   
                                </a>
                            </div>

                        @endif

                    @endforeach
                </div>
            </div>
        </section>

        <section id="i-moshaver"><h1 class="text-white text-center py-lg-4 bg-custom-green">اپلیکیشن آی مشاور</h1></section>

        <section id="title-one">

            <div class="container">
                <div class="bg-white redu30 row p-5 my-5">
                    <div class="col pt-5 px-5 h5 head">
                        {!! $about->text_target !!}
                        <hr class="my-5">
                        <a href="{{route('user.home-guost-pwa')}}" class="btn bg-custom-green text-white px-5 py-3 redu20" >ورود و راهنمای نصب اپلیکیشن</a>
                    </div>
                    <div class="col"><img src="{{$about->pic_rule}}" alt="" class="redu50 shadow" style="width: 100%;"></div>
                </div>
            </div>
                    
        </section>

        <section id="text_rule" class="bg-custom-green pt-4">
            <div class="container py-4">
                <div class="px-lg-5">
                    <h1 class="text-white pb-3">درباره آی مشاور</h1>
                    {!! $about->text_rule !!}
                </div>
            </div>
        </section>

        <section id="serviceCat" class="py-5">
            <div class="container bg-white redu40 p-4">
                <div class="row">
                    <div class="col-12 mx-5 px-4">
                        <h1 class="pb-4">دسترسی به همه کارگاه ها</h1>
                    </div>
                    @foreach($serviceCat as $service)
                        <a href="{{route('user.home-guost-pwa')}}" class="@if($serviceCat->count()==4) col-lg-3 @else col-lg-4 @endif text-center px-5">
                            <div class="card card-style">
                                <img src="{{ url('/source/asset/assets/images/categories/'.$service->title.'.jpg') }}" alt="{{$service->title}}">
                            </div>
                            <h3>کارگاه های {{$service->title}}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="foter" class="social-network text-center bg-custom-green pt-4">
            <div class="row text-white m-0">
                <h1 class="col-12 text-white py-1">تماس با آی مشاور</h1>
                
                <small class="col-12 my-2 foter">{!!$about->text_home!!}</small>
                <hr class="my-2">
                <div class="col-12 my-2">
                    @foreach ($network as $net)
                        <a href="{{$net->address}}" class="box mx-1">
                            @switch($net->config)
                                @case("instagram")
                                    <i class="fab fa-instagram text-white"></i>
                                    @break
                                @case("whatsapp")
                                    <i class="fab fa-whatsapp text-white"></i>
                                    @break
                                @case("email")
                                    <i class="fa fa-envelope text-white"></i>
                                    @break
                            @endswitch
                        </a>
                    @endforeach
                </div>

            </div>
        </section>
            
    </div>

    <div class="home-guest-big d-lg-none">

        <div class="content navigation nav-99 m-0 bg-custom-green"> 
            <a href="{{route('user.home-guost-pwa')}}" > اپلیکیشن</a>
            <div class="logo-custom-one-sm"><img src="{{asset('assets/images/logo.png')}}" alt="imshaaver.ir"></div>
        </div>

        <section id="slider-one" class="pt-5">
            <div id="demo" class="carousel slide p-3" data-ride="carousel">
                <ul class="carousel-indicators">
                    @for ($i = 0; $i < $sliders->count(); $i++)
                        @if ($i == 0)
                            <li data-target="#demo" data-slide-to="0" class="active"></li> 
                        @else
                            <li data-target="#demo" data-slide-to="{{$i}}"></li>
                        @endif
                    @endfor
                </ul>
                <div class="carousel-inner">
                    @foreach ($sliders as $slider)
                        @if ($sliders[0]->id == $slider->id)
        
                            <div class="carousel-item active">
                                <a href="{{$slider->link}}" target="_blank" >
                                    <img src="{{$slidersPhotos->where('pictures_id', $slider->id)->first()->path}}" alt="Los Angeles" ">
                                    <div class="carousel-caption p-0 pt-2" style="right: 12px !important;">
                                        <a href="{{$slider->link}}" target="_blank" class="p-1 px-2 text-white bg-secondary " style="font-weight: bold;border-radius: 20px;">{{$slider->title}}</a>
                                    </div>   
                                </a>
                            </div>
                            
                        @else
                        
                            <div class="carousel-item">
                                <a href="{{$slider->link}}" target="_blank" >
                                    <img src="{{$slidersPhotos->where('pictures_id', $slider->id)->first()->path}}" alt="Los Angeles" ">
                                    <div class="carousel-caption p-0 pt-2" style="right: 12px !important;">
                                        <a href="{{$slider->link}}" target="_blank" class="p-1 px-2 text-white bg-secondary " style="font-weight: bold;border-radius: 20px;">{{$slider->title}}</a>
                                    </div>   
                                </a>
                            </div>
        
                        @endif
        
                    @endforeach
                </div>
            </div>
        </section>

        <section id="i-moshaver" style="background: #2f665f;" class="py-3 mt-2"><h1 class="text-white text-center">آی مشاور</h1></section>

        <section id="title-one">
            <div class="col-10 mx-auto">
                <img src="{{$about->pic_rule}}" alt="" class="border-redius50 shadow p-1 mt-3" style="width: 100%;">
            </div>
            <div class="p-4 h6 head-c">
                {!! $about->text_target !!}
                <hr class="my-4">
                <a href="{{route('user.home-guost-pwa')}}" class="btn btn-success border-redius20" style="background: #2f665f;">ورود و راهنمای نصب اپلیکیشن</a>
            </div>
        </section>

        <section id="text_rule" class="bg-secondary p-4">
            <h1 class="text-white pb-3">درباره آی مشاور</h1>
            {!! $about->text_rule !!}
        </section>

        <section id="serviceCat" class="pt-4">
            <div class="mx-auto" style="max-width: 1240px;">
                <div class="row mx-2">
                    <div class="col-12 text-center">
                        <h1 class="pb-4">دسترسی به همه کارگاه ها</h1>
                    </div>
                    @foreach($serviceCat as $service)
                        <div class="col-10 mx-auto bg-white text-center p-3 redu30 mb-4">
                            <a href="{{route('user.home-guost-pwa')}}" class="mb-2">
                                <img style="width: 100%;border-radius: 20px;max-height: 140px;" src="{{ url('/source/asset/assets/images/categories/'.$service->title.'.jpg') }}" alt="{{$service->title}}">
                            </a>    
                            <h6 style="font-weight: bold;margin: 12px 0px 0px;">کارگاه های {{$service->title}}</h6>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="foter" class="social-network text-center bg-secondary p-3">
            <div class="row text-white mb-0">
                <h1 class="col-12 text-white py-1">تماس با آی مشاور</h1>
                
                <small class="col-12 my-2 foter">{!!$about->text_home!!}</small>
                <hr >
                <div class="col-12 mt-2">
                    @foreach ($network as $net)
                        <a href="{{$net->address}}" class="box mx-1">
                            @switch($net->config)
                                @case("instagram")
                                    <i class="fab fa-instagram text-white"></i>
                                    @break
                                @case("whatsapp")
                                    <i class="fab fa-whatsapp text-white"></i>
                                    @break
                                @case("email")
                                    <i class="fa fa-envelope text-white"></i>
                                    @break
                            @endswitch
                        </a>
                    @endforeach
                </div>

            </div>
        </section>

    </div>

    <script type="text/javascript" src="{{ asset('assets/scripts/js/jquery-1.10.2.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/bootstrap.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/jquery.appear.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/scripts/js/jquery.countTo.js')}}"></script>

	<script type="text/javascript" src="{{ asset('assets/scripts/js/waypoints.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/jquery.prettyPhoto.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/modernizr-latest.js')}}"></script>
	{{-- <script type="text/javascript" src="{{ asset('assets/scripts/js/SmoothScroll.js')}}"></script> --}}
    
	<script type="text/javascript" src="{{ asset('assets/scripts/js/jquery.parallax-1.1.3.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/jquery.easing.1.3.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/jquery.sticky.js')}}"></script>
    
	<script type="text/javascript" src="{{ asset('assets/scripts/js/owl.carousel.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/jquery.isotope.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/rev-slider/jquery.themepunch.plugins.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/scripts/js/rev-slider/jquery.themepunch.revolution.min.js')}}"></script>
	<script type="text/javascript" src="{{ asset('assets/scripts/js/scripts.js')}}"></script>
@endsection
