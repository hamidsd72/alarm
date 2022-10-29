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
                            <div class="float-right">
                                <button class="btn btn-light px-3" onclick="ExportToExcel('xlsx')"><i class="fa fa-file-excel-o"></i></button>
                                <button class="btn btn-light px-3 mx-2" onclick="generatePDF()"><i class="fa fa-file-pdf-o"></i></button>
                            </div>
                        </div>
                        <div class="card-body res_table_in">
                            <table id="example2" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>نام و نام خانوادگی</th>
                                    <th>کارمندان تحت نطر</th>
                                    <th>موبایل</th>
                                    <th>ایمیل</th>
                                    <th>واتساپ</th>
                                    <th>مدیریت</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($items)>0)
                                @foreach($items as $item)
                                    <tr>
                                        <td>@item($item->first_name) @item($item->last_name)</td>
                                        <td>@item($item->my_employees()->count().' نفر ')</td>
                                        <td>@item($item->mobile)</td>
                                        <td>@item($item->email)</td>
                                        <td>@item($item->whatsapp)</td>
                                        <td class="text-center">
                                            <a href="{{route('admin.task-master.show',$item->id)}}" class="btn btn-info py-0">ویرایش کارمندان</a>
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
@endsection
@section('js')
@endsection