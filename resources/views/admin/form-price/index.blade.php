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
                                <h3 class="card-title float-right">{{$title2}}</h3>
                                <a href="{{ route('admin.form-price.create') }}" class="btn btn-info float-left">
                                    افزودن
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="card-body res_table_in">
                                <table id="example2" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>نام پکیج</th>
                                        <th>نوع</th>
                                        <th>قیمت</th>
                                        <th>قیمت تخفیفی</th>
                                        <th>ماه</th>
                                        <th>رنگ پشت زمینه</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($items)<1)
                                        <tr>
                                            <td colspan="6" class="text-center">موردی یافت نشد</td>
                                        </tr>
                                    @endif
                                    @foreach($items as $index=>$item)
                                        {{ Form::model($item,array('route' => array('admin.form-price.update', $item->id), 'method' => 'PATCH', 'files' => true)) }}
                                            <tr>
                                                <td>@item($item->form_name)</td>
                                                <td>@item($item->check_type($item->type))</td>
                                                <td>@item(number_format($item->amount).' تومان ')</td>
                                                <td>@item(number_format($item->off_amount).' تومان ')</td>
                                                <td>@item($item->month.' ماهه ')</td>
                                                <td style="background: {{$item->background}}"></td>
                                                <td>
                                                    <a href="{{route('admin.form-price.edit',$item->id)}}" class="badge bg-primary ml-1" title="ویرایش">
                                                        <i class="fa fa-edit"></i></a>
                                                     <a href="javascript:void(0);" onclick="del_row('{{$item->id}}')" class="badge bg-danger ml-1" title="حذف">
                                                         <i class="fa fa-trash"></i></a>
                                                </td>
                                                {{-- <td>{{ Form::number('amount',$item->amount, array('class' => 'form-control col-6 col-lg-4 text-left')) }}</td> --}}
                                                {{-- <td class="text-center">{{ Form::button('ویرایش', array('type' => 'submit', 'class' => 'btn btn-info')) }}</td> --}}
                                            </tr>
                                        {{ Form::close() }}
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </section>

@endsection
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
                location.href = '{{url('/')}}/admin/form-price/force/delete/'+id;
            }
        })
    }
</script>
@section('js')
@endsection

