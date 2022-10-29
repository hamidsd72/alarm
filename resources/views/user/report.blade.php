w@extends('user.master')
@section('content')
    <style> h6 { line-height: 24px; } </style>
    <section class="social-network text-center">
        <h1 class="text-dark text-uppercase py-1">i moshaver</h1>
        
        <div class="text-center @if($data->status && $data->status=100) text-success @endif">
            <h6>
                وضعیت : 
                @if($data->status && $data->status=100)
                    خرید موفقیت آمیز
                @else
                    انصراف از خرید
                @endif
            </h6>
            <h6>{{' در تاریخ : '.my_jdate($data->created_at,'d F Y')}}</h6>
            <h6>{{' در تاریخ : '.$data->created_at}}</h6>
            <h6 style="max-width: 260px;margin: auto;">{{' توضیحات : '.$data->description}}</h6>
            <h6 class="mt-2">{{' مبلغ کل تراکنش : '.$data->amount}}</h6>
        </div>

        <a href="{{ route('admin.profile.show') }}" class="btn btn-success py-2 px-5 mt-3 redu30">رفتن پروفایل من</a>

    </section>

@endsection
