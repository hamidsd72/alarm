@extends('user.master')
@section('content')
<style>
    #footer-bar , .header { display: none; }
</style>

        <main class="flex-shrink-0 mt-lg-5">
            <div class="card">
                <div class="card-body">
                    <div class="container text-center mt-5">
                        <div class="icon icon-100 text-white mb-4 text-center">
                            {{-- <img src="{{ $setting->logo_site?url($setting->logo_site):'' }}" alt="{{ $setting->title }}" style="width: 100px;border-radius: 50px;"> --}}
                            <img src="https://img.icons8.com/external-justicon-flat-justicon/64/000000/external-block-notifications-justicon-flat-justicon.png" alt="{{ $setting->title }}" style="width: 80px">
                        </div>
                        <h4 class="mb-3">{{ ' مشترک گرامی : '.$setting->title }}</h4>
                    </div>
                    <div class="container">
                        {{-- <div class="login-box">
                            <div class="form-group floating-form-group">
                                <input type="text" name="first_name" id="first_name" class="form-control floating-input" style="text-align: right;" required autofocus>
                                <label class="floating-label">نام خود را وارد کنید</label>
                                <p class="text-danger text-center p-1">{{$ef ?? ''}}</p>
                            </div>
                            <div class="form-group floating-form-group">
                                <input type="text" name="last_name" id="last_name" class="form-control floating-input" style="text-align: right;" required>
                                <label class="floating-label">نام خانوادگی خود را وارد کنید</label>
                                <p class="text-danger text-center p-1">{{$el ?? ''}}</p>
                            </div>
                            <div class="form-group floating-form-group">
                                <input type="text" name="email" id="email" class="form-control floating-input"  required>
                                <label class="floating-label">ایمیل خود را وارد کنید</label>
                                <p class="text-danger text-center p-1">{{$ee ?? ''}}</p>
                            </div>
                            <button type="submit" class="btn btn-block col-12 btn-info mt-3">ارسال فرم مشخصات</button>
                        </div> --}}
                        @if (auth()->user()->user_status!='active')
                            <h5 class="text-dark text-center">حساب شما مسدود شده</h5>
                        @else
                            <h5 class="text-dark text-center">تاریخ اشتراک شما پایان یافته برای ادامه لطفا حساب خود را شارژ کنید</h5>
                        @endif
                        <h6 class="text-primary text-center my-3 ">جهت اطلاعات بیشتر با پشتیبانی تماس بگیرید</h6>
                        {{env('SUPPORT_CALL')}}
                    </div>
                </div>
            </div>
        </main>

@endsection
