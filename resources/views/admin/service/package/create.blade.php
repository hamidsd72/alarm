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
                            {{ Form::open(array('route' => 'admin.service.package.store', 'method' => 'POST', 'files' => true)) }}
                            <div class="row">
                                {{-- <div class="col-sm-12">
                                    <div class="form-group">
                                        {{ Form::label('service', '* خدمت') }}
                                        <select class="form-control select2" name="service[]" multiple>
                                            @foreach($items as $item)
                                                <option value="{{$item->id}}" {{old('service') && in_array($item->id,old('service'))?'selected':''}}>{{$item->title}}({{$item->category?$item->category->title:'_'}})</option>
                                            @endforeach
                                        </select>
                                       {{ Form::select('service[]' , Illuminate\Support\Arr::pluck($items,'title','id') , null, array('class' => 'form-control select2','multiple')) }}
                                    </div>
                                </div> --}}
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('user_id', 'کارمند') }}
                                        <select class="form-control" name="user_id" id="user_id">
                                            @foreach ($items as $key => $item)
                                                <option value="{{$item->id}}" @if ($key==0) selected @endif>{{$item->first_name.' '.$item->last_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <div class="form-group">
                                        <div class="col-12 font-weight-bold mb-3">
                                            فعالیت خارج از شهر
                                        </div>
                                        <label class="switch-wrap switch-success ml-2">
                                            <input name="location_work" type="checkbox">
                                            <div class="switch"></div>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3">
                                    <div class="form-group">
                                        {{ Form::label('work_type', ' نوع سپردن فعالیت') }}
                                        <select class="form-control" name="work_type" id="work_type">
                                            <option value="پیمانکاری" selected>پیمانکاری</option>
                                            <option value="ساعتی" >ساعتی</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('title', ' عنوان فعالیت') }}
                                        <select class="form-control" name="title" id="title">
                                            @foreach ($jobs as $key => $job)
                                                <option value="{{$job->id}}" @if ($key==0) selected @endif>{{$job->title}}</option>
                                            @endforeach
                                        </select>
                                        {{-- {{ Form::text('title',null, array('class' => 'form-control', 'required' => 'required')) }} --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('started_at', '* تاریخ انجام کار') }}
                                        {{ Form::text('started_at',null, array('class' => 'form-control date_p')) }}
                                        <img class="inline-left-logo" src="https://img.icons8.com/external-icematte-lafs/40/000000/external-Calendar-it-icematte-lafs.png">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {{ Form::label('custom', 'مشتری') }}
                                        <select class="form-control" name="custom" id="custom">
                                            @foreach ($customs as $key => $custom)
                                                <option value="{{$custom->id}}" @if ($key==0) selected @endif>{{$custom->first_name.' '.$custom->last_name.' - '.$custom->text}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg col-md-6 d-none">
                                    <div class="form-group">
                                        {{ Form::label('slug', '* نامک ') }}
                                        {{ Form::text('slug',null, array('class' => 'form-control date_p')) }}
                                    </div>
                                </div>
{{--                                <div class="col-sm-6">--}}
{{--                                    <div class="form-group">--}}
{{--                                        {{ Form::label('limited', '* محدودیت (هر بار برای چند روز)') }}--}}
{{--                                        {{ Form::number('limited',null, array('class' => 'form-control text-left')) }}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                {{-- <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('sort_by', 'ترتیب نمایش') }}
                                        {{ Form::number('sort_by',null, array('class' => 'form-control text-left')) }}
                                    </div>
                                </div> --}}
                                {{-- <div class="col-lg-3">
                                    <div class="form-group">
                                        {{ Form::label('custom', 'پکیج ویژه') }}
                                        <input type="checkbox" name="custom" class="form-control">
                                    </div>
                                </div> --}}
{{--                                <div class="col-sm-3">--}}
{{--                                    <div class="form-group">--}}
{{--                                        {{ Form::label('custom_service_count', 'تعداد سرویس های دلخواه') }}--}}
{{--                                        {{ Form::number('custom_service_count',null, array('class' => 'form-control text-left')) }}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {{ Form::label('price', '* هزینه') }}
                                        {{ Form::number('price',null, array('class' => 'form-control','onkeyup'=>'number_price(this.value)')) }}
                                        <span id="price_span" class="span_p"><span id="pp_price"></span> تومان </span>
                                    </div>
                                </div>
                                
{{--                                <div class="col-sm-12">--}}
{{--                                    <div class="form-group">--}}
{{--                                        {{ Form::label('home_text', 'توضیحات صفحه اصلی') }}--}}
{{--                                        {{ Form::text('home_text',null, array('class' => 'form-control')) }}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                {{-- <div class="col-md-4">
                                    <label for="exampleInputFile">* تصویر کارت</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="pic_card" accept=".jpeg,.jpg,.png">
                                            <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputFile">تصویر دوم</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="photo" accept=".jpeg,.jpg,.png">
                                            <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                        </div> 
                                    </div>
                                </div> --}}
                                <div class="col-lg-4">
                                    {{-- <label for="exampleInputFile"> فایل pdf(حداکثر 30 مگابایت)</label> --}}
                                    <label for="exampleInputFile"> فایل (حداکثر 30 مگابایت)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="file">
                                            <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                        </div>
                                    </div>
                                    <p class="m-0">برای اطمینان از سلامت فایل ارسالی ,توصیه میشود از فایل زیپ استفاده کنید</p>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::label('text', '* توضیحات') }}
                                        {{ Form::textarea('text',null, array('class' => 'form-control textarea','onkeyup'=>'number_price(this.value)')) }}
                                    </div>
                                </div>
{{--                                <div class="col-sm-6 mb-2">--}}
{{--                                    <label for="exampleInputFile"> فایل pdf(حداکثر 30 مگابایت)</label>--}}
{{--                                    <div class="input-group">--}}
{{--                                        <div class="custom-file">--}}
{{--                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="file" accept=".pdf">--}}
{{--                                            <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-6 mb-2">--}}
{{--                                    <label for="exampleInputFile">ویدئو mp4(حداکثر 50 مگابایت)</label>--}}
{{--                                    <div class="input-group">--}}
{{--                                        <div class="custom-file">--}}
{{--                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="video" accept=".mp4">--}}
{{--                                            <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
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
    <script>
        $('.date_p').persianDatepicker({
            observer: true,
            format: 'YYYY/MM/DD',
            altField: '.observer-example-alt',
            initialValue:false,
        });
        $(document).ready(function () {
            $('select[name=state_id]').on('change', function () {
                $.get("{{url('/')}}/city-ajax/" + $(this).val(), function (data, status) {
                    $('select[name=city_id]').empty();
                    $.each(data, function (key, value) {
                        $('select[name=city_id]').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $('select[name=city_id]').trigger('change');
                });
            });
        });
    </script>
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

