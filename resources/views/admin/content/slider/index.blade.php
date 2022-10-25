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
                                <h3 class="card-title float-right">{{$title2}}</h3>
                                <a href="{{route('admin.slider.create')}}" class="float-left btn btn-info">
                                    افزودن
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body res_table_in">
                                <table id="example2" class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>عنوان</th>
                                        <th>ترتیب</th>
                                        <th>تصویر</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($items)>0)
                                    @foreach($items as $item)
                                    <tr>
                                        <td class="vertical-align-middle"><a href="{{$item->link}}">@item($item->title)</a></td>
                                        <td class="vertical-align-middle text-center" width="100">
                                            <form action="{{route('admin.slider.sort',$item->id)}}" method="post">
                                                @csrf
                                                <input type="number" min="0" name="sort" class="form-control text-center" onchange="this.form.submit()" value="{{$item->sort}}">
                                            </form>
                                        </td>
                                        <td class="vertical-align-middle text-center"><img class="w-100 obj-contain" src="{{url($item->photo->path)}}" height="150"></td>
                                        <td class="text-center vertical-align-middle">
                                            <a href="{{route('admin.slider.edit',$item->id)}}" class="badge bg-primary ml-1" title="ویرایش"><i class="fa fa-edit"></i> </a>
                                            <a href="javascript:void(0);" onclick="del_row('{{$item->id}}')" class="badge bg-danger ml-1" title="حذف"><i class="fa fa-trash"></i> </a>
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
                location.href = '{{url('/')}}/admin/slider-destroy/'+id;
            }
        })
    }
</script>
@endsection