@extends('layouts.admin')
@section('css')

@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header bg-zard">
                    <h5 class="float-right mt-2">{{$item->first_name.' '.$item->last_name}}</h5>
                    <div class="float-left">
                        <a href="{{ route('user.job-report.index') }}" class="btn btn-secondary ">بازگشت</a>
                    </div>
                </div>
                <div class="card-body box-profile">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>عنوان</th>
                            <th>تاریخ</th>
                            <th>زمان اجرا</th>
                            <th>جزئیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($items)>0)
                            @foreach($items as $item)
                                <tr >
                                    <td>{{$item->title}}</td>
                                    <td>{{my_jdate($item->created_at,'d F Y')}}</td>
                                    <td>{{$item->jobTime()>0?$item->jobTime().' دقیقه ':'__________'}}</td>
                                    <td><a href="{{route('user.job-report.edit',$item->id)}}" class="badge bg-primary">نمایش جزئیات</a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="6" class="text-center">موردی یافت نشد</td></tr>
                        @endif
                    </table>
                </div>
            </div>
            <div class="pag_ul">
                {{ $items->links() }}
            </div>
        </div>
    </section>

@endsection
@section('js')
@endsection
