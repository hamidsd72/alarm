@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="https://cdn.map.ir/web-sdk/1.4.2/css/mapp.min.css">
<link rel="stylesheet" href="https://cdn.map.ir/web-sdk/1.4.2/css/fa/style.css">
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            {{ Form::open(array('route' => 'admin.marketer.store', 'method' => 'POST', 'files' => true)) }}
                                <div class="row">
                                    <div class="col-md-6 col-lg-2">
                                        <div class="form-group">
                                            {{ Form::label('company_name', 'نوع قرارداد') }}
                                            <select class="form-control" name="company_name" id="company_name">
                                                <option value="حقیقی" selected>حقیقی</option>
                                                <option value="حقوقی">حقوقی</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-5">
                                        <div class="form-group">
                                            {{ Form::label('first_name', '* نام') }}
                                            {{ Form::text('first_name',null, array('class' => 'form-control', 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-5">
                                        <div class="form-group">
                                            {{ Form::label('last_name', '* نام خانوادگی') }}
                                            {{ Form::text('last_name',null, array('class' => 'form-control', 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('phone', '* تلفن') }}
                                            {{ Form::text('phone',null, array('class' => 'form-control text-left', 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('mobile', '* موبایل') }}
                                            {{ Form::text('mobile',null, array('class' => 'form-control text-left', 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 d-none">
                                        <div class="form-group">
                                            {{ Form::label('long_lat', ' نقشه') }}
                                            {{ Form::text('long_lat',null, array('class' => 'form-control', 'placeholder' => 'با کلیک روی نقشه انتخاب کنید')) }}
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('email', '* ایمیل') }}
                                            {{ Form::text('email',null, array('class' => 'form-control text-left' )) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('whatsapp', '* شماره واتساپ فعال') }}
                                            {{ Form::text('whatsapp',null, array('class' => 'form-control text-left')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('date_birth', '* تاریخ تولد') }}
                                            {{ Form::text('date_birth',null, array('class' => 'form-control text-left date_p' , 'readonly')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('state_id', '* استان') }}
                                            {{ Form::select('state_id' , Illuminate\Support\Arr::pluck($states,'name','id') , null, array('class' => 'form-control select2')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('city_id', '* شهر') }}
                                            {{ Form::select('city_id' , [] , null, array('class' => 'form-control select2')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('locate', '* منطقه') }}
                                            {{ Form::text('locate',null, array('class' => 'form-control')) }}
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('city', '* شهر') }}
                                            {{ Form::text('city',null, array('class' => 'form-control', 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('locate', '* منطقه') }}
                                            {{ Form::text('locate',null, array('class' => 'form-control', 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            {{ Form::label('address', '* آدرس') }}
                                            {{ Form::text('address',null, array('class' => 'form-control', 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            {{ Form::label('text', '* توضیحات') }}
                                            {{ Form::text('text',null, array('class' => 'form-control', 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    {{-- <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('education', '* مدرک تحصیلی') }}
                                            {{ Form::text('education',null, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="exampleInputFile">تصویر پروفایل(100×100)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile" name="photo" accept=".jpeg,.jpg,.png">
                                                <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('password', '* پسورد') }}
                                            {!! Form::password('password', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('password_confirmation', '* تکرار پسورد') }}
                                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('abbreviation_agent', 'نمایندگی') }}
                                            {{ Form::select('abbreviation_agent' ,[" "=>"بدونه نمایندگی"]+ Illuminate\Support\Arr::pluck($agents,'company_name','abbreviation') , null, array('class' => 'form-control select2')) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('discount', 'درصد بازاریابی') }}
                                            {!! Form::number('discount', null,['class' => 'form-control']) !!}
                                        </div>
                                    </div> --}}
                                    <div class="col-6 mt-3">
                                        {{ Form::button('افزودن', array('type' => 'submit', 'class' => 'btn btn-success col-12')) }}
                                    </div>
                                    <div class="col-6 mt-3">
                                        <a href="{{ URL::previous() }}" class="btn btn-secondary col-12">بازگشت</a>
                                    </div>
                                </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
                <div class="col-lg">
                    <div id="app" style="height: 600px"></div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('js')
<script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/mapp.env.js"></script>
<script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/mapp.min.js"></script>
<script>
    $(document).ready(function() {
    var app = new Mapp({
        element: '#app',
        presets: {
        latlng: {
            lat: @json($lat),
            lng: @json($lng)
        },
        zoom: 10
        },
        apiKey: @json($map_api_key)
    });
    app.addLayers();
    app.addZoomControls();
    app.map.on('click', function(e) {
        app.findReverseGeocode({
        state: {
            latlng: {
            lat: e.latlng.lat,
            lng: e.latlng.lng
            },
            zoom: 16
        },
        after: function(data) {
            $("#long_lat").val(`${e.latlng.lat},${e.latlng.lng}`);
            app.addMarker({
            name: 'advanced-marker',
            latlng: {
                lat: e.latlng.lat,
                lng: e.latlng.lng
            },
            icon: app.icons.red,
            popup: {
                title: {
                i18n: 'آدرس '
                },
                description: {
                i18n: data.address
                },
                class: 'marker-class',
                open: true
            }
            });
        }
        });
    });
});
</script>
    <script>
        $('.date_p').persianDatepicker({
            observer: true,
            format: 'YYYY/MM/DD',
            altField: '.observer-example-alt',
            initialValue:false,
        });
    </script>
@endsection