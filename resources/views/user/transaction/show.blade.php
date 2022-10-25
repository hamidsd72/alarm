@extends('user.master')
@section('content')

<div class="pt-5 mt-4"></div>

    <div class="container d-none" id="two-step">
        <div class="row mb-5">
            <div class="col-12">
                <div class="py-4" id="show-price"></div>
            </div>
            <div class="my-4 row">
                <div class="col-6"><a href="#" class="btn col-12 btn-primary">پرداخت</a></div>
                <div class="col-6"><a href="#" onclick="location.reload();" class="btn col-12 btn-secondary">بررسی مجدد</a></div>
                
            </div>
        </div>
    </div>

    <div id="one-step">

        <div class="container mb-3">
            <div class="p-3 border redu20">
                <h6 class="my-3">لطفا تعداد کارمندان را وارد نمایید</h6>
                <input type="number" name="user" id="user" class="form-control redu20" value="{{$users}}" onkeyup="users_count()" >
                <p class="my-1 text-danger d-none" id="e-user">تعداد کارمندان کمتر از تعداد فعلی ({{$users}}) است</p>
                <h6 class="my-3">لطفا تعداد پیامک بسته را وارد نمایید</h6>
                <input type="number" name="sms" id="sms" class="form-control redu20" value="99" onkeyup="sms_count()" >
                <p class="my-1 text-danger" id="e-sms">حداقل تعداد پیامک ۱۰۰ عدد میباشد</p>
            </div>
        </div>
    
    </div>

    <script>
        function users_count() {
            if (document.getElementById('user').value >= {{$users}}) {
                document.getElementById('e-user').classList.add('d-none');
                setMoney()
            } else {
                document.getElementById('e-user').classList.remove('d-none');
                document.getElementById('setMoney').classList.add('d-none');
            }
        }

        function sms_count() {
            if (document.getElementById('sms').value >= 100) {
                document.getElementById('e-sms').classList.add('d-none');
                setMoney()
            } else {
                document.getElementById('e-sms').classList.remove('d-none');
                document.getElementById('setMoney').classList.add('d-none');
            }
        }
        
        function setMoney() {
            document.getElementById('one-step').classList.add('d-none');
            document.getElementById('two-step').classList.remove('d-none');

            let users_price  = document.getElementById('user').value * {{$user_price}};
            let sms_price    = document.getElementById('sms').value * {{$sms_price}};
            let total_amount = parseInt(users_price) + parseInt(sms_price);
            document.getElementById('show-price').innerHTML = `
            <p class='my-3 fs-6'>مبلغ کارمندان ${users_price} تومان</p>
            <p class='my-3 fs-6'>مبلغ پیامک ها ${sms_price} تومان</p>
            <p class='my-3 fs-5 fw-bold'>مبلغ قابل پرداخت ${total_amount} تومان</p>
            `;
        }
    </script>
@endsection