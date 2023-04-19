@extends('user.master')
@section('content')
    <section class="col-12 px-1 mt-5">
        <div class="card res_table" style="background: transparent;">
            <div class="card-header bg-zard">
                <div class="float-left">
                    <a href="{{url()->previous()}}" class="float-left text-secondary h3 pt-2 ps-4"><i class="fa fa-arrow-left"></i></a>
                </div>
                <div class="float-right h6 pt-2">
                    {{$title1}}
                </div>
            </div>
            <div class="card-body bg-light rounded">
                <table id="example2" class="table table-bordered table-hover table-striped">
                    @if ($user_my_report=='rollCall')
                        <thead>
                            <tr>
                                <th>بازه زمانی</th>
                                <th>تاریخ</th>
                                <th>اولین حضور</th>
                                <th>آخرین بروزرسانی</th>
                                <th>زمان کار</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr>
                                    <td>{{$item->title}}</td>
                                    <td>{{my_jdate($item->created_at,'d F Y')}}</td>
                                    <td>{{$item->created_at->format('H:i:s')}}</td>
                                    <td>{{$item->updated_at->format('H:i:s')}}</td>
                                    <td>{{intval($item->time / 60).':'.$item->time % 60}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        @if ($workDay < 0)
                            <div class="pie me-3"></div>
                            <div class="pie2" style="position: absolute;right: 22px;margin-top: 7px;height: 26px;background: #ececec;padding: 0px 6px;border-radius: 50px;font-weight: bold;width: 26px;">{{num2fa(abs($workDay))}}</div>
                            <p class="m-0 pb-3 text-danger">{{num2fa(abs($workDay)).' روز غیبت در این ماه '}}</p>
                        @endif
                    @elseif($user_my_report=='job')
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
                                    <td class="col-4 p">{{$item->packageName()?$item->packageName()->title:'________'}}</td>
                                    <td>{{$item->job()->sum('price').' تومان '}}</td>
                                    <td>{{my_jdate($item->created_at,'d F Y')}}</td>
                                    <td class="small">{{$item->jobTime()>0?$item->jobTime().' دقیقه ':'__________'}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    @elseif($user_my_report=='leave-day')
                        <thead>
                            <tr>
                                <th>نوع</th>
                                <th>از تاریخ</th>
                                <th>تا تاریخ</th>
                                <th>جزيیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $key => $item)
                                <tr>
                                    <td>{{$item->type=='daily' ? 'روزانه' : 'ساعتی' }}</td>
                                    <td>{{my_jdate($item->start_at,'d F Y')}}</td>
                                    <td>{{my_jdate($item->end_at,'d F Y')}}</td>
                                    <td>
                                        <button  class="btn btn-primary py-0" data-toggle="modal" data-target="#description{{$key}}">نمایش</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <h5 class="pb-3">مرخصی های استفاده شده : {{$leave.' روز '}}</h5>
                    @endif
                </table>
            </div>
        </div>
    </section>

    @if($user_my_report=='leave-day')
        @foreach($items as $key => $item)
            <div class="modal fade mt-5" id="description{{$key}}" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content redu20">
                        <div class="modal-header">
                            @if ($item->type=='daily')
                                <h6 class="my-2">{{ $item->count }} روزه </h6>
                            @else
                                <h6 class="my-2">{{ intVal($item->minute/60).' ساعت '}}
                                    <span class="text-secondary">{{($item->minute%60) > 0 ? ($item->minute%60).' دقیقه ' : '' }}</span>
                                </h6>
                            @endif
                        </div>
                        <div class="modal-body">
                            <p>{{$item->text}}</p>
                            <button type="button" id="description{{$key}}" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                        </div>
                    </div>
            
                </div>
            </div>
        @endforeach
    @endif
@endsection