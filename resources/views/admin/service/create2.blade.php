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
                            {{ Form::open(array('route' => 'admin.service.store', 'method' => 'POST', 'files' => true)) }}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('category_id', '* دسته بندی خدمت') }}
                                        {{ Form::select('category_id' , Illuminate\Support\Arr::pluck($items,'title','id') , null, array('class' => 'form-control select2')) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="service_type" >نوع خدمت</label>
                                        <select id="service_type" name="service_type" class="form-control">
                                            <option value="جلسات عمومی"  selected>(رایگان) جلسات عمومی</option>
                                            <option value="مشاوره اختصاصی" >مشاوره اختصاصی</option>
                                            <option value="عریضه نویسی" >عریضه نویسی</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('title', '* نام خدمت') }}
                                        {{ Form::text('title',null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('slug', '* نامک') }}
                                        {{ Form::text('slug',null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        {{ Form::label('time_start', '* ساعت شروع ') }}
                                        {{ Form::dateTimeLocal('time_start',null, array('class' => 'form-control text-left')) }}
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        {{ Form::label('time_end', '* ساعت پایان ') }}
                                        {{ Form::dateTimeLocal('time_end',null, array('class' => 'form-control text-left')) }}
                                    </div>
                                </div>
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        {{-- {{ Form::label('limited', '* محدودیت (هر بار برای چند روز)') }} --}}
                                        {{ Form::label('limited', '* ظرفیت') }}
                                        {{ Form::number('limited',null, array('class' => 'form-control text-left')) }}
                                    </div>
                                </div>
                                 <div class="col-lg-3 col-6">
                                     <div class="form-group">
                                         {{ Form::label('time', '* زمان (دقیقه)') }}
                                         {{ Form::number('time',null, array('class' => 'form-control text-left')) }}
                                     </div>
                                 </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('price', '* هزینه') }}
                                        {{ Form::number('price',null, array('class' => 'form-control','onkeyup'=>'number_price(this.value)')) }}
                                        <span id="price_span" class="span_p"><span id="pp_price"></span> تومان </span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="exampleInputFile">* تصویر(500×500)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="photo" accept=".jpeg,.jpg,.png">
                                            <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{ Form::label('video_link', '* لینک ویدیو') }}
                                        {{ Form::text('video_link',null, array('class' => 'form-control','onkeyup'=>'number_price(this.value)')) }}
                                    </div>
                                </div>

                            </div>
                            <a href="{{ URL::previous() }}" class="btn btn-rounded btn-outline-warning "><i class="fa fa-chevron-circle-right ml-1"></i>بازگشت</a>
                            {{ Form::button('<i class="fa fa-circle-o mtp-1 ml-1"></i>افزودن', array('type' => 'submit', 'class' => 'btn btn-outline-success mr-3')) }}
                            {{ Form::close() }}
                        </div> 
                        <!-- /.card-body -->
                    </div><!-- /.card -->
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
