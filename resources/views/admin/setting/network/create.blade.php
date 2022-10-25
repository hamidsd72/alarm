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
                            {{ Form::open(array('route' => 'admin.network-setting.store', 'method' => 'POST')) }}
                            <div class="row">
                                <input type="hidden" name="status" value="active">
                                @if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) 
                                    <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                                @else
                                    <input type="hidden" name="user_id" value="{{auth()->user()->reagent_id}}">
                                @endif
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('name', '* عنوان') }}
                                        {{ Form::text('name',null, array('class' => 'form-control','placeholder'=>'اینستاگرام احمد', 'required' => 'required')) }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('config', '* شبکه اجتماعی') }}
                                        <select name="config" id="config" class="form-control">
                                            <option value="instagram" selected>اینستاگرام</option>
                                            <option value="whatsapp">واتس اپ</option>
                                            <option value="email">ایمیل</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('sort', 'ترتیب') }}
                                        {{ Form::number('sort',null, array('class' => 'form-control','placeholder'=>'ترتیب اولیت نمایش')) }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('address', 'لینک *') }}
                                        {{ Form::text('address',null, array('class' => 'form-control text-left dir-ltr','placeholder'=>'https://instagram.com/hamidsd72', 'required' => 'required')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    {{ Form::button('افزودن', array('type' => 'submit', 'class' => 'btn btn-success col-12')) }}
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