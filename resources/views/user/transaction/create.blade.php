@extends('user.master')
@section('content')

<div class="pt-5"></div>
    <div class="p-1 px-4 fs-5 fw-bold">
        <img src="https://img.icons8.com/ultraviolet/28/000000/merchant-account.png"/>
        ارتقا پکیج
    </div>
    <hr>
    <div class="container d-none" id="two-step">
        <div class="row mb-5">
            <div class="col-12">
                <div class="py-4" id="show-price"></div>
            </div>
            <div class="my-4 row">
                <div class="col-6"><a href="#" class="btn col-12 btn-success">پرداخت</a></div>
                <div class="col-6"><a href="#" onclick="location.reload();" class="btn col-12 btn-secondary">بررسی مجدد</a></div>
            </div>
        </div>
    </div>

    <div id="one-step">
        <div class="container mb-3">
            <div class="row mb-0">
                <div class="col-7 pt-2 mt-1 fw-bold p-0">لطفا تعداد کارمندان را وارد نمایید</div>
                <div class="col-5">
                    <input type="number" name="user" id="user" class="form-control redu20" value="{{$users}}" onkeyup="users_count()" >
                    <img class="inline-left-logo pt-1 pe-1" src="https://img.icons8.com/ultraviolet/28/000000/user-group-man-woman.png"/>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-7 pt-2 mt-1 fw-bold p-0">لطفا تعداد پیامک پکیج را وارد نمایید</div>
                <div class="col-5">
                    <input type="number" name="sms" id="sms" class="form-control redu20" value="99" onkeyup="sms_count()" >
                    <img class="inline-left-logo pt-1 pe-1" src="https://img.icons8.com/ultraviolet/28/000000/add-open-envelope.png"/>
                </div>
                <div class="col-12 text-danger d-none" id="e-user">تعداد کارمندان کمتر از تعداد فعلی ({{$users}}) است</div>
                <div class="col-12 text-danger" id="e-sms">حداقل تعداد پیامک ۱۰۰ عدد میباشد</div>
            </div>
        </div>
    
        <div id="setMoney" class="px-4 d-none">
            {{-- اگر کاربر اشتراک داشت پکیج فعلی رو آپگرید کنه --}}
            @if (\App\User::is_special_user( auth()->user()->id ))
                <div class="px-2 mb-3">
                    <input type="radio" name="cards" class="checkbox-boxed" id="card">
                    <label onclick="setMoney2(0)" class="checkbox-lable payment-card-large shadow redu20 " for="card">
                        <div class="image-boxed h-auto p-3">
                            <h4 class="p-2 fw-bold text-start text-white">ارتقا پکیج بسته جاری</h4>
                            <h6 class="p-2 text-start text-white"> رایگان </h6>
                        </div>
                        <h4 class="fw-bold py-1">ارتقا پکیج</h4>
                    </label>
                </div>
            @endif
            @foreach ($packages->where('type','package') as $key => $item)
                <div class="px-2 mb-3">
                    <input type="radio" name="cards" class="checkbox-boxed" id="card{{$item->id+1}}" @if( $item->id==$packages->where('type','package')->first()->id ) checked @endif>
                    <label onclick="setMoney('{{$item->off_amount?$item->off_amount:$item->amount}}')" class="checkbox-lable payment-card-large shadow redu20 " for="card{{$item->id+1}}">
                        <div class="image-boxed h-auto p-3" style="background: {{$item->background}}">
                            <h4 class="m-0 p-2 fw-bold text-start text-white">{{$item->form_name}}</h4>
                            <h6 class="p-2 fw-bold text-start text-white">{{$item->amount.' تومان '}}</h6>
                            <h6 class="pb-2 text-start text-white">{{' مبلغ نهایی : '.($item->off_amount?$item->off_amount:$item->amount).' تومان '}}</h6>
                        </div>
                        <h4 class="fw-bold py-1">انتخاب بسته</h4>
                    </label>
                </div>
            @endforeach
        </div>

    </div>

    <script>
        function users_count() {
            if (document.getElementById('user').value >= {{$users}}) {
                document.getElementById('e-user').classList.add('d-none');
                show_setMoney()
            } else {
                document.getElementById('e-user').classList.remove('d-none');
                document.getElementById('setMoney').classList.add('d-none');
            }
        }

        function sms_count() {
            if (document.getElementById('sms').value >= 100) {
                document.getElementById('e-sms').classList.add('d-none');
                show_setMoney()
            } else {
                document.getElementById('e-sms').classList.remove('d-none');
                document.getElementById('setMoney').classList.add('d-none');
            }
        }

        function show_setMoney() {
            if (document.getElementById('user').value >= {{$users}} && document.getElementById('sms').value >= 100) {
                document.getElementById('setMoney').classList.remove('d-none');
            } else {
                document.getElementById('setMoney').classList.add('d-none');
            }
        }
        
        function setMoney(amount) {
            document.getElementById('one-step').classList.add('d-none');
            document.getElementById('two-step').classList.remove('d-none');

            let users_price  = document.getElementById('user').value * {{$user_price}};
            let sms_price    = document.getElementById('sms').value * {{$sms_price}};
            let total_amount = parseInt(amount) + parseInt(users_price) + parseInt(sms_price);
            document.getElementById('show-price').innerHTML = `
            <p class='my-4 fs-6'><img class='me-2' src='https://img.icons8.com/ultraviolet/28/000000/user-group-man-woman.png'/>مبلغ کارمندان ${users_price} تومان</p>
            <p class='my-4 fs-6'><img class='me-2' src='https://img.icons8.com/ultraviolet/28/000000/add-open-envelope.png'/>مبلغ پیامک ها ${sms_price} تومان</p>
            <p class='my-4 fs-6'><img class='me-2' src='https://img.icons8.com/ultraviolet/28/000000/card-in-use.png'/>مبلغ بسته ماهانه ${amount} تومان</p>
            <p class='my-4 fs-6 fw-bold'>مبلغ قابل پرداخت ${total_amount} تومان</p>
            `;
        }

        function setMoney2(amount) {
            document.getElementById('one-step').classList.add('d-none');
            document.getElementById('two-step').classList.remove('d-none');

            let users_price  = (document.getElementById('user').value - {{auth()->user()->employees_count()}} ) * {{$user_price}};
            let sms_price    = document.getElementById('sms').value * {{$sms_price}};
            let total_amount = parseInt(amount) + parseInt(users_price) + parseInt(sms_price);
            document.getElementById('show-price').innerHTML = `
            <p class='my-4 fs-6'><img class='me-2' src='https://img.icons8.com/ultraviolet/28/000000/user-group-man-woman.png'/>مبلغ کارمندان ${users_price} تومان</p>
            <p class='my-4 fs-6'><img class='me-2' src='https://img.icons8.com/ultraviolet/28/000000/add-open-envelope.png'/>مبلغ پیامک ها ${sms_price} تومان</p>
            <p class='my-4 fs-6'><img class='me-2' src='https://img.icons8.com/ultraviolet/28/000000/card-in-use.png'/>مبلغ بسته ماهانه ${amount} تومان</p>
            <p class='my-4 fs-6 fw-bold'>مبلغ قابل پرداخت ${total_amount} تومان</p>
            `;
        }
    </script>
@endsection