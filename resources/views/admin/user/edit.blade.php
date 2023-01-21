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
                            <div class="text-center">
                                {{-- <img class="profile-user-img img-circle" src="{{$item->photo? url($item->photo->path):asset('admin/img/user.png')}}" alt="User profile picture"> --}}
                                <img class="profile-user-img img-circle" src="{{$item->photo? url($item->photo->path):'https://img.icons8.com/ultraviolet/100/000000/test-account.png'}}" alt="User profile picture">
                            </div>
                            <hr>
                            {{ Form::model($item,array('route' => array('admin.user.update', $item->id), 'method' => 'POST', 'files' => true)) }}
                            <div class="row">
                                @if ( auth()->user()->hasRole('مدیر ارشد') )
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('company_name', '* عنوان شرکت یا مشتری') }}
                                            {{ Form::text('company_name',null, array('class' => 'form-control' , 'readonly')) }}
                                        </div>
                                    </div>
                                @endif
                                <div class="col-lg-6"> 
                                    <div class="form-group">
                                        {{ Form::label('first_name', '* نام') }}
                                        {{ Form::text('first_name',null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('last_name', '* نام خانوادگی') }}
                                        {{ Form::text('last_name',null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('mobile', '* موبایل') }}
                                        {{ Form::text('mobile',null, array('class' => 'form-control text-left')) }}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('email', '* ایمیل') }}
                                        {{ Form::text('email',null, array('class' => 'form-control text-left' )) }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('whatsapp', ' شماره واتساپ فعال') }}
                                        {{ Form::text('whatsapp',null, array('class' => 'form-control text-left')) }}
                                    </div>
                                </div>
                                @unless ( auth()->user()->hasRole('مدیر ارشد') )
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('date_birth', ' تاریخ تولد') }}
                                            {{ Form::text('date_birth',null, array('class' => 'form-control date_p' , 'readonly')) }}
                                            <img class="inline-left-logo" src="https://img.icons8.com/external-icematte-lafs/40/000000/external-Calendar-it-icematte-lafs.png">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            {{ Form::label('employee_id', ' شماره پرسنلی') }}
                                            {{ Form::text('employee_id',null, array('class' => 'form-control text-left')) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('join_date', ' تاریخ استخدام') }}
                                            {{ Form::text('join_date',null, array('class' => 'form-control date_p' , 'readonly')) }}
                                            <img class="inline-left-logo" src="https://img.icons8.com/external-icematte-lafs/40/000000/external-Calendar-it-icematte-lafs.png">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('state_id', '* استان') }}
                                            {{ Form::select('state_id' , Illuminate\Support\Arr::pluck($states,'name','id') , null, array('class' => 'form-control select2')) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('city_id', '* شهر') }}
                                            {{ Form::select('city_id' , Illuminate\Support\Arr::pluck($citys,'name','id') , null, array('class' => 'form-control select2')) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('locate', '* منطقه') }}
                                            {{ Form::text('locate',null, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('reagent_code', 'حقوق (عدد لاتین)') }}
                                            {{ Form::number('reagent_code',null, array('class' => 'form-control','onkeyup'=>'number_price(this.value)','placeholder' => 'ساعتی 80000 تومان')) }}
                                            <span id="price_span" class="span_p"><span id="pp_price"></span> تومان </span>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            {{ Form::label('address', '* آدرس') }}
                                            {{ Form::text('address',null, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            {{ Form::label('education', ' مدرک تحصیلی') }}
                                            {{ Form::text('education',null, array('class' => 'form-control')) }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="exampleInputFile">تصویر پروفایل(100×100)</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile" name="photo" accept=".jpeg,.jpg,.png">
                                                <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                            </div>
                                        </div>
                                    </div>
                                @endunless
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('password', 'پسورد') }}
                                        {!! Form::password('password', ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {{ Form::label('password_confirmation', 'تکرار پسورد') }}
                                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    {{ Form::button('ویرایش', array('type' => 'submit', 'class' => 'btn btn-info col-12')) }}
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
        @if(old('city_id'))
        $(document).ready(function () {
            $.get("{{url('/')}}/city-ajax/" + $('#state_id').val(), function (data, status) {
                $('select[name=city_id]').empty();
                var old='{{old('city_id')}}';
                $.each(data, function (key, value) {
                    if(old==value.id)
                    {
                        $('select[name=city_id]').append('<option selected value="' + value.id + '">' + value.name + '</option>');
                    }
                    else
                    {
                        $('select[name=city_id]').append('<option value="' + value.id + '">' + value.name + '</option>');
                    }
                });
                $('select[name=city_id]').trigger('change');
            });
        })
        @endif
    </script>

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
<script>
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