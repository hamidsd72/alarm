@extends('layouts.admin')
@section('css')
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card res_table">
                        <div class="card-header bg-zard">
                            <div class="float-left">
                                <button type="button" class="btn btn-dark mx-1" data-toggle="modal" data-target="#filter">
                                    @if(isset($id)) {{$users->where('id',$id)->first()?$users->where('id',$id)->first()->first_name.' '.$users->where('id',$id)->first()->last_name:$id}} @else فیلترکردن بر اساس کاربران @endif
                                    <i class="fa fa-search"></i>
                                </button>
                                <a href="{{route('admin.service.package.create')}}" class="float-left btn btn-info">
                                    افزودن
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="float-right">
                                <button class="btn btn-light px-3" onclick="ExportToExcel('xlsx')"><i class="fa fa-file-excel-o"></i></button>
                                <button class="btn btn-light px-3 mx-2" onclick="generatePDF()"><i class="fa fa-file-pdf-o"></i></button>
                            </div>
                        </div>
                        <div class="card-body res_table_in">
                            <table id="example2" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>{{$title2}}</th>
                                    {{-- <th>خدمات</th> --}}
                                    <th>کاربر</th>
                                    <th>تاریخ انجام فعالیت</th>
                                    <th>مشتری</th>
                                    {{-- <th>ترتیب سرویس ها</th> --}}
                                    {{-- <th>صفحه اصلی</th> --}}
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($items)>0)
                                    @foreach($items as $key=>$item)
                                        {{-- <tr class="{{$item->custom==1?'backgrond_tb':''}}"> --}}
                                        <tr >
                                            <td>{{$item->packageName()?$item->packageName()->title:'________'}}
                                                <br>
                                                {{-- {{$item->custom==1?'(پکیج ویژه)':''}} --}}
                                            </td>
                                            {{-- <td>@foreach($item->joins as $key1=>$join) @if($key1>0) , @endif
                                                @item($join->service?$join->service->title:'__')
                                                ({{$join->service && $join->service->category?$join->service->category->title:''}})
                                                @endforeach</td> --}}
                                            <td>{{$item->user()->first_name.' '.$item->user()->last_name}}</td>
                                            {{-- <td>
                                                <a href="javascript:void(0);" data-toggle="modal" data-target="#modal_{{$item->id}}" class="badge bg-primary ml-1" title="مشاهده"><i class="fa fa-eye"></i></a>
                                            </td>
                                            <td>
                                                {{$item->home_view==1?'نمایش':'عدم نمایش'}}
                                            </td> --}}
                                            <td>{{my_jdate($item->started_at,'d F Y')}}</td>
                                            <td>{{$item->agent()?$item->agent()->first_name.' '.$item->agent()->last_name.' - '.$item->agent()->text:''}}</td>
                                            <td class="text-center">
                                                <a href="{{route('admin.service.package.edit',$item->id)}}"
                                                   class="badge bg-primary ml-1" title="ویرایش"><i
                                                            class="fa fa-edit"></i> </a>
                                                <a href="javascript:void(0);" onclick="del_row('{{$item->id}}')"
                                                   class="badge bg-danger ml-1" title="حذف"><i class="fa fa-trash"></i>
                                                </a>
                                                @if($item->status=='active')
                                                    <a href="javascript:void(0);"
                                                       onclick="active_row('{{$item->id}}','pending')"
                                                       class="badge bg-success ml-1"
                                                       title=" نمایش فعال است غیرفعال شود؟"><i class="fa fa-check"></i>
                                                    </a>
                                                @endif
                                                @if($item->status=='pending')
                                                    <a href="javascript:void(0);"
                                                       onclick="active_row('{{$item->id}}','active')"
                                                       class="badge bg-warning ml-1"
                                                       title="نمایش غیر فعال است فعال شود؟"><i class="fa fa-close"></i>
                                                    </a>
                                                @endif
                                               {{-- <a ا href="{{route('admin.service.package.video.list',$item->id)}}"
                                                  class="badge bg-warning ml-1"
                                                  title="ویدئو ها"><i class="fa fa-film"></i>
                                               </a> --}}
                                            </td>
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
                    <div class="pag_ul">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="filterLabel" aria-hidden="true">
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
                                <li style="padding: 6px;"><a class="text-dark" href="{{route('admin.service.package.filter',$user->id)}}" title="انتخاب کاربر">{{$user->first_name.' '.$user->last_name}}</a></li>
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
    
    @foreach($items as $key=>$item)
        <div class="modal fade" id="modal_{{$item->id}}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                {{ Form::open(array('route' => ['admin.sort.by.join'], 'method' => 'POST', 'files' => true)) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title dir-rtl">{{$item->title}}</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row alert alert-info row_head">
                                <div class="col-md-6">نام خدمت</div>
                                <div class="col-md-6">ترتیب نمایش</div>
                            </div>
                                @foreach($item->joins as $key=> $join)
                                    <div class="row row_tabale alert alert-secondary mb-0">
                                        <div class="col-md-6">
                                            {{-- {{$join->service->title}} --}}
                                        </div>
                                        <div class="col-md-6">
                                            {{ Form::number('id_join[]',$join->id, array('class' => 'form-control text-left','hidden')) }}
                                            {{ Form::number('key_join',$key+1, array('class' => 'form-control text-left','hidden')) }}
                                            {{ Form::number('sort_by[]',$join->sort_by, array('class' => 'form-control text-center')) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        <div class="modal-footer">
                            {{ Form::button('<i class="fa fa-circle-o mtp-1 ml-1"></i>تنظیم ترتیب', array('type' => 'submit', 'class' => 'btn btn-info mx-2')) }}
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    @endforeach
@endsection
@section('js')
    <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $(".dropdown-menu li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    <script>
        function active_row(id, type) {
            if (type == 'pending') {
                var text_user = ' نمایش غیرفعال می شود';
            }
            if (type == 'active') {
                var text_user = ' نمایش فعال می شود';
            }
            Swal.fire({
                title: text_user,
                text: 'برای تغییر وضعیت مطمئن هستید؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = '{{url('/')}}/admin/service-package-active/' + id + '/' + type;
                }
            })
        }

        function del_row(id) {
            Swal.fire({
                text: 'برای حذف مطمئن هستید؟',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = '{{url('/')}}/admin/service-package-destroy/' + id;
                }
            })
        }
    </script>
@endsection