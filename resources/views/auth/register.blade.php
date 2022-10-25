@extends('user.master')
@section('content')

    <main class="flex-shrink-0">
        <div class="container">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide text-center pb-3">
                        <div class="image-circle">
                            <figure class="background">
                                <img src="{{ \App\Model\Setting::find(1)->logo_site }}" alt="{{ \App\Model\Setting::find(1)->title }}">
                            </figure>
                        </div>
                        <h4 class="mt-0 my-3">{{ \App\Model\Setting::find(1)->title }}</h4>
                        <div class="text-center">
                            <p class="small-font text-secondary px-lg-4">بزرگترین مرکز تخصصی مشاوره، طراحی و خدمات سیستمهای ایمنی، حفاظتی و آتش نشانی ایران</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-center" style="bottom: 0px;width: 100%;">
        <div class="container">
            <div class="row">
                <div class="col">
                    <a href="{{route('login')}}" class="btn btn-block col-12 mx-auto btn-info btn-lg">ورود به حساب</a>
                </div>
                <div class="col">
                    <a href="{{route('user.home-guost-pwa')}}" class="btn btn-block col-12 mx-auto btn-dark btn-lg">نصب اپلیکیشن</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        "use strict"
        $(window).on('load', function() {
            var swiper = new Swiper('.swiper-container', {
                pagination: {
                    el: '.swiper-pagination',
                },
            });
        });
    </script>

@endsection

{{-- @extends('layouts.user')
@section('content')
    <div class="login_page_head"></div>
    <div class="login_pag" style="margin-top: 200px;margin-bottom: 100px;">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                </div>
                <div class="col-md-5">
                    <div class="col-md-6 ">
                        <h3 class="text-left"> ثبت نام</h3>
                    </div>
                    <div class="col-md-6">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </div>
                    <hr>
                    <form method="POST" action="{{isset($_GET['reagent_code'])? route('register',['reagent_code'=>$_GET['reagent_code']]):route('register') }}">
                        @csrf
                        <div class="row">
                            <label class="col-md-3 label control-label">نام</label>
                            <div class="col-md-9">
                                <input id="f_name" type="text"
                                       class="form-control @error('f_name') is-invalid @enderror" name="f_name" value="{{ old('f_name') }}" required>

                                @error('f_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">نام خانوادگی</label>
                            <div class="col-md-9">
                                <input id="l_name" type="text"
                                       class="form-control @error('l_name') is-invalid @enderror" name="l_name"
                                       value="{{ old('l_name') }}" required>

                                @error('l_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">موبایل</label>
                            <div class="col-md-9">
                                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
                                       name="mobile" value="{{ old('mobile') }}" required>

                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">شماره واتسپ فعال</label>
                            <div class="col-md-9">
                                <input id="whatsapp" type="text"
                                       class="form-control @error('whatsapp') is-invalid @enderror" name="whatsapp"
                                       value="{{ old('whatsapp') }}" required>

                                @error('whatsapp')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">استان</label>
                            <div class="col-md-9">
                                <select id="state_id" type="text"
                                        class="form-control @error('state_id') is-invalid @enderror" name="state_id"
                                        required>
                                    <option value="">انتخاب کنید</option>
                                    @foreach($states as $key=>$state )
                                        <option value="{{$state->id}}" {{old('state_id')==$state->id?'selected':''}}>{{$state->name}}</option>
                                    @endforeach

                                </select>

                                @error('state_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">شهر</label>
                            <div class="col-md-9">
                                <select id="city_id" type="text"
                                       class="form-control @error('city_id') is-invalid @enderror" name="city_id" required>
                                    <option value="">ابتدا استان را انتخاب کنید</option>

                                </select>

                                @error('city_id')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">منطقه</label>
                            <div class="col-md-9">
                                <input id="locate" type="text"
                                       class="form-control @error('locate') is-invalid @enderror" name="locate"
                                       value="{{ old('locate') }}" required>

                                @error('locate')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">آدرس</label>
                            <div class="col-md-9">
                                <input id="address" type="text" class=" form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required>

                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">تاریخ تولد</label>
                            <div class="col-md-9">
                                <input id="date_birth" type="text"
                                       class=" input_date form-control @error('date_birth') is-invalid @enderror" name="date_birth"
                                       value="{{ old('date_birth') }}" readonly required>

                                @error('date_birth')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">تحصیلات</label>
                            <div class="col-md-9">
                                <input id="education" type="text"
                                       class="form-control @error('education') is-invalid @enderror" name="education"
                                       value="{{ old('education') }}" required>

                                @error('education')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">ایمیل</label>
                            <div class="col-md-9">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">رمز عبور</label>
                            <div class="col-md-9">
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label">تکرار رمز</label>
                            <div class="col-md-9">
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required autocomplete="new-password">

                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="row">
                            <label class="col-md-3 label control-label"></label>
                            <div class="col-md-9">
                                <button type="submit" class="btn btn-info"> ثبت نام</button>
                                <a href="{{ route('login')}}" type="submit" class="btn btn-warning"> ورود</a>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="login_page_footer"></div>

@endsection
 --}}
