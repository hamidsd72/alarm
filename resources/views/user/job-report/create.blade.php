@extends('layouts.admin')
@section('css')

@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card res_table">
                        <div class="card-header">
                            <h3 class="card-title float-right">{{$title2}}</h3>
                        </div>
                        <div class="card-body res_table_in">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>کاربر</th>
                                    <th>زمان کارکرد</th>
                                    <th>حقوق</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($items)>0)
                                    @foreach($items as $item)
                                        <tr >
                                            <td>{{$item->first_name.' '.$item->last_name}}</td>
                                            <td>{{$item->reagent_id.' دقیقه '}}</td>
                                            <td>{{$item->reagent_code.' تومان '}}</td>
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
                </div>
            </div>
        </div>
    </section>

@endsection
@section('js')
@endsection