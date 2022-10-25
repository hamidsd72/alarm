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
                                <a href="{{route('admin.network-setting.create')}}" class="float-left btn btn-info mr-2">
                                    افزودن
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="card-body res_table_in">
                                <table id="example2" class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>نام</th>
                                        <th>آدرس</th>
                                        <th>شبکه اجتماعی</th>
                                        <th>ترتیب</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($items)>0)
                                    @foreach($items as $index=>$item)
                                    <tr>
                                        <td>@item($item->name)</td>
                                        <td>@item($item->address)</td>
                                        <td>@item($item->config)</td>
                                        <td>@item($item->sort)</td>
                                        <td class="text-center">
                                            <a href="javascript:void(0);" onclick="del_row('{{$item->id}}')" class="badge bg-danger ml-1" title="حذف"><i class="fa fa-trash"></i> </a>
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
                    </div>
                </div>
        </div>
    </section>

@endsection
@section('js')
<script>
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
                location.href = '{{url('/')}}/admin/setting-update/destroy/'+id;
            }
        })
    }
</script>
@endsection
