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
                            {{-- {{ Form::model($item,array('route' => array('admin.setting.update', $item->id), 'method' => 'POST', 'files' => true)) }} --}}
                            {{ Form::open( array('route' => array('admin.setting.update', $item->id), 'method' => 'POST', 'files' => true)) }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('title', '* نام سایت') }}
                                            {{ Form::text('title',$item->title, array('class' => 'form-control', 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('keyword', 'کلمات کلیدی') }}
                                            {{ Form::text('keyword', $item->keyword, array('class' => 'form-control', 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('support_call', '* موبایل پشتیبانی') }}
                                            {{ Form::number('support_call', $item->support_call, array('class' => 'form-control text-left', 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('paginate', 'صفحه بندی') }}
                                            {{ Form::number('paginate', $item->paginate, array('class' => 'form-control', 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('sign_in_type', 'نوع ورود به حساب کاربران') }}
                                            <select name="sign_in_type" id="sign_in_type" class="form-control">
                                                <option value="sms" {{$item->paginate=='sms'?'selected':''}}>ورود با کد پیامکی</option>
                                                <option value="password" {{$item->paginate=='password'?'selected':''}}>ورود با رمز عبور</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('leave_day_limit', 'تعداد روز مرخصی در سال (میتواند خالی باشد)') }}
                                            {{ Form::number('leave_day_limit', $item->leave_day_limit, array('class' => 'form-control')) }}
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
                                            {{ Form::time('dailyStartTime', substr($item->dailyStartTime,0,8), array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('dailyFinishTime', 'ساعت پایان کار کارمندان') }}
                                            {{ Form::time('dailyFinishTime', substr($item->dailyFinishTime,0,8), array('class' => 'form-control' )) }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row border rounded mx-1 my-lg-3 p-md-3">
                                            روزهای تعطیل فعالیت خود را فعال کنید
                                            <br>
                                            در روزهای تعطیل ساعت کاری کارمندان ثبت نمیشود و درصورتیکه کارمند اضافه کاری انجام داده بود زمان کار و توضیحات مربوطه را از طریق درخواست ها برای ثبت در سیستم ارسال میکند
                                            <div class="col-lg-6">
                                                <div class="row mb-0 mt-3">
                                                    <div class="col">
                                                        <h6>شنبه</h6>
                                                        <label class="switch-wrap switch-success ml-2">
                                                            <input name="شنبه" type="checkbox" {{$shanbe}} >
                                                            <div class="switch"></div>
                                                        </label>
                                                    </div>
                                                    <div class="col">
                                                        <h6>یکشنبه</h6>
                                                        <label class="switch-wrap switch-success ml-2">
                                                            <input name="یکشنبه" type="checkbox" {{$yekshanbe}} >
                                                            <div class="switch"></div>
                                                        </label>
                                                    </div>
                                                    <div class="col">
                                                        <h6>دوشنبه</h6>
                                                        <label class="switch-wrap switch-success ml-2">
                                                            <input name="دوشنبه" type="checkbox" {{$doshanbe}} >
                                                            <div class="switch"></div>
                                                        </label>
                                                    </div>
                                                    <div class="col">
                                                        <h6>سه‌شنبه</h6>
                                                        <label class="switch-wrap switch-success ml-2">
                                                            <input name="سه‌شنبه" type="checkbox" {{$seshanbe}} >
                                                            <div class="switch"></div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row mb-0 mt-3">
                                                    <div class="col">
                                                        <h6>چهارشنبه</h6>
                                                        <label class="switch-wrap switch-success ml-2">
                                                            <input name="چهارشنبه" type="checkbox" {{$charshanbe}} >
                                                            <div class="switch"></div>
                                                        </label>
                                                    </div>
                                                    <div class="col">
                                                        <h6>پنجشنبه</h6>
                                                        <label class="switch-wrap switch-success ml-2">
                                                            <input name="پنجشنبه" type="checkbox" {{$panjshanbe}} >
                                                            <div class="switch"></div>
                                                        </label>
                                                    </div>
                                                    <div class="col">
                                                        <h6>جمعه</h6>
                                                        <label class="switch-wrap switch-success ml-2">
                                                            <input name="جمعه" type="checkbox" {{$jome}} >
                                                            <div class="switch"></div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            {{ Form::label('description', 'توضیحات سئو') }}
                                            {{ Form::text('description', $item->description, array('class' => 'form-control', 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exampleInputFile">تصویر لوگو(png)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile" name="logo_site" accept=".png">
                                                <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        @if(is_file($item->logo_site))
                                            <img src="{{url($item->logo_site)}}" class="mt-2" width="100">
                                        @endif
                                    </div>
                                    <div class="col-md-6 mt-2 mb-2">
                                        <label for="exampleInputFile">تصویر فاوآیکون(png)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile" name="icon_site" accept=".png">
                                                <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        @if(is_file($item->icon_site))
                                            <img src="{{url($item->icon_site)}}" class="mt-4" width="50">
                                        @endif
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col">
                                        {{ Form::button('وبرایش', array('type' => 'submit', 'class' => 'btn btn-success col-12')) }}
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