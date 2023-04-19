@extends('user.master')
@section('content')

    <form method="POST" action="{{ route('user.register.new.user') }}">
        <main class="flex-shrink-0">
            <div class="container text-center">
                <div class="icon icon-100 text-white mb-4 text-center">
                    <img src="{{ \App\Model\Setting::find(1)->logo_site }}" alt="{{ \App\Model\Setting::find(1)->title }}" style="width: 100px;border-radius: 50px;">
                </div>
                <h4 class="mb-4">{{ \App\Model\Setting::find(1)->title }}</h4>
            </div>
            <div class="container">
                <div class="login-box">
                    <div class="form-group floating-form-group">
                        <input type="text" name="mobile" id="mobile" placeholder="09121119955" class="form-control floating-input" value="{{ old('mobile')}}" required autofocus>
                        <label class="floating-label">شماره موبایل را وارد کنید</label>
                        <h6 class="text-danger text-center p-1">{{$error ?? ''}}</h6>
                    </div>
                    
                    <div class="form-group floating-form-group">
                        {{ Form::label('company_name', '* عنوان کسب و کار') }}
                        {{ Form::text('company_name',null, array('class' => 'form-control floating-input' , 'required' => 'required')) }}
                    </div>
                    <div class="form-group floating-form-group">
                        {{ Form::label('first_name', '* نام') }}
                        {{ Form::text('first_name',null, array('class' => 'form-control floating-input', 'required' => 'required')) }}
                    </div>
                    <div class="form-group floating-form-group">
                        {{ Form::label('last_name', '* نام خانوادگی') }}
                        {{ Form::text('last_name',null, array('class' => 'form-control floating-input', 'required' => 'required')) }}
                    </div>
                    <div class="form-group floating-form-group">
                        {{ Form::label('email', '* ایمیل') }}
                        {{ Form::text('email',null, array('class' => 'form-control floating-input text-left' , 'required' => 'required')) }}
                    </div>
                    <div class="form-group floating-form-group">
                        {{ Form::label('whatsapp', ' شماره واتساپ فعال') }}
                        {{ Form::text('whatsapp',null, array('class' => 'form-control floating-input text-left', 'required' => 'required')) }}
                    </div>
                    <div class="form-group floating-form-group">
                        {{ Form::label('password', '* پسورد') }}
                        {!! Form::password('password', ['class' => 'form-control floating-input', 'required' => 'required']) !!}
                    </div>
                    <div class="form-group floating-form-group">
                        {{ Form::label('password_confirmation', '* تکرار پسورد') }}
                        {!! Form::password('password_confirmation', ['class' => 'form-control floating-input', 'required' => 'required']) !!}
                    </div>
                    
                    <div class="form-group my-4 text-secondary">
                        با کلیک روی دکمه زیر قوانین را مطالعه میکنم
                        <br>
                        <a href="#" data-toggle="modal" data-target="#modal" class="link">قوانین و مقررات</a>
                    </div>
                    <button type="submit" class="btn col-12 btn-block btn-info mt-2">ثبت نام</button>
                </div>
                <div class="text-center mt-3">
                    <a href="/login">ورود</a>
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
