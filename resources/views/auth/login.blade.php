@extends('user.master')
@section('content')

    <form method="POST" action="{{route('user.sign-up-using-mobile.store')}}">
    {{-- <form method="POST" action="{{route('login')}}"> --}}
        <main class="flex-shrink-0">
            <div class="container text-center mt-4">
                <div class="icon icon-100 text-white mb-4 text-center">
                    <img src="{{ \App\Model\Setting::find(1)->logo_site }}" alt="{{ \App\Model\Setting::find(1)->title }}" style="width: 100px;border-radius: 50px;">
                </div>
                <h4 class="mb-4">{{ \App\Model\Setting::find(1)->title }}</h4>
            </div>
            <div class="container">
                <div class="login-box">
                    <div class="form-group floating-form-group">
                        <input type="text" name="mobile" id="mobile" placeholder="09121119955" class="form-control floating-input" required autofocus>
                        {{-- <input type="text" name="email" id="email" class="form-control floating-input" required autofocus> --}}
                        <label class="floating-label">شماره موبایل را وارد کنید</label>
                        <h6 class="text-danger text-center p-1">{{$error ?? ''}}</h6>
                    </div>
                    
                    {{-- <div class="form-group floating-form-group">
                        <input type="password" name="password" id="password" class="form-control floating-input" required >
                        <label class="floating-label">رمزعبور را وارد کنید</label>
                        <h6 class="text-danger text-center p-1">{{$error ?? ''}}</h6>
                        @if ($errors->count())
                            <h6 class="text-danger text-center p-1">ایمیل یا رمزعبور اشتباه است</h6>
                        @endif
                    </div> --}}
                    <div class="form-group my-4 text-secondary">
                        با کلیک روی دکمه زیر قوانین را مطالعه میکنم
                        <br>
                        <a href="#" data-toggle="modal" data-target="#modal" class="link">قوانین و مقررات</a>
                    </div>
                    <button type="submit" class="btn col-12 btn-block btn-info mt-2">ورود</button>
                </div>
            </div>
        </main>
        @csrf
    </form>

    <div class="modal" id="modal">
        <div class="modal-dialog modal-dialog-scrollable pt-4">
            <div class="modal-content" style="border-radius: 30px;">
                <div class="modal-body">
                    <h4 class="mb-3">{{App\Model\About::find(1)->title_rule}}</h4>
                    {!! App\Model\About::find(1)->text_rule !!}
                    <button data-dismiss="modal" class="btn btn-success col-12 btn-block mt-3">قوانین را قبول دارم </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function(){
            $("input[name='mobile']").on('input', function (e) {
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
            });
        });
    </script>
@endsection
























{{--@extends('layouts.user')--}}

{{--@section('content')--}}
{{--    <div class="login_page_head"></div>--}}
{{--    <div class="login_pag" style="margin-top: 200px;margin-bottom: 100px;">--}}
{{--        <div class="container">--}}
{{--            <div class="row" dir="rtl">--}}
{{--                <div class="col-md-5 m-auto carding">--}}
{{--                    <div class="col-md-6 ">--}}
{{--                        <h3 class="text-left"> ورود</h3>--}}
{{--                    </div>--}}
{{--                    <div class="col-md-6">--}}
{{--                        <span class="glyphicon glyphicon-pencil"></span>--}}
{{--                    </div>--}}
{{--                    <hr>--}}
{{--                    <form method="POST" action="{{ route('login') }}">--}}
{{--                        @csrf--}}
{{--                    <div class="row">--}}
{{--                        <label class="col-md-2 label control-label">ایمیل</label>--}}
{{--                        <div class="col-md-10">--}}
{{--                            <input id="email" type="text" class="form-control text-left @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="mobile" autofocus>--}}

{{--                            @error('mobile')--}}
{{--                            <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row" style="margin-top: 15px;">--}}
{{--                        <label class="col-md-2 label control-label">رمز عبور</label>--}}
{{--                        <div class="col-md-10" >--}}
{{--                            <input id="password" type="password" class="form-control text-left @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">--}}

{{--                            @error('password')--}}
{{--                            <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                            @enderror--}}
{{--                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>--}}
{{--                            <small> مرا بخاطر بسپار</small>--}}
{{--                            <br>--}}
{{--                            <a href="{{ route('user.reset.password.show')}}"  class="reset_password"> رمزعبور خود را فراموش کرده اید؟</a>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row">--}}
{{--                        <label class="col-md-2 label control-label"></label>--}}
{{--                        <div class="col-md-10" style="margin-top: 20px;">--}}
{{--                            <button type="submit" class="btn btn-info"> ورود </button>--}}
{{--                            <a href="{{ route('user.mobile')}}" style="margin-right: 10px;"  class="btn btn-warning"> ثبت نام</a>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="login_page_footer"></div>--}}

{{--@endsection--}}
