@extends('layouts.admin')
@section('css')

@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header bg-zard">
                    <h5 class="float-right mt-2">{{$item->title}}</h5>
                    <div class="float-left">
                        <a href="{{ route('user.job-report.show',$item->user_id) }}" class="btn btn-secondary ">بازگشت</a>
                    </div>
                </div>
                <div class="card-body box-profile">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>تاریخ</th>
                            <th>زمان اجرا</th>
                            <th>نمایش مکان</th>
                            <th>گزارش فعالیت</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($items)>0)
                            @foreach($items as $item)
                                <tr >
                                    <td>{{my_jdate($item->created_at,'d F Y')}}</td>
                                    <td>{{$item->time.' دقیقه '}}</td>
                                    <td>
                                        @if ($item->location)
                                            <a target="_blank" href="{{'https://www.google.com/maps/@'.$item->location}}">نمایش مکان از روی نقشه</a>
                                            {{-- <a target="_blank" href="{{route('admin.job-report-show-map',$item->id)}}">نمایش مکان از روی نقشه</a> --}}
                                        @else ______ @endif
                                    </td>
                                    <td>
                                        <a href="#" data-toggle="tooltip" data-placement="left" title="{{$item->description}}">
                                            {{substr($item->description,50).'...'}}
                                        </a>
                                    </td>
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
