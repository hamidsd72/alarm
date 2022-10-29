@extends('user.master')
@section('content')
    <section class="col-12 mt-5">
        <div class="card res_table" style="background: transparent;">
            <div class="card-header bg-zard">
                <div class="float-left">
                    <a href="{{url()->previous()}}" class="float-left text-secondary h3 pt-2 ps-4"><i class="fa fa-arrow-left"></i></a>
                </div>
                <div class="float-right h6 pt-2">
                    {{$title1}}
                </div>
            </div>
            <div class="card-body res_table_in">
                <table id="example2" class="table table-bordered table-hover table-striped">
                    @if ($id=='rollCall')
                        <thead>
                            <tr>
                                <th>سه ماه گذشته</th>
                                <th>این ماه</th>
                                <th>هفته</th>
                                <th>امروز</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{intval($treeMonth / 60).':'.($treeMonth % 60).' ساعت '}}</td>
                                <td>{{intval($Month / 60).':'.($Month % 60).' ساعت '}}</td>
                                <td>{{intval($week / 60).':'.($week % 60).' ساعت '}}</td>
                                <td>{{intval($today / 60).':'.($today % 60).' ساعت '}}</td>
                            </tr>
                        </tbody>
                    @elseif($id=='job')
                        <thead>
                            <tr>
                                <th>عنوان</th>
                                <th>هزینه ها</th>
                                <th>تاریخ</th>
                                <th>زمان اجرا</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr >
                                    <td class="col-4 small">{{$item->packageName()?$item->packageName()->title:'________'}}</td>
                                    <td>{{$item->job()->sum('price').' تومان '}}</td>
                                    <td>{{my_jdate($item->created_at,'d F Y')}}</td>
                                    <td class="small">{{$item->jobTime()>0?$item->jobTime().' دقیقه ':'__________'}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    @elseif($id=='leave-day')
                        <thead>
                            <tr>
                                <th>روز</th>
                                <th>از تاریخ</th>
                                <th>تا تاریخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{$item->count.' روز '}}</td>
                                    <td>{{my_jdate($item->start_at,'d F Y')}}</td>
                                    <td>{{my_jdate($item->end_at,'d F Y')}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <h5 class="pb-3">مرخصی های استفاده شده : {{$items->count('sum').' روز '}}</h5>
                    @endif
                </table>
            </div>
        </div>
    </section>
@endsection