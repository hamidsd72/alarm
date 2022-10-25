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
                                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModal">
                                    @if(isset($id)) {{$users->where('id',$id)->first()?$users->where('id',$id)->first()->first_name.' '.$users->where('id',$id)->first()->last_name:$id}} @else فیلترکردن بر اساس کاربران @endif
                                    <i class="fa fa-search"></i>
                                </button>
                                <a href="{{route('admin.request.create')}}" class="btn btn-info">
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
                                    <th>کاربر</th>
                                    <th>عنوان</th>
                                    <th>توضیحات</th>
                                    <th>تاریخ</th>
                                    <th>ثبت کننده گزارش</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($items)>0)
                                    @foreach($items as $key=>$item)
                                        <tr >
                                            <td>{{$item->user()->first_name.' '.$item->user()->last_name}}</td>
                                            <td>@item($item->title)</td>
                                            <td>
                                                <a href="#" data-toggle="tooltip" data-placement="left" title="{{$item->description}}">
                                                    {{substr($item->description,50).'...'}}
                                                </a>
                                            </td>
                                            <td>{{my_jdate($item->date,'d F Y')}}</td>
                                            <td>{{$item->user_employee()->first_name.' '.$item->user_employee()->last_name}}</td>
                                            <td class="text-center">
                                                <a href="{{route('admin.request.edit',$item->id)}}" class="badge bg-primary ml-1" title="ویرایش">
                                                   <i class="fa fa-edit"></i></a>
                                                <a href="javascript:void(0);" onclick="del_row('{{$item->id}}')" class="badge bg-danger ml-1" title="حذف">
                                                    <i class="fa fa-trash"></i></a>
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
                                <li style="padding: 6px;"><a class="text-dark" href="{{route('admin.request.show',$user->id)}}" title="انتخاب کاربر">{{$user->first_name.' '.$user->last_name}}</a></li>
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
    function active_row(id,type) {
        if(type=='pending')
        {
            var text_user=' نمایش غیرفعال می شود';
        }
        if(type=='active')
        {
            var text_user=' نمایش فعال می شود';
        }
        Swal.fire({
            title: text_user ,
            text: 'برای تغییر وضعیت مطمئن هستید؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = '{{url('/')}}/admin/request/active/'+id+'/'+type;
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
                location.href = '{{url('/')}}/admin/request/force/delete/'+id;
            }
        })
    }
</script>
@endsection