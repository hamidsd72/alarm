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
                                    <a href="{{route('admin.notification.create')}}" class="btn btn-info mr-2">
                                        ارسال اعلان
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                                {{-- {{ Form::open(array('route' => array('admin.notification.update',auth()->user()->id), 'method' => 'PATCH')) }}
                                    <div class="form-group d-flex">
                                        {{Form::text('user_mobile', null, array('class' => 'form-control col-lg-4','required', 'placeholder' => 'جستجو اعلانات با شماره موبایل'))}}
                                        {{ Form::button('یافتن', array('type' => 'submit', 'class' => 'btn btn-danger mx-lg-3')) }}
                                    </div>
                                {{ Form::close() }} --}}
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
                                        <th>وضعیت</th>
                                        <th>عنوان</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($items->count())
                                        @foreach($items as $item)
                                            <tr>
                                                <td>{{$item->user()->first_name.' '.$item->user()->last_name}}</td>
                                                <td class="{{$item->status=='active'?'text-success':''}}">{{$item->status=='active'?'خوانده شده':'خوانده نشده'}}</td>
                                                <td>@item($item->subject)</td>
                                                <td class="text-center">
                                                    <a href="{{route('admin.notification.show',$item->id)}}" class="badge bg-primary"><i class="fa fa-edit"></i></a>
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
                        </div>
                        <div class="pag_ul">
                            {{ $items->appends(request()->query())->links() }}
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
                                <li style="padding: 6px;"><a class="text-dark" href="{{route('admin.notification.edit',$user->id)}}" title="انتخاب کاربر">{{$user->first_name.' '.$user->last_name}}</a></li>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $("#myInput").on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $(".dropdown-menu li").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
        $(function(){
            $("input[name='user_mobile']").on('input', function (e) {
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
            });
        });
    </script>
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
