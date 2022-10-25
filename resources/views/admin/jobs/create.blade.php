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
                            {{ Form::open(array('route' => 'admin.jobs.store', 'method' => 'POST', 'files' => true)) }}
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('title', '* عنوان') }}
                                            {{ Form::text('title',null, array('class' => 'form-control')) }}
                                        </div>
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
@endsection
