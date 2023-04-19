@extends('layouts.admin')
<link rel="stylesheet" href="https://cdn.map.ir/web-sdk/1.4.2/css/mapp.min.css">
<link rel="stylesheet" href="https://cdn.map.ir/web-sdk/1.4.2/css/fa/style.css">
@section('css')
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            {{ Form::model($item,array('route' => array('admin.marketer.update', $item->id), 'method' => 'POST', 'files' => true)) }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('company_name', 'نوع قرارداد') }}
                                            <select class="form-control" name="company_name" id="company_name">
                                                <option value="حقیقی" {{$item->company_name=='حقیقی'?'selected':''}} >حقیقی</option>
                                                <option value="حقوقی" {{$item->company_name=='حقوقی'?'selected':''}}>حقوقی</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('show', 'نمایش اطلاعات تماس به مجری') }}
                                            <select class="form-control" name="show" id="show">
                                                <option value="show" {{$item->show=='show'?'selected':''}} >نمایش</option>
                                                <option value="hide" {{$item->show=='hide'?'selected':''}}>عدم نمایش</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{ Form::label('first_name', '* نام') }}
                                            {{ Form::text('first_name',null, array('class' => 'form-control', 'required' => 'required')) }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
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
                                            <input type="text" name="long_lat" id="long_lat" class="form-control" value="{{$item->long_lat}}">
                                        </div>
                                    </div>
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
                                    <div class="col-6 mt-3">
                                        {{ Form::button('ویرایش', array('type' => 'submit', 'class' => 'btn btn-success col-12')) }}
                                    </div>
                                    <div class="col-6 mt-3">
                                        <a href="{{ URL::previous() }}" class="btn btn-secondary col-12">انصراف</a>
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
    app.markReverseGeocode({
        state: {
            latlng: {
                lat: @json($lat),
                lng: @json($lng),
            },
            zoom: 16,
        },
    });
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
@endsection


{{-- app.addGeolocation({
    history: true,
    onLoad: true,
    onLoadCallback: function(){
        console.log(app.states.user.latlng);
    },
}); --}}