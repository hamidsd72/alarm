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
                            <button type="button" class="btn btn-dark float-left" data-toggle="modal" data-target="#exampleModal">
                                @if(isset($id)) {{$users->where('id',$id)->first()?$users->where('id',$id)->first()->first_name.' '.$users->where('id',$id)->first()->last_name:$id}} @else فیلترکردن بر اساس کاربران @endif
                                <i class="fa fa-search"></i>
                            </button>
                            <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#visitLog">
                                درخواست ردیابی کاربر
                            </button>
                        </div>
                        <div class="card-body res_table_in pt-0">
                            <table id="example2" class="table table-bordered table-hover">
                                <tr>
                                    <th>نام کاربر</th>
                                    <th>تاریخ درخواست</th>
                                    <th>تاریخ بروزرسانی</th>
                                    <th>مکان کاربر</th>
                                    <th>دستگاه کاربر</th>
                                </tr>
                                @if($items->count())
                                    @foreach($items as $index=>$item)
                                    <tr>
                                        <td>{{$item->user()?$item->user()->first_name.' '.$item->user()->last_name:'________'}}</td>
                                        <td>{{my_jdate($item->created_at,'d F Y').' - '.$item->created_at->format('H:i')}}</td>
                                        <td>{{my_jdate($item->updated_at,'d F Y').' - '.$item->updated_at->format('H:i')}}</td>
                                        <td>
                                            @if ($item->location && $item->location!='UNKNOWN')
                                                <a target="_blank" href="{{'https://www.google.com/maps/@'.$item->location}}">جهت نمایش مکان کلیک کنید</a>
                                                {{-- <a target="_blank" href="{{route('admin.job-report-show-map',$item->id)}}">نمایش مکان از روی نقشه</a> --}}
                                            @else در انتظار کاربر @endif
                                        </td>
                                        <td>{{$item->divice?$item->divice:'در انتظار کاربر'}}</td>
                                    @endforeach
                                @endif
                            </table>   
                        </div>
                    </div>
                    <div class="pag_ul">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">فیلترکردن بر اساس کاربران</h5>
                </div>
                <div class="modal-body">
                    <div class="dropdown">
                        <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if(isset($id)) {{$users->where('id',$id)->first()?$users->where('id',$id)->first()->first_name.' '.$users->where('id',$id)->first()->last_name:$id}} @else کاربر انتخاب کنید @endif
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <input class="form-control" id="myInput" type="text" placeholder="کاربر را جستحو کنید">
                            @foreach($users as $user)
                                <li style="padding: 6px;"><a class="text-dark" href="{{route('admin.visit_log.show',$user->id)}}" title="انتخاب کاربر">{{$user->first_name.' '.$user->last_name}}</a></li>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="visitLog" tabindex="-1" role="dialog" aria-labelledby="visitLogLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">فیلترکردن بر اساس کاربران</h5>
                </div>
                <div class="modal-body">
                    <div class="dropdown">
                        <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            کاربر انتخاب کنید
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                            <input class="form-control" id="myInput" type="text" placeholder="کاربر را جستحو کنید">
                            @foreach($users as $user)
                                <li style="padding: 6px;"><a class="text-dark" href="{{route('admin.visit_log.edit',$user->id)}}" title="انتخاب کاربر">{{$user->first_name.' '.$user->last_name}}</a></li>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
@endsection