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
                            <div class="card-header bg-zard">
                                <a href="{{route('admin.meta.create')}}" class="float-left btn btn-info">
                                    افزودن
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body res_table_in">
                                <table id="example2" class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>آدرس صفحه</th>
                                        <th>عنوان</th>
                                        <th>وضعیت</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($items)>0)
                                    @foreach($items as $item)
                                    <tr>
                                        <td>@item($item->url)</td>
                                        <td>@item($item->title)</td>
                                        <td>@item($item->status($item->status))</td>
                                        <td class="text-center">
                                            <a href="{{route('admin.meta.edit',$item->id)}}" class="badge bg-primary ml-1" title="ویرایش"><i class="fa fa-edit"></i> </a>
                                            <a href="javascript:void(0);" onclick="del_row('{{$item->id}}')" class="badge bg-danger ml-1" title="حذف"><i class="fa fa-trash"></i> </a>
                                            @if($item->status=='active')
                                                <a href="javascript:void(0);" onclick="active_row('{{$item->id}}','pending')" class="badge bg-success ml-1" title="نمایش متا فعال است غیر فعال شود؟"><i class="fa fa-check"></i> </a>
                                            @endif
                                            @if($item->status=='pending')
                                                <a href="javascript:void(0);" onclick="active_row('{{$item->id}}','active')" class="badge bg-danger ml-1" title="نمایش متا غیر فعال است فعال شود؟"><i class="fa fa-close"></i> </a>
                                            @endif
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
            var text_user='غیر فعال می شود';
        }
        if(type=='active')
        {
            var text_user='فعال می شود';
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
                location.href = '{{url('/')}}/admin/meta-active/'+id+'/'+type;
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
                location.href = '{{url('/')}}/admin/meta-destroy/'+id;
            }
        })
    }
</script>
@endsection