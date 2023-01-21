@extends('user.master')
@section('content')

<style>
  #footer-bar , .header { display: none; }
  .card { background: unset; }
</style>

        <main class="flex-shrink-0 mt-lg-5">
            <div class="card">
                <div class="card-body">
                    <div class="container text-center mt-5">
                        <div class="icon icon-100 text-white mb-4">
                            {{-- <img src="{{ $setting->logo_site?url($setting->logo_site):'' }}" alt="{{ $setting->title }}" style="width: 100px;border-radius: 50px;"> --}}
                            <img src="https://img.icons8.com/external-justicon-flat-justicon/64/000000/external-block-notifications-justicon-flat-justicon.png" alt="{{ $setting->title }}" style="width: 80px">
                        </div>
                    </div>
                    <div class="container">
                        @if ( auth()->user()->hasRole('مدیر') )
                            <h4 class="mb-3">{{ ' مشترک گرامی : '.$setting->title }}</h4>
                        @else
                            <h4 class="mb-3">{{ ' کاربر گرامی : '.auth()->user()->first_name.' '.auth()->user()->last_name }}</h4>
                        @endif
                        
                        @if (auth()->user()->user_status!='active')
                            <h5 class="text-dark lh-base">حساب شما مسدود شده</h5>
                        @else
                            <h5 class="text-dark lh-base">تاریخ اشتراک شما پایان یافته برای ادامه لطفا حساب خود را شارژ کنید</h5>
                            @role('مدیر') 
                                <p class="my-4 fs-6">
                                    <a href="{{route('user.user-transaction.create')}}">
                                        <img src="https://img.icons8.com/ultraviolet/32/000000/card-in-use.png"/>
                                        جهت خرید پکیج کلیک کنید
                                    </a>
                                </p>
                            @endrole
                        @endif
                        <h6 class="text-primary text-center my-4 ">جهت اطلاعات بیشتر با پشتیبانی تماس بگیرید</h6>
                        {{env('SUPPORT_CALL')}}
                    </div>
                </div>
            </div>
        </main>

@endsection
