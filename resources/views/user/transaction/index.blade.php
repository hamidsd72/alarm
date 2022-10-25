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
        @foreach($items as $item)
            <div class="card res_table">
                <div class="card-body">
                    <div>
                        @if($item->type=="buy_form") خرید فرم @elseif($item->type=="buy_tour") خرید تور @endif {{' به مبلغ '.(number_format($item->amount)) .' ریال '}}
                    </div>
                    <small class="text-dark">{{$item->description.' در تاریخ '.my_jdate($item->created_at,'d F Y  H:i')}}</small>
                </div>
            </div>
        @endforeach
        @if ($items->count())
            <div class="pag_ul">    
                {{ $items->links() }}
            </div>
        @endif
    </section>
@endsection
@section('js')

@endsection
