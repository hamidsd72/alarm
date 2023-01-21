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
                                <h3 class="card-title mb-2">{{$title2}}</h3>
                                <a href="{{route('admin.notification.create')}}" class="float-left btn btn-primary mr-2"><i class="fa fa-circle-o mtp-1 ml-1"></i>ارسال اعلان</a>
                                {{ Form::open(array('route' => array('admin.notification.update',1), 'method' => 'PATCH')) }}
                                    <div class="form-group d-flex">
                                        {{Form::text('user_mobile', null, array('class' => 'form-control col-lg-4','required', 'placeholder' => 'جستجو اعلانات با شماره موبایل'))}}
                                        {{ Form::button('<i class="fa fa-circle-o"></i>یافتن', array('type' => 'submit', 'class' => 'btn btn-outline-success mx-lg-3')) }}
                                    </div>
                                {{ Form::close() }}
                            </div>
                            <div class="card-body res_table_in">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>کاربر</th>
                                        <th>وضعیت</th>
                                        <th>عنوان</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($items->count())
                                        @foreach($items as $item)
                                            <tr>
                                                <td>{{$users->find($item->user_id)->mobile}}</td>
                                                <td>@item($item->status)</td>
                                                <td>@item($item->subject)</td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0);" onclick="del_row('{{$item->id}}')" class="badge bg-danger ml-1" title="حذف"><i class="fa fa-trash"></i></a>
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
                            {{ $items->appends(request()->query())->links() }}
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
                location.href = '{{url('/')}}/admin/notification/destroy/item/'+id;
            }
        })
    }
</script>
@endsection
