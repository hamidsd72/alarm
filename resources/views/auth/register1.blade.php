@extends('user.master')
@section('content')

    <div id="pwa" class="container pt-lg-5">
        <div class="row">
            <div class="col-lg-4 text-center my-3">
                <img src="{{ \App\Model\Setting::find(1)->logo_site }}" alt="{{ \App\Model\Setting::find(1)->title }}" style="width: 80%;margin: auto;border-radius:500px;" >
            </div>
            <div class="col text-secondary mt-3">
                <h4 class="mb-4 text-center">نصب ورژن PWA اپلیکیشن {{ \App\Model\Setting::find(1)->title }}</h4>
                <h6 class="mb-3">در مرورگر سافاری (ios)</h6>
                <p class="small-font text-secondary">
                    <i class="fa-solid fa-arrow-up-from-bracket mx-1"></i>
                    در نوار پایین روی دکمه Share کلیک کنید
                </p>
                <p class="small-font text-secondary">
                    <i class="fa-regular fa-square-plus mx-1"></i>
                    در منوی باز شده در قسمت پایین صفحه گزینه
                </p>
                <p class="small-font text-secondary">
                    Add To Home Screen را انتخاب کنید
                </p>
                <p class="small-font text-secondary">
                    در مرحله بعد در قسمت بالا روی Add کلیک کنید 
                </p>
                <h6 class="mb-3">در مرورگر کروم (android)</h6>
                <p class="small-font text-secondary">
                    از منو کناری (نوبار) گزینه <br>
                    افزودن به صفحه اصلی (Add To Home Screen) را انتخاب کنید
                </p>
                <a href="{{route('user.index')}}" class="btn btn-sm btn-info col-12 d-none d-lg-block" >فهمیدم</a>
            </div> 
        </div>
    </div>
    <footer class="footer mt-auto py-3 text-center d-lg-none" style="bottom: 0px;width: 100%;">
        <div class="container">
            <a href="{{route('user.index')}}" class="btn btn-sm btn-info col-12" >فهمیدم</a>
        </div>
    </footer>

    {{-- <script>
        visitCheck();
        function visitCheck() {
            if (localStorage.getItem("visited")) {
                window.location.href = "{{url('/')}}"+"/login";
            } else {
                localStorage.setItem("visited", "visit");
            }
        }
    </script> --}}
@endsection
