<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <title>{{$setting->title}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="{{$keywordsSeo}}">
    <meta name="description" content="{{$descriptionSeo}}"/>
    <meta property="og:title" content="{{$titleSeo}}"/>
    <meta property="og:description" content="{{$descriptionSeo}}"/>
    <meta name="url" content="{{ url('/') }}"/>
    <meta property="og:image" content="{{url($setting->logo_site)}}">
    <link rel="icon" type="image/png" href="{{url($setting->icon_site)}}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css" href="{{asset('user/css/bootstrap.min.css')}}">

    <!--Google Fonts CSS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <!--Font Awesome Icon CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('user/css/font-awesome.min.css')}}">

    <!-- Slick Slider CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('user/css/slick.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('user/css/slick-theme.css')}}">

    <!-- Wow Animation CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('user/css/animate.min.css')}}">

    <!--Magnific Popup CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('user/css/magnific-popup.min.css')}}">

    <!-- Main Style CSS  -->
    <link rel="stylesheet" type="text/css" href="{{asset('user/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/persian-datepicker.min.css')}}">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-FQDGJZ38ZX"></script>

    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-FQDGJZ38ZX');
    </script>

    @yield('styles')

</head>
<body>

<!-- Loader Start -->
<div class="loader-box">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">در حال بارگیری...</p>
    </div>
</div>
<!-- Loader End -->

<!-- Header Start -->
<header class="site-header" dir="rtl">
    <!-- Top start -->
    <!--Navbar Start  -->
    <div class="header-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <!-- Sit Logo Start -->
                    <div class="site-branding">
                        <a href="{{url('/')}}" title="Educater">
                            <img style="width: 90px;" src="{{url($setting->logo_site)}}" alt="Logo">
                        </a>
                    </div>
                    <!-- Sit Logo End -->
                </div>
                <div class="col-lg-9">
                    <div class="header-menu">
                        <nav class="main-navigation">
                            <button class="toggle-button">
                                <span></span>
                                <span class="toggle-width"></span>
                                <span></span>
                            </button>
                            <ul class="menu">
                                <li class="{{\Request::route()->getName()=='user.index'?'active':''}}"><a href="{{route('user.index')}}">صفحه اصلی</a></li>
                                <li class="{{\Request::route()->getName()=='user.packages'?'active':''}}"><a href="{{route('user.packages')}}">پکیج ها</a></li>
                                <li class="sub-items">
                                    <a href="javascript:void(0);" title="Courses">خدمات</a>
                                    <ul class="sub-menu">
                                        @foreach($ServiceCats as $ServiceCat)
                                        <li><a href="{{route('user.services',[$ServiceCat->id])}}" title="Courses">{{$ServiceCat->title}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                               {{-- <li class="{{\Request::route()->getName()=='user.about.show'?'active':''}}"><a href="{{route('user.about.show')}}">درباره ما</a></li>--}}
                                <li class="{{\Request::route()->getName()=='user.agent.rule.show'?'active':''}}"><a href="{{route('user.agent.rule.show')}}">نحوه خرید</a></li>
                                <li class="{{\Request::route()->getName()=='user.rule.show'?'active':''}}"><a href="{{route('user.rule.show')}}">قوانین سدارکارت</a></li>
                                <li class="{{\Request::route()->getName()=='user.contact.show'?'active':''}}"><a href="{{route('user.contact.show')}}">تماس با ما</a></li>
                                @if (Auth::check())

                                    <li style="padding-left: 5px;margin-left: 5px;">
                                        <a href="{{route('user.basket.list')}}"><i class="fa fa-shopping-basket"></i> {{$BasketCount}}</a>
                                        |
                                    </li>
                                    <li  style="padding-left: 5px;margin-left: 5px;">

                                        <a href="{{route('admin.index')}}"><i class="fa fa-user"></i> پنل کاربری</a>
                                        |
                                    </li>
                                    <li  style="padding-left: 5px;margin-left: 5px;">
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fa fa-power-off"></i>
                                            خروج
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                @else
                                    <li style="padding-left: 5px;margin-left: 5px;">
                                        <a href="{{route('login')}}">ورود</a>
                                        |
                                    </li>
                                    <li style="padding-left: 5px;margin-left: 5px;">
                                        <a href="{{route('user.mobile')}}">ثبت نام</a>
                                    </li>
                                @endif

                            </ul>
                        </nav>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Navbar End  -->
</header>

@yield('content')
<section class="main-footer">
    <div class="container">
        <div class="row" dir="rtl">

            <div class="col-lg-7 col-md-7">
                <div class="footer-logo-content" style="text-align: right; color: #fff;">
                    <span style="font-size: 1.8rem;">آدرس</span>
                    {{--<p><span></span>
                        شهرک غرب بلوار دادمان خیابان درختی انتهای خیابان سپهر گلبرگ سوم بن بست رضایی پلاک ۱۱۰ واحد ۸ طبقه چهارم
                    </p>--}}
                    <p><span></span>Kapstadtring 7, 22297 Hamburg</p>
                    <p dir="ltr">
                        +982128422024
                    </p>

                    <p dir="ltr">
                        +4915739396989 | +491636698708
                    </p>
                </div>
            </div>
            {{--<div class="col-lg-4 col-md-6">
                <div class="footer-other-link">
                    <h3 class="h3-title">Other Link</h3>
                    <ul>
                        <li><a href="instructor.html">Instructor</a></li>
                        <li><a href="faq.html">FAQ</a></li>
                        <li><a href="event-detaill.html">Event</a></li>
                        <li><a href="about-us.html">Privacy Policy</a></li>
                        <li><a href="about-us.html">Term & Condition</a></li>
                    </ul>
                </div>
            </div>--}}
            <div class="col-lg-5 col-md-5">
                <div class="footer-logo-content">
                    <a href="{{url('/')}}"><img style="width: 70px;" src="{{url($setting->logo_site)}}" alt="Educater"></a>
                    <span>شعار ما</span>
                    <p style="text-align: justify;">ایرانی لایق داشتن بهترینها ست...
                        <br>
                        با سدارکارت متفاوت و با کیفیت زندگی کنید. اگر به دنبال خدمات خاص، یادگیری هنر، مهارت زبانهای
                        خارجه، تناسب اندام و کشف استعداد هستید، کافیست به باشگاه مشتریان سدار بپیوندید</p>
                    <p>
                    <ul dir="ltr">
                        <li><a href="https://www.instagram.com/sedarcard/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a href="mailto:info@sedarholding.com"><i class="fa fa-envelope" aria-hidden="true"></i></a></li>
                        <li><a href="https://www.instagram.com/sedarcard/"><i class="fa fa-telegram" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <span class="copyright-text">Copyright &copy; 2022 <a href="index.html">ADBIB IT.</a> All rights reserved.</span>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Footer End-->

<!-- Scroll To Top Start -->
<a href="#main-banner" class="scroll-top" id="scroll-to-top">
    <i class="fa fa-arrow-up" aria-hidden="true"></i>
</a>
<!-- Scroll To Top End-->
<div class="wat_sapp wat_sapp1">
    <a target="_blank" rel="noreferrer" href="https://api.whatsapp.com/send?phone=+491636698708">
        <img class="social_img" src="https://altayproperty.com/source/assets/user/pic/whatss.png" alt="واتساپ ">
    </a>
</div>
<!-- Bubbles Animation Start -->
<div class="bubbles_wrap">
    <div class="bubble x1"></div>
    <div class="bubble x2"></div>
    <div class="bubble x3"></div>
    <div class="bubble x4"></div>
    <div class="bubble x5"></div>
    <div class="bubble x6"></div>
    <div class="bubble x7"></div>
    <div class="bubble x8"></div>
    <div class="bubble x9"></div>
    <div class="bubble x10"></div>
</div>

<script src="{{asset('user/js/jquery.min.js')}}"></script>

<!-- Bootstrap JS Link -->
<script src="{{asset('user/js/bootstrap.min.js')}}"></script>
<script src="{{asset('user/js/popper.min.js')}}"></script>

<!-- Custom JS Link -->
<script src="{{asset('user/js/custom.js')}}"></script>

<!-- Slick Slider JS Link -->
<script src="{{asset('user/js/slick.min.js')}}"></script>

<!-- Wow Animation JS -->
<script src="{{asset('user/js/wow.min.js')}}"></script>

<!--Banner Bg Animation JS-->
<script src="{{asset('user/js/bg-moving.js')}}"></script>

<!--Magnific Popup JS-->
<script src="{{asset('user/js/magnific-popup.js')}}"></script>
<script src="{{asset('user/js/custom-magnific-popup.js')}}"></script>

<script src="{{asset('admin/js/persian-date.min.js')}}"></script>
<script src="{{asset('admin/js/persian-datepicker.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="{{asset('user/js/plugin.js')}}"></script>
<script src="{{asset('user/js/script.js')}}"></script>

<script src="{{asset('admin/js/persian-date.min.js')}}"></script>
<script src="{{asset('admin/js/persian-datepicker.min.js')}}"></script>
<script src="{{asset('auth/js/script.js')}}"></script>
<script>


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
                        '<p class="text-right mt-2 ml-5" dir="rtl"> {{$key+1}} : ' +
                '{{ $error }}' +
                '</p>' +
                    @endforeach
                        '<p class="text-right mt-2 ml-5" dir="rtl">' +
                '</p>',
            timer: @if(count($errors)>3)parseInt('{{count($errors)}}') * 1500 @else 6000 @endif,
            timerProgressBar: true,
        })
    });
    @endif
</script>
@yield('scripts')


</body>
</html>
