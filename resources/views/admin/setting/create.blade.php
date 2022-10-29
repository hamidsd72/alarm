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
                            {{ Form::open(array('route' => 'admin.setting.store', 'method' => 'POST', 'files' => true)) }}
                                <div class="row">
                                    <input type="hidden" name="id" value="{{$id}}">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('full_name', 'نام کامل متصدی فروشگاه') }}
                                            {{ Form::text('full_name',$full_name, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('title', '* نام سایت') }}
                                            {{ Form::text('title',null, array('class' => 'form-control' , 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('keyword', 'کلمات کلیدی') }}
                                            {{ Form::text('keyword',null, array('class' => 'form-control' , 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('support_call', '* موبایل پشتیبانی') }}
                                            {{ Form::number('support_call',null, array('class' => 'form-control text-left', 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('paginate', 'صفحه بندی') }}
                                            {{ Form::number('paginate',null, array('class' => 'form-control' , 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('sign_in_type', 'نوع ورود به حساب کاربران') }}
                                            <select name="sign_in_type" id="sign_in_type" class="form-control">
                                                <option value="sms" selected>ورود با کد پیامکی</option>
                                                <option value="password">ورود با رمز عبور</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('leave_day_limit', 'تعداد روز مرخصی در سال (میتواند خالی باشد)') }}
                                            {{ Form::number('leave_day_limit', null, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="col-12 text-secondary">
                                        ساعت کاری چیست ؟
                                        <br>
                                        درصورتی که تمایل دارید ساعت کار کارمندان به
                                        ( عنوان مثال) 
                                         از ساعت ۸ صبح تا ۱۴ بعدازظهر محاسبه شود محدوده زمانی را در باکس های پایین وارد کنید محدوده زمان برای فقط در شروع و یا فقط در پایان نیز قابل تنظیم میباشد
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('dailyStartTime', 'ساعت شروع کار کارمندان') }}
                                            {{ Form::time('dailyStartTime', null, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('dailyFinishTime', 'ساعت پایان کار کارمندان') }}
                                            {{ Form::time('dailyFinishTime', null, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            {{ Form::label('description', 'توضیحات سئو') }}
                                            {{ Form::text('description',null, array('class' => 'form-control' , 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="exampleInputFile">تصویر لوگو سایت(png)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile" name="logo_site" accept=".png">
                                                <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="exampleInputFile">تصویر فاوآیکون سایت(png)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile" name="icon_site" accept=".png">
                                                <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                            </div>
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
    <script src="{{ asset('editor/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('editor/laravel-ckeditor/adapters/jquery.js') }}"></script>
    <script>
        var textareaOptions = {
            filebrowserImageBrowseUrl: '{{ url('filemanager?type=Images') }}',
            filebrowserImageUploadUrl: '{{ url('filemanager/upload?type=Images&_token=') }}',
            filebrowserBrowseUrl: '{{ url('filemanager?type=Files') }}',
            filebrowserUploadUrl: '{{ url('filemanager/upload?type=Files&_token=') }}',
            language: 'fa'
        };
        $('.textarea').ckeditor(textareaOptions);
        slug('#title', '#slug');

        function number_price(a){
            $('#pp_price').text(a);
            $('#pp_price_1').text(a);
            $('#pp_price').text(function (e, n) {
                var lir1= n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                return lir1;
            })
        }
        $(document).ready(function () {
            var a=$('#price').val();
            $('#pp_price').text(a);
            $('#pp_price_1').text(a);
            $('#pp_price').text(function (e, n) {
                var lir1= n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                return lir1;
            })
        });
    </script>
@endsection