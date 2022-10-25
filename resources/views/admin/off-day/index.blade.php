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
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                                    افزودن
                                    <i class="fa fa-plus"></i>
                                </button>
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
                                    <th>عنوان</th>
                                    <th>تاریخ</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($items)>0)
                                    @foreach($items as $key=>$item)
                                        <tr>
                                            <td>{{$item->title}}</td>
                                            <td>{{my_jdate($item->date,'d F Y')}}</td>
                                            {{-- <td><input type="text" name="date" class="form-control date_p" ></td> --}}
                                            <td>
                                                <div class="d-flex">
                                                    <button data-toggle="modal" data-target="#editModal{{$item->id}}" class="btn bg-info p-0 px-3 mx-2">ویرایش</button>
                                                    <form action="{{route('admin.off-day.destroy',$item->id)}}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn bg-danger p-0 px-3">حذف</button>
                                                    </form>
                                                </div>
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

            <form action="{{route('admin.off-day.store')}}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">افزودن روز یا مناسبت تعطیل</h5>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 my-2">
                            <label for="title">عنوان رویداد تعطیلی را وارد کنید</label>
                            <input type="text" name="title" class="form-control">
                        </div>
                        <div class="col-12 my-2">
                            <label for="date">تاریخ را وارد کنید</label>
                            <input type="text" name="date" class="form-control date_p">
                            <img class="inline-left-logo" src="https://img.icons8.com/external-icematte-lafs/40/000000/external-Calendar-it-icematte-lafs.png">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success text-light mx-1">افزودن</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    @foreach($items as $item)
        <div class="modal fade" id="editModal{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{$item->id}}" aria-hidden="true">
            <div class="modal-dialog" role="document">

                <form action="{{route('admin.off-day.update',$item->id)}}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">ویرایش روز یا مناسبت تعطیل</h5>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 my-2">
                                <label for="title">عنوان رویداد تعطیلی را وارد کنید</label>
                                <input type="text" name="title" class="form-control" value="{{$item->title}}">
                            </div>
                            <div class="col-12 my-2">
                                <label for="date">تاریخ را وارد کنید</label>
                                <input type="text" name="date" class="form-control date_p" value="{{my_jdate($item->date,'d F Y')}}">
                                <img class="inline-left-logo" src="https://img.icons8.com/external-icematte-lafs/40/000000/external-Calendar-it-icematte-lafs.png">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary text-light mx-1">ویرایش</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                        </div>
                    </div>
                </form>

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
@endsection