@extends('user.master')
@section('content')

    <form method="POST" action="{{route('user.update-password-by-token')}}">
        <main class="flex-shrink-0">
            <div class="container text-center mt-4">
                <div class="icon icon-100 text-white mb-4 text-center">
                    <img src="{{ \App\Model\Setting::find(1)->logo_site?url(\App\Model\Setting::find(1)->logo_site):'' }}" alt="{{ \App\Model\Setting::find(1)->title }}" style="width: 100px;border-radius: 50px;">
                </div>
                <h4 class="mb-4">{{ \App\Model\Setting::find(1)->title }}</h4>
            </div>
            <div class="container">
                <input type="hidden" name="p_token" id="p_token" value="{{$token}}">
                <h6 class="text-center">بازیابی رمزعبور</h6>
                <div class="login-box">
                    <div class="form-group floating-form-group">
                        <input type="password" name="password" id="password" class="form-control floating-input" required autofocus>
                        <label class="floating-label">رمزعبور جدید</label>
                    </div>
                    <div class="form-group floating-form-group">
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control floating-input" required>
                        <label class="floating-label">تکرار رمزعبور جدید</label>
                    </div>
                    <button type="submit" class="btn col-12 btn-block btn-info mt-2">ویرایش رمزعبور</button>
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

