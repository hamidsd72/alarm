@extends('layouts.admin')
@section('css')

@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            {{ Form::open(array('route' => 'admin.ticket.store', 'method' => 'POST', 'files' => true)) }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('title', ' عنوان *')}}
                                        {{Form::text('title', null, array('class' => 'form-control','required'))}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{Form::label('priority', 'اولویت *')}}
                                        {{ Form::select('priority', ['low'=>'کم','medium'=>'متوسط','much'=>'زیاد',], null, array('class' => 'form-control select2')) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{Form::label('description', ' توضیحات *')}}
                                        {{Form::textarea('description', null, array('class' => 'form-control','required'))}}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{Form::label('file', 'پیوست')}}
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="gallery" name="attachs[]" multiple>
                                                <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                            </div>
                                        </div>
                                        <p class="text-danger">_<small>حداکثر سایز هر پیوست 10Mb می باشد</small></p>
                                    </div>
                                </div>

                                <div class="col-md-12 text-left">
                                    <hr/>
                                </div>
                            </div>
                            <a href="{{ URL::previous() }}" class="btn btn-rounded btn-outline-warning float-right"><i class="fa fa-chevron-circle-right ml-1"></i>بازگشت</a>
                            {{ Form::button('<i class="fa fa-circle-o mtp-1 ml-1"></i>افزودن', array('type' => 'submit', 'class' => 'btn btn-outline-success float-left')) }}
                            {{ Form::close() }}
                        </div>
                        <!-- /.card-body -->
                    </div><!-- /.card -->
                </div>
            </div>
        </div>
    </section>

@endsection

