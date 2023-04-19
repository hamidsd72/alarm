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
                            {{ Form::model($item,array('route' => array('admin.items.update', $item->id), 'method' => 'PATCH', 'files' => true)) }}
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('section', '* سکشن') }}
                                        {{ Form::number('section',null, array('class' => 'form-control', 'required' => 'required')) }}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('position', '* محل قرارگیری') }}
                                        {{ Form::number('position',null, array('class' => 'form-control', 'required' => 'required')) }}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('sort', '* ترتیب') }}
                                        {{ Form::number('sort',null, array('class' => 'form-control', 'required' => 'required')) }}
                                    </div>
                                </div>
                                <div class="col-lg-10 col-md-8">
                                    <div class="form-group">
                                        {{ Form::label('title', '* عنوان') }}
                                        {{ Form::text('title',null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-md">
                                    <div class="form-group">
                                        {{ Form::label('status', '* وضعیت') }}
                                        <select name="status" class="form-control">
                                            <option value="active" {{ $item->sort=='active' ? 'selected' : '' }}>فعال</option>
                                            <option value="pending" {{ $item->sort=='pending' ? 'selected' : '' }}>غیر فعال</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        {{ Form::label('text', 'متن') }}
                                        {{ Form::textarea('text',null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <label for="exampleInputFile">تصویر کارت</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile" name="pic" accept=".jpeg,.jpg,.png">
                                            <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                        </div>
                                    </div>
                                </div>
                                @if($item->pic!=null)
                                    <div class="col-lg-4 col-md-6">
                                        <img src="{{url($item->pic)}}" class="mt-2" height="100">
                                    </div>
                                @endif
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
                        <!-- /.card-body -->
                    </div><!-- /.card -->
                </div>
            </div>
        </div>
    </section>

@endsection
@section('js')
    <script>
        slug('#title', '#slug');
    </script>
@endsection