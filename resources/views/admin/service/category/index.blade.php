@extends('layouts.admin')
@section('css')

@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                    <div class="col-12">
                        <div class="card res_table">
                            <div class="card-header">
                                <h3 class="card-title float-right">{{$title2}}</h3>
                                <a href="{{route('admin.service.category.create')}}" class="float-left btn btn-info"><i class="fa fa-circle-o mtp-1 ml-1"></i>افزودن</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body res_table_in">
                                <table id="example2" class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>عنوان</th>
                                        <th>تعداد آیتم</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($items)>0)
                                    @foreach($items as $item)
                                    <tr>
                                        <td>@item($item->title)</td>
                                        <td>@item(count($item->service))</td>
                                        <td class="text-center">
                                            <a href="{{route('admin.service.category.edit',$item->id)}}" class="badge bg-primary ml-1" title="ویرایش"><i class="fa fa-edit"></i> </a>
                                            <a href="javascript:void(0);" onclick="del_row('{{$item->id}}')" class="badge bg-danger ml-1" title="حذف"><i class="fa fa-trash"></i> </a>
                                            @if($item->status=='active')
                                                <a href="javascript:void(0);" onclick="active_row('{{$item->id}}','pending')" class="badge bg-success ml-1" title="نمایش فعال است غیرفعال شود؟"><i class="fa fa-check"></i> </a>
                                            @endif
                                            @if($item->status=='pending')
                                                <a href="javascript:void(0);" onclick="active_row('{{$item->id}}','active')" class="badge bg-warning ml-1" title="نمایش غیر فعال است فعال شود؟"><i class="fa fa-close"></i> </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center">موردی یافت نشد</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="pag_ul">
                            {{ $items->links() }}
                        </div>
                    </div>
                </div>
        </div>
    </section>

@endsection
@section('js')
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
                location.href = '{{url('/')}}/admin/service-category-active/'+id+'/'+type;
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
                location.href = '{{url('/')}}/admin/service-category-destroy/'+id;
            }
        })
    }
</script>
@endsection