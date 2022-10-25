@extends('layouts.admin')
@section('css')
    <style>
        .price_box
        {
            position: fixed;
            bottom: 0;
            left: 0;
            padding: 10px 20px;
            border-radius: 3px;
            box-shadow: 0 0 2px 1px #d6d6d6;
            background: #fff;
            z-index: 99;
        }
        .mb-100px
        {
            margin-bottom: 100px!important;
        }
    </style>
@endsection
@section('content')
    <section class="content mb-100px">
        <div class="container-fluid">
            <div class="row">
                    <div class="col-12">
                        <div class="card res_table">
                            <div class="card-header">
                                <h3 class="card-title text-right">{{$title2}}</h3>
                                @role('مدیر')
                                    <div class="container mt-3 border rounded p-3">
                                        <h5 class="text-right">جستجو</h5>
                                        <hr>
                                        {{ Form::open(array('route' => 'admin.report.transaction.search', 'method' => 'get')) }}
                                            <div class="row mb-2">
                                                <div class="col-lg col-sm-6 mb-3">
                                                    {{ Form::text('mobile',null, array('class' => 'form-control text-left','placeholder'=>'موبایل کاربر')) }}
                                                </div>
                                                <div class="col-lg col-sm-6 mb-3">
                                                    {{ Form::text('code_bank',null, array('class' => 'form-control text-left','placeholder'=>'کد پیگیری بانک')) }}
                                                </div>
                                                {{-- <div class="col-md-3 col-sm-6 mb-2">
                                                    {{ Form::text('code_factor',isset($_GET['code_factor']) && !is_null($_GET['code_factor'])?$_GET['code_factor']:'', array('class' => 'form-control text-left','placeholder'=>'کد پیگیری سفارش')) }}
                                                </div> --}}
                                                <div class="col-lg col-sm-6 mb-3">
                                                    {{ Form::select('status' , [true=>'پرداخت موفق',false=>'پرداخت ناموفق'] ,null, array('class' => 'form-control')) }}
                                                </div>
                                                {{-- <div class="col-md-3 col-sm-6 mb-2">
                                                    {{ Form::select('order' , [null=>'مبلغ','desc'=>'بیشترین','asc'=>'کمترین'] , isset($_GET['order']) && !is_null($_GET['order'])?$_GET['order']:'', array('class' => 'form-control select2')) }}
                                                </div> --}}
                                            </div>
                                        <div class="row mb-2">
                                            <div class="col-12">
                                                @if(\Request::route()->getName()=='admin.report.transaction.search')
                                                    <a href="{{route('admin.report.transaction.list')}}" class="btn btn-rounded btn-outline-warning float-right"><i class="fa fa-chevron-circle-right ml-1"></i>همه تراکنش ها</a>
                                                @endif
                                                {{ Form::button('جستجو', array('type' => 'submit', 'class' => 'btn btn-info float-left')) }}
                                            </div>
                                        </div>
                                        {{ Form::close() }}
                                    </div>
                                @endrole
                            </div>
                            <div class="card-body res_table_in">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>مبلغ</th>
                                        <th>کاربر</th>
                                        <th>نوع خرید</th>
                                        <th>شرح خرید</th>
                                        @role('مدیر')
                                            <th>خرید</th>
                                            <th>کد پیگیری بانک </th>
                                            <th>کد پیگیری آیتم</th>
                                            <th>کد پیگیری سفارش</th>
                                            <th>شماره کارت</th>
                                        @endrole
                                        <th>زمان</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($items->count())
                                    @foreach($items as $item)
                                    <tr>
                                        <td>@item(number_format($item->amount)) ریال</td>
                                        <td>@if($item->user) @item($item->user->first_name) @item($item->user->last_name) <br> موبایل :  @item($item->user->mobile) @else ___ @endif</td>
                                        <td>@if($item->type=="buy_form") خرید فرم @elseif($item->type=="buy_tour") خرید تور @endif</td>
                                        <td>@item($item->description) </td>
                                        @role('مدیر')
                                            <td>{{$item->bank_name=='refah'?'اعتباری':'زرینپال'}} </td>
                                            {{-- <td>@if($item->bank_name=='refah') {{$item->confirmtransactionnumber?$item->confirmtransactionnumber:$item->tracing_code}} @else @item($item->replace($item->transaction_id)) @endif </td> --}}
                                            <td>{{substr($item->tracing_code,0,9).'...'}}</td>
                                            <td>{{$item->factor_id}}</td>
                                            <td>{{$item->confirmtransactionnumber}}</td>
                                            <td>{{substr($item->card_number,0,5).'...'}}</td>
                                        @endrole
                                        <td>{{my_jdate($item->created_at,'d F Y  H:i')}}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">موردی یافت نشد</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                        @if ($items->count())
                            <div class="pag_ul">    
                                {{ $items->links() }}
                            </div>
                        @endif
                    </div>
                </div>
        </div>
    </section>
    @role('مدیر')
        <div class="price_box"> 
            {{-- <p>جمع تراکنش(کل) : <strong class="text-info">{{number_format($all_price)}}</strong> تومان <strong>({{number_format($all_count)}} تراکنش)</strong> </p> --}}
            <p>جمع تراکنش(موفق) : <strong class="text-info">{{number_format($all_price1)}}</strong> تومان <strong>({{number_format($all_count1)}} تراکنش)</strong> </p>
            <p>جمع تراکنش(ناموفق) : <strong class="text-info">{{number_format($all_price0)}}</strong> تومان <strong>({{number_format($all_count0)}} تراکنش)</strong> </p>
        </div>
    @endrole
@endsection
@section('js')

@endsection
