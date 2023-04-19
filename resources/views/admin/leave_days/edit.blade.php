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
                            {{ Form::model($item,array('route' => array('admin.leave-day.update', $item->id), 'method' => 'PATCH', 'files' => true)) }}
                            <div class="row my-2">
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-group">
                                        {{ Form::label('user_id', '* کاربر') }}
                                        <select class="form-control select2" name="user_id" >
                                            @foreach($users as $user)
                                                <option value="{{$user->id}}" {{$user->id==$item->user_id?'selected':''}}>({{$user->first_name.' '.$user->last_name}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row my-2">
                                <div class="col-md col-lg-4">
                                    <div class="form-group">
                                        {{ Form::label('start_at', ' از تاریخ ') }}
                                        <input type="text" name="start_at" id="start_at" class="form-control date_p" value="{{num2fa(my_jdate($item->start_at,'Y/m/d'))}}">
                                        {{-- {{ Form::text('start_at',null, array('class' => 'form-control date_p')) }} --}}
                                        <img class="inline-left-logo" src="https://img.icons8.com/external-icematte-lafs/40/000000/external-Calendar-it-icematte-lafs.png">
                                    </div>
                                </div>
                                <div class="col-md col-lg-4">
                                    <div class="form-group">
                                        {{ Form::label('end_at', ' تا تاریخ ') }}
                                        <input type="text" name="end_at" id="end_at" class="form-control date_p" value="{{num2fa(my_jdate($item->end_at,'Y/m/d'))}}">
                                        {{-- {{ Form::text('end_at',null, array('class' => 'form-control date_p')) }} --}}
                                        <img class="inline-left-logo" src="https://img.icons8.com/external-icematte-lafs/40/000000/external-Calendar-it-icematte-lafs.png">
                                    </div>
                                </div>
                                
                                @if ($item->type=='daily')
                                    <div class="col-md-2 col-lg-4">
                                        <div class="form-group">
                                            {{ Form::label('count', '* مجموع تعداد روز مرخصی') }}
                                            {{ Form::number('count',null, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="row my-2">
                                @if ($item->type=='minutely')
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            {{ Form::label('start_time', ' از ساعت ') }}
                                            <input type="time" name="start_time" id="start_time" class="form-control" value="{{$item->start_time}}">
                                            <img class="inline-left-logo" src="https://img.icons8.com/ultraviolet/40/null/clock--v1.png"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="form-group">
                                            {{ Form::label('end_time', ' تا ساعت ') }}
                                            <input type="time" name="end_time" id="end_time" class="form-control" value="{{$item->end_time}}">
                                            <img class="inline-left-logo" src="https://img.icons8.com/ultraviolet/40/null/clock--v1.png"/>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{ Form::label('text', '* شرح مرخصی') }}
                                        {{ Form::textarea('text',null, array('class' => 'form-control textarea')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    {{ Form::button('ویرایش', array('type' => 'submit', 'class' => 'btn btn-success col-12')) }}
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
@endsection
