@extends('layouts.admin')
@section('css')

@endsection
@section('content')
    <style> #packages , #services , #roles { display: none; } </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            {{ Form::open(array('route' => 'admin.notification.store', 'method' => 'POST', 'files' => true)) }}
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="type" >* ارسال اعلان را انتخاب کنید</label>
                                        <select id="type" name="type" onchange="changeInput()" class="form-control">
                                            <option value="single" selected>ارسال به یک کاربر</option>
                                            <option value="package">ارسال به کاربر یک فعالیت</option>
                                            <option value="role">ارسال به کاربران سمت یا گروه کاربری </option>
                                            {{-- <option value="service">ارسال به کاربران یک گروه وبینار</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="mobilePhone">
                                    <div class="form-group">
                                        {{Form::label('user_id', ' موبایل کاربر *')}}
                                        <select id="user_id" name="user_id" class="form-control select2">
                                            @foreach ($users as $key => $item)
                                                <option value="{{$item->mobile}}" @if($key==0) selected @endif>{{$item->first_name.' '.$item->last_name}}</option>
                                            @endforeach
                                        </select>
                                        {{-- {{Form::text('user_id', null, array('class' => 'form-control','placeholder' => 'شماره موبایل کامل به لاتین'))}} --}}
                                    </div>
                                </div>
                                <div class="col-lg-6" id="packages">
                                    <div class="form-group">
                                        <label for="package" >کاربران فعالیت ها *</label>
                                        <select id="package" name="package" class="form-control select2">
                                            @foreach ($packages as $item)
                                                @if ($item->packageName())
                                                    <option value="{{$item->id}}">{{$item->packageName()->title.'-'.$item->id}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="services">
                                    <div class="form-group">
                                        <label for="service" >گروه های مشاوره *</label>
                                        <select id="service" name="service" class="form-control select2">
                                            @foreach ($services as $key => $item)
                                                <option value="{{$item->id}}" @if($key==0) selected @endif>{{$item->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6" id="roles">
                                    <div class="form-group">
                                        <label for="role_name" >سمت ها و گروه های کاربری *</label>
                                        <select id="role_name" name="role_name" class="form-control select2">
                                            @foreach ($roles as $key => $item)
                                                @unless($item->name=='مدیر ارشد')
                                                    <option value="{{$item->name}}" {{ $key==0?'selected':''}}>{{$item->name}}</option>
                                                @endunless
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{Form::label('subject', ' عنوان اعلان *')}}
                                        {{Form::text('subject', null, array('class' => 'form-control','required'))}}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{Form::label('description', ' توضیحات اعلان *')}}
                                        {{Form::textarea('description', null, array('class' => 'form-control','required'))}}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{Form::label('file', 'پیوست')}}
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="attach" name="attach">
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
                            <div class="row my-3">
                                <div class="col">
                                    {{ Form::button('ارسال اعلان', array('type' => 'submit', 'class' => 'btn btn-success col-12')) }}
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        $(function(){
            $("input[name='user_id']").on('input', function (e) {
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
            });
        });
    </script>
    <script>
        function changeInput() {
            if (document.getElementById("type").value=='single') {
                document.getElementById("packages").style.display = "none";
                document.getElementById("services").style.display = "none";
                document.getElementById("roles").style.display = "none";
                document.getElementById("mobilePhone").style.display = "block";

            } else if (document.getElementById("type").value=='package') {
                document.getElementById("mobilePhone").style.display = "none";
                document.getElementById("services").style.display = "none";
                document.getElementById("roles").style.display = "none";
                document.getElementById("packages").style.display = "block";

            } else if (document.getElementById("type").value=='service') {
                document.getElementById("mobilePhone").style.display = "none";
                document.getElementById("packages").style.display = "none";
                document.getElementById("roles").style.display = "none";
                document.getElementById("services").style.display = "block";

            } else if (document.getElementById("type").value=='role') {
                document.getElementById("mobilePhone").style.display = "none";
                document.getElementById("packages").style.display = "none";
                document.getElementById("services").style.display = "none";
                document.getElementById("roles").style.display = "block";
            }
        }
    </script>
@endsection

