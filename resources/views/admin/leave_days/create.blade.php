@extends('layouts.admin')
@section('css')
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            {{ Form::open(array('route' => 'admin.leave-day.store', 'method' => 'POST', 'files' => true)) }}
                                <div class="row my-2">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            {{ Form::label('user_id', '* کاربر') }}
                                            <select class="form-control select2" name="user_id" required>
                                                <option value="" selected>انتخاب کنید</option>
                                                @foreach($users as $key => $user)
                                                    <option value="{{$user->id}}">{{$user->first_name.' '.$user->last_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            {{ Form::label('type', '* نوع مرخصی') }}
                                            <select class="form-control select2" name="type" onchange="typeChange(this.value)" required>
                                                <option value="" selected>انتخاب کنید</option>
                                                <option value="daily">روزانه</option>
                                                <option value="minutely">ساعتی</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                    
                                <div class="row my-2">
                                    <div class="col-md col-lg-4">
                                        <div class="form-group">
                                            {{ Form::label('start_at', '* از تاریخ ') }}
                                            {{ Form::text('start_at',null, array('class' => 'form-control date_p', 'required' => 'required')) }}
                                            <img class="inline-left-logo" src="https://img.icons8.com/external-icematte-lafs/40/000000/external-Calendar-it-icematte-lafs.png">
                                        </div>
                                    </div>
                                    <div class="col-md col-lg-4">
                                        <div class="form-group">
                                            {{ Form::label('end_at', '* تا تاریخ ') }}
                                            {{ Form::text('end_at',null, array('class' => 'form-control date_p', 'required' => 'required')) }}
                                            <img class="inline-left-logo" src="https://img.icons8.com/external-icematte-lafs/40/000000/external-Calendar-it-icematte-lafs.png">
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-lg-4 d-none daily">
                                        <div class="form-group">
                                            {{ Form::label('count', '* مجموع تعداد روز مرخصی') }}
                                            {{ Form::number('count',0, array('class' => 'form-control text-left')) }}
                                        </div>
                                    </div>
                                </div>

                                <div class="row my-2 d-none minutely">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            {{ Form::label('start_time', ' از ساعت *') }}
                                            <input type="time" name="start_time" id="start_time" class="form-control">
                                            <img class="inline-left-logo" src="https://img.icons8.com/ultraviolet/40/null/clock--v1.png"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            {{ Form::label('end_time', ' تا ساعت *') }}
                                            <input type="time" name="end_time" id="end_time" class="form-control">
                                            <img class="inline-left-logo" src="https://img.icons8.com/ultraviolet/40/null/clock--v1.png"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 d-none text-box">
                                    <div class="form-group">
                                        {{ Form::label('text', '* شرح مرخصی') }}
                                        {{ Form::textarea('text',null, array('class' => 'form-control textarea', 'required' => 'required')) }}
                                    </div>
                                </div>

                                <div class="row my-3">
                                    <div class="col">
                                        {{ Form::button('ثبت', array('type' => 'submit', 'class' => 'btn btn-success col-12')) }}
                                    </div>
                                    <div class="col">
                                        <a href="{{ URL::previous() }}" class="btn btn-secondary col-12">بازگشت</a>
                                    </div>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('js')
<script>
    function typeChange(type) {
        if (type==='daily') {
            document.querySelector('.daily').classList.remove('d-none')
        } else {
            document.querySelector('.minutely').classList.remove('d-none')
        }
        document.querySelector('.text-box').classList.remove('d-none')
    }
</script>
@endsection
