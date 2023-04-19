@extends('user.master')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <style>
        body {max-width: 100% !important;}
        .header {padding: 6px 15px !important;height: 58px !important;}
        .page-content {padding-bottom: 0px !important;}
    </style>

    <!-- Begin page content -->
    <main class="flex-shrink-0">
        <!-- Fixed navbar -->
        <header class="header">
            <div class="row">
                <div class="text-left col">
                    <a class="navbar-brand" href="#">
                        <div class="icon icon-44">
                            <img src="{{ $setting->icon_site?url($setting->icon_site):'' }}" alt="{{ $setting->title }}" style="width: 100%;">
                        </div>
                        <h4>{{$setting->title}}</h4>
                    </a>
                </div>
                <div class="col-auto">
                    <a href="/login" class="icon icon-44 shadow-sm">
                        <figure class="m-0 background">
                            <img src="https://img.icons8.com/fluency/48/null/login-rounded.png"/>
                        </figure>
                    </a>
                </div>
            </div>
        </header>

        @if ($items->where('section','1')->count())
            <!-- page content start -->
            <div class="container text-center">
                <h6>
                    @php $t1 = $items->where('section','1')->where('position','1')->first(); @endphp
                    {{ $t1->title ? $t1->title : 'ما بهترینیم'}}
                </h6>
                <h1 class="my-3">
                    @php $t2 = $items->where('section','1')->where('position','2')->first(); @endphp
                    {{ $t2->title ? $t2->title : $setting->title}}
                </h1>
                <p>
                    @php $t3 = $items->where('section','1')->where('position','3')->first(); @endphp
                    {{ $t3->title ? $t3->title : 'سازوکاری هوشمند  جهت بهبود کسب و کار و مدیریت پرسنل'}}
                </p>
            </div>
        @endif
        
        @if ($items->where('section','2')->count())
            <div class="container-fluid mt-4 bg-dark text-white">
                <div class="container">
                    <div class="row my-1">
                        @foreach ($items->where('section','2') as $sec2)
                            <div class="col align-self-center">
                                <div class="text-center py-4">
                                    <h4 class="text-white">{{$sec2->title}}</h4>
                                    <p class="text-light small">{!! $sec2->text !!}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if ($items->where('section','3')->count())
            <div class="container mt-4">
                @foreach ($items->where('section','3') as $sec3)
                    <div class="row m-0">
                        <div class="col-lg-8 my-auto">
                            <div class="px-lg-5">
                                <h4>{{$sec3->title}}</h4>
                                <p class="mt-3">{!!$sec3->text!!}</p>
                                <div class="row">
                                    <div class="col col-lg-auto text-center"><a href="{{route('user.home-guost-pwa')}}" class="btn btn-dark px-lg-5">نصب اپلیکیشن</a></div>
                                    <div class="col col-lg-auto text-center"><a href="{{route('user.home-guost-register')}}" class="btn btn-success px-lg-5">ثبت نام رایگان</a></div>
                                </div>
                            </div>
                        </div>
                        @if ($sec3->pic)
                            <div class="col-lg">
                                <img src="{{url($sec3->pic)}}" alt="banner" class="w-100">
                            </div>                           
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
        
        @if ($items->where('section','4')->count())
            <div class="mt-4 bg-white">
                <div class="container pt-4 pt-lg-5">
                    <div class="row m-0">
                        @foreach ($items->where('section','4') as $sec4)
                            <div class="col-md-6 mb-4 mb-lg-5">
                                <div class="row m-0">
                                    @if ($sec4->pic)
                                        <div class="col-auto my-auto">
                                            <img src="{{url($sec4->pic)}}" alt="banner" style="height: 68px">
                                        </div>                           
                                    @endif
                                    <div class="col">
                                        <h6>{{$sec4->title}}</h6>
                                        <p class="small">{!!$sec4->text!!}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        @if ($items->where('section','5')->count())
            <div class="container my-4">
                @foreach ($items->where('section','5') as $sec5)
                    <h6 class="my-3">{{$sec5->title}}</h6>
                    <p class="small">{!!$sec5->text!!}</p>
                @endforeach
            </div>
        @endif

        @if ($items->where('section','6')->count())
            <div class="container-fluid my-4">
                <div class="swiper mySwiper swiper-initialized swiper-horizontal swiper-backface-hidden">
                    <div class="swiper-wrapper" id="swiper-wrapper-1c28e3e01f6dc39d" aria-live="polite">
                        @foreach ($items->where('section','6') as $i => $sec6)
                            <div class="text-center swiper-slide {{$i==0? 'swiper-slide-active' : ''}} {{$i==1 ? 'swiper-slide-next' : ''}}" role="group" aria-label="{{$i+1}} / {{$items->where('section','6')->count()}}">
                                <img src="{{$sec6->pic?url($sec6->pic):''}}" alt="{{$sec6->title}}" style="height: 148px;">
                                <h6 class="mb-5">{{$sec6->title}}</h6>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets swiper-pagination-horizontal"><span class="swiper-pagination-bullet swiper-pagination-bullet-active" tabindex="0" role="button" aria-label="Go to slide 1" aria-current="true"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 2"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 3"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 4"></span><span class="swiper-pagination-bullet" tabindex="0" role="button" aria-label="Go to slide 5"></span></div>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
            </div>
        @endif

    </main>

    <!-- footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container py-3">
            <div class="row">
                <div class="col">
                    <h4>روش های ارتباط با ما</h4>
                    <h6 class="mt-3">{{$setting->support_call}}</h6>
                </div>
                @if ($network->count())
                    <div class="col-auto">
                        @foreach ($network as $net)
                            @switch($net->config)
                                @case("linkedin")
                                    <a href="{{$net->address}}" class="box mx-1">
                                        <i class="fab fa-linkedin" style="font-size: 24px;"></i>
                                    </a>
                                @break
                                @case("telegram")
                                    <a href="{{$net->address}}" class="box mx-1">
                                        <i class="fab fa-telegram" style="font-size: 24px;"></i>
                                    </a>
                                @break
                                @case("instagram")
                                    <a href="{{$net->address}}" class="box mx-1">
                                        <i class="fab fa-instagram" style="font-size: 24px;"></i>
                                    </a>
                                    @break
                                @case("whatsapp")
                                    <a href="{{$net->address}}" class="box mx-1">
                                        <i class="fab fa-whatsapp" style="font-size: 24px;"></i>
                                    </a>
                                    @break
                                @case("email")
                                    <a href="#" onclick='sedarMail("{{$net->address}}")' class="box mx-1">
                                        <i class="fa fa-envelope" style="font-size: 22px;"></i>
                                    </a>
                                    @break
                            @endswitch
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="container text-center">
            <span class="text-secondary">All rights reserved by AdibGroup {{\Carbon\Carbon::today()->format('Y')}}</span>
        </div>
    </footer>

    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 10,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 4,
                    spaceBetween: 40,
                },
                1024: {
                    slidesPerView: 6,
                    spaceBetween: 50,
                },
            },
        });
    </script>
    
@endsection
