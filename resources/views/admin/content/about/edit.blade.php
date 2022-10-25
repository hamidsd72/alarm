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
                            {{ Form::model($item,array('route' => array('admin.about.update', $item->id), 'method' => 'PATCH', 'files' => true)) }}
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('title_home', '* عنوان درباره ما(صفحه اصلی)') }}
                                        {{ Form::text('title_home',null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                </div>

                                <div class="col-sm-6">
                                    <label for="exampleInputFile">تصویر درباره ما(صفحه اصلی)</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="pic_home" accept=".jpg,.png">
                                            <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    @if(is_file($item->pic_home))
                                        <img src="{{url('/'.$item->pic_home)}}" class="mt-2" height="100">
                                    @endif
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{ Form::label('text_home', '* توضیحات درباره ما(صفحه اصلی)') }}
                                        {{ Form::textarea('text_home',null, array('class' => 'form-control textarea')) }}
                                    </div>
                                </div>

                                <div class="d-none">
                                    {{ Form::text('title_target',null, array('class' => 'form-control')) }}
                                    {{ Form::textarea('text_target',null, array('class' => 'form-control textarea')) }}
                                    {{ Form::text('title',null, array('class' => 'form-control')) }}
                                    <input type="file" class="custom-file-input" id="exampleInputFile" name="pic" accept=".jpg,.png">
                                    @if(is_file($item->pic))
                                    <img src="{{url($item->pic)}}" class="mt-2" height="100">
                                    @endif
                                    {{ Form::textarea('text',null, array('class' => 'form-control textarea')) }}
                                    @if(count($items)>0)
                                        @foreach($items as $val)
                                            {{ Form::text('title_join[]',$val->title, array('class' => 'form-control')) }}
                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="pic_join[]" accept=".jpg,.png">
                                            <input name="pic_join1[]" value="{{$val->pic}}" hidden>
                                            {{ Form::textarea('text_join[]',$val->text, array('class' => 'form-control textarea')) }}
                                        @endforeach
                                    @endif
                                </div>

                                {{--  
                                <div class="col-sm-12">
                                    <h5 class="text-center mb-2 mt-2"> اهداف ما صفحه اصلی</h5>
                                    <hr>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('title_target', '* عنوان اهداف ما(صفحه اصلی)') }}
                                        {{ Form::text('title_target',null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{ Form::label('text_target', '* توضیحات اهداف ما(صفحه اصلی)') }}
                                        {{ Form::textarea('text_target',null, array('class' => 'form-control textarea')) }}
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <h5 class="text-center mb-2 mt-2">صفحه درباره ما</h5>
                                    <hr>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('title', '* عنوان درباره ما') }}
                                        {{ Form::text('title',null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                </div>

                                <div class="col-sm-6">
                                    <label for="exampleInputFile">تصویر درباره ما</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="pic" accept=".jpg,.png">
                                            <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    @if(is_file($item->pic))
                                        <img src="{{url($item->pic)}}" class="mt-2" height="100">
                                    @endif
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{ Form::label('text', '* توضیحات درباره ما') }}
                                        {{ Form::textarea('text',null, array('class' => 'form-control textarea')) }}
                                    </div>
                                </div>
                            </div>
                            @if(count($items)>0)
                                @foreach($items as $val)
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <a  href="javascript:void(0);" onclick="del_row('{{$val->id}}')" class="btn btn-outline-danger float-left">× حذف</a>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                {{ Form::label('title_join', '* عنوان') }}
                                                {{ Form::text('title_join[]',$val->title, array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                        </div>

                                        <div class="col-sm-6">
                                            <label for="exampleInputFile">تصویر</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="exampleInputFile" name="pic_join[]" accept=".jpg,.png">
                                                    <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                                </div>
                                            </div>
                                            <input name="pic_join1[]" value="{{$val->pic}}" hidden>
                                        </div>
                                        <div class="col-sm-6">
                                            @if(is_file($val->pic))
                                                <img src="{{url($val->pic)}}" class="mt-2" height="100">
                                            @endif
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                {{ Form::label('text_join', '* توضیحات') }}
                                                {{ Form::textarea('text_join[]',$val->text, array('class' => 'form-control textarea')) }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                            <div class="row" id="append">

                            </div>
                            <div class="w-100">
                                <a href="javascript:void(0);" id="add_append" class="btn btn-primary my-3 float-left">+ افزودن فرم دیگر</a>
                            </div>
                             --}}
                            <br/>
                            <br/>
                            <br/>
                            <br/>
                            <div class="col-6">
                                {{ Form::button('ویرایش', array('type' => 'submit', 'class' => 'btn btn-success col-12')) }}
                            </div>
                            <div class="col-6">
                                <a href="{{ URL::previous() }}" class="btn btn-secondary col-12">بازگشت</a>
                            </div>
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

        function del_row(id) {
            Swal.fire({
                text: 'برای حذف مطمئن هستید؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = '{{url('/')}}/admin/about-destroy/'+id;
                }
            })
        }

        $('#add_append').click(function () {
            $('#append').append('<div class="col-sm-12"><hr></div><div class="col-sm-6">\n' +
                '                                    <div class="form-group">\n' +
                '                                        {{ Form::label('title_join', '* عنوان') }}\n' +
                '                                        {{ Form::text('title_join[]',null, array('class' => 'form-control')) }}\n' +
                '                                    </div>\n' +
                '                                </div>\n' +
                '                                <div class="col-sm-6">\n' +
                '                                </div>\n' +
                '\n' +
                '                                <div class="col-sm-6">\n' +
                '                                    <label for="exampleInputFile">تصویر</label>\n' +
                '                                    <div class="input-group">\n' +
                '                                            <input type="file" name="pic_join[]" accept=".jpg,.png">\n' +
                '                                    </div>\n' +
                '                                </div>\n' +
                '                                <div class="col-sm-6">\n' +
                '                                </div>\n' +
                '                                <div class="col-sm-12">\n' +
                '                                    <div class="form-group">\n' +
                '                                        {{ Form::label('text_join', '* توضیحات') }}\n' +
                '                                        {{ Form::textarea('text_join[]',null, array('class' => 'form-control textarea')) }}\n' +
                '                                    </div>\n' +
                '                                </div>')
            $('.textarea').ckeditor(textareaOptions);
        })
    </script>
@endsection