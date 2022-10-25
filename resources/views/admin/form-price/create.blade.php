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
                            {{ Form::open(array('route' => 'admin.form-price.store', 'method' => 'POST', 'files' => true)) }}
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('type', 'نوع') }}
                                        <select class="form-control" name="type" id="type">
                                            <option value="package" selected>بسته</option>
                                            <option value="user">کاربر</option>
                                            <option value="sms">پیامک</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('form_name', '* عنوان') }}
                                        {{ Form::text('form_name',null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('month', '* بسته چند ماهه') }}
                                        {{ Form::number('month',null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('amount', '* مبلغ') }}
                                        {{ Form::number('amount',null, array('class' => 'form-control','onkeyup'=>'number_price(this.value)')) }}
                                        <span id="price_span" class="span_p"><span id="amount_price"></span> تومان </span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('off_amount', 'مبلغ با تخفیف') }}
                                        {{ Form::number('off_amount',null, array('class' => 'form-control','onkeyup'=>'number_price2(this.value)')) }}
                                        <span id="price_span" class="span_p"><span id="off_amount_price"></span> تومان </span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('background', 'رنگ بک گراند') }}
                                        {{ Form::color('background',null, array('class' => 'w-100 d-block')) }}
                                    </div>
                                </div>
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
                        <!-- /.card-body -->
                    </div><!-- /.card -->
                </div>
            </div>
        </div>
    </section>

@endsection
@section('js')
    <script>
        function number_price(a){
            $('#amount_price').text(a);
            $('#amount_price_1').text(a);
            $('#amount_price').text(function (e, n) {
                var lir1= n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                return lir1;
            })
        }
        function number_price2(a){
            $('#off_amount_price').text(a);
            $('#off_amount_price_1').text(a);
            $('#off_amount_price').text(function (e, n) {
                var lir1= n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                return lir1;
            })
        }
    </script>
@endsection