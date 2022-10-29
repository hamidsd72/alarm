@extends('layouts.admin')
@section('css')

@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary card-outline">
                <div class="card-header bg-zard">
                    <div class="float-right">
                        <button class="btn btn-light px-3" onclick="ExportToExcel('xlsx')"><i class="fa fa-file-excel-o"></i></button>
                        <button class="btn btn-light px-3 mx-2" onclick="generatePDF()"><i class="fa fa-file-pdf-o"></i></button>
                    </div>
                    <a href="#" class="float-left btn btn-info" data-toggle="modal" data-target="#task-master">
                        افزودن 
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
                <div class="card-body box-profile">
                    <table id="example2" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th>کارمندان تحت نطر</th>
                            <th>موبایل</th>
                            <th>ایمیل</th>
                            <th>واتساپ</th>
                            <th>مدیریت</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if ($item->my_employees()->count())
                                @foreach($item->my_employees()->get() as $item)
                                    <tr >
                                        <td>@item($item->employee()->first_name.' '.$item->employee()->last_name)</td>
                                        <td>@item($item->employee()->mobile)</td>
                                        <td>@item($item->employee()->email)</td>
                                        <td>@item($item->employee()->whatsapp)</td>
                                        <td class="text-center">
                                            {{ Form::model($item,array('route' => array('admin.task-master.destroy',$item->id), 'method' => 'DELETE', 'files' => true)) }}
                                                {{ Form::button('حذف از لیست', array('type' => 'submit', 'class' => 'btn bg-danger py-0')) }}
                                            {{ Form::close() }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal" id="task-master">
        <div class="modal-dialog">
            <div class="modal-content">
                {{ Form::model($item,array('route' => array('admin.task-master.store'), 'method' => 'POST', 'files' => true)) }}
                    <div class="modal-header">
                        <h4 class="modal-title">افزودن کارمند به لیست</h4>
                        <button type="button" class="close" data-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="master_id" value="{{$id}}">
                        <div class="form-group">
                            <label for="employee_id" >انتخاب کارمند</label>
                            <select id="employee_id" name="employee_id" class="form-control select2">
                                @foreach ($users as $key => $item)
                                    <option value="{{$item->id}}" {{ $key==0?'selected':''}}>{{$item->first_name.' '.$item->last_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer row">
                        <div class="col">
                            {{ Form::button('ثبت', array('type' => 'submit', 'class' => 'btn btn-success col-12 ')) }}
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-danger col-12" data-dismiss="modal">بستن</button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
