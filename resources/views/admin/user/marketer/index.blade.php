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
                                <a href="{{route('admin.marketer.create')}}" class="float-left btn btn-info">
                                    افزودن
                                    <i class="fa fa-plus"></i>
                                </a>
                                <span class="mx-3">برای فیلترکردن آیتم ها (ctrl + f) را همزمان فشار دهید</span>
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
                                        <th>تلفن</th>
                                        <th>موبایل</th>
                                        <th>شهر</th>
                                        <th>آدرس</th>
                                        <th>توضیحات</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($items)>0)
                                        @foreach($items as $item)
                                            <tr>
                                                <td>@item($item->first_name) @item($item->last_name)</td>
                                                <td>@item($item->phone)</td>
                                                <td>@item($item->mobile)</td>
                                                <td>@item($item->city.' - '.$item->locate)</td>
                                                <td>@item($item->address)</td>
                                                <td>@item($item->text)</td>
                                                <td class="text-center">
                                                    <a href="{{route('admin.marketer.edit',$item->id)}}" class="badge bg-primary ml-1" title="ویرایش"><i class="fa fa-edit"></i> </a>
                                                    <a href="{{route('admin.marketer.re_activate',$item->id)}}" class="badge {{$item->status=='active'?'bg-success':'bg-danger'}} ml-1" 
                                                        title="{{$item->status=='active'?'مشتری فعال است غیرفعال شود؟':'مشتری غیرفعال است فعال شود؟'}}">
                                                        @if ($item->status=='active')
                                                            <i class="fa fa-check"></i>
                                                        @else
                                                            <i class="fa fa-close"></i>
                                                        @endif
                                                    </a>
                                                    <a href="javascript:void(0);" onclick="del_row('{{$item->id}}')" class="badge bg-danger ml-1" title="حذف"><i class="fa fa-trash"></i> </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center">موردی یافت نشد</td>
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