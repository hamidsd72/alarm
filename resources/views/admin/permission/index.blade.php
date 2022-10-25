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
                            <h3 class="card-title float-right">{{$title2}}</h3>
                        </div>
                        <div class="card-body res_table_in">
                            <table id="example2" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>سمت</th>
                                    <th>بخش کاربران
                                        <i class="nav-icon fa fa-group"></i>
                                    </th>
                                    <th>بخش اعلانات
                                        <i class="nav-icon fa fa-smile-o"></i>
                                    </th>
                                    <th>بخش فعالیتها
                                        <i class="nav-icon fa fa-handshake-o"></i>
                                    </th>
                                    <th>بخش محتوا
                                        <i class="nav-icon fa fa-cogs"></i>
                                    </th>
                                    <th>بخش تنظیمات
                                        <i class="nav-icon fa fa-cog"></i>
                                    </th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>
                                            {{$item->name}}
                                            @foreach ($permissions->where('name',$item->name) as $permission)
                                                {{ Form::open(array('route' => ['admin.permission.destroy',$permission->id], 'method' => 'DELETE', 'files' => true)) }}
                                                    {{-- <h6>{{$permission->access}}</h6> --}}
                                                    {{ Form::button(' بازنشانی دسترسی ', array('type' => 'submit', 'class' => 'd-none')) }}
                                                {{ Form::close() }}
                                            @endforeach
                                        </td>
                                        {{ Form::open(array('route' => ['admin.permission.store'], 'method' => 'POST', 'files' => true)) }}
                                            {{-- <td>
                                                <div class="form-group mb-0">
                                                    <select multiple class="form-control" name="access[]" required>
                                                        <option value="کاربران">بخش کاربران</option>
                                                        <option value="اعلانات">بخش اعلانات</option>
                                                        <option value="فعالیتها">بخش فعالیتها</option>
                                                        <option value="وبینارها">بخش وبینارها</option>
                                                        <option value="محتوا">بخش محتوا</option>
                                                        <option value="تنظیمات">بخش تنظیمات</option>
                                                    </select>
                                                </div>
                                            </td> --}}
                                            <input type="hidden" name="role_name" value="{{$item->name}}">
                                            <td>
                                                <label class="switch-wrap switch-success ml-2">
                                                    <input name="کاربران" type="checkbox" {{ in_array('کاربران', explode(",", $permission->access) )?'checked':'' }} >
                                                    <div class="switch"></div>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="switch-wrap switch-success ml-2">
                                                    <input name="اعلانات" type="checkbox" {{ in_array('اعلانات', explode(",", $permission->access) )?'checked':'' }}>
                                                    <div class="switch"></div>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="switch-wrap switch-success ml-2">
                                                    <input name="فعالیتها" type="checkbox" {{ in_array('فعالیتها', explode(",", $permission->access) )?'checked':'' }}>
                                                    <div class="switch"></div>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="switch-wrap switch-success ml-2">
                                                    <input name="محتوا" type="checkbox" {{ in_array('محتوا', explode(",", $permission->access) )?'checked':'' }}>
                                                    <div class="switch"></div>
                                                </label>
                                            </td>
                                            <td>
                                                <label class="switch-wrap switch-success ml-2">
                                                    <input name="تنظیمات" type="checkbox" {{ in_array('تنظیمات', explode(",", $permission->access) )?'checked':'' }}>
                                                    <div class="switch"></div>
                                                </label>
                                                <div class="d-none">{{$permission->access=''}}</div>
                                            </td>
                                            <td>
                                                <div class="row mb-0">

                                                    {{ Form::button('ثبت دسترسی', array('type' => 'submit', 'class' => 'btn btn-success col-auto mx-1')) }}
                                                
                                                    {{ Form::close() }}
    
                                                    @foreach ($permissions->where('name',$item->name) as $permission)
                                                        {{ Form::open(array('route' => ['admin.permission.destroy',$permission->id], 'method' => 'DELETE', 'files' => true)) }}
                                                            {{-- <h6>{{$permission->access}}</h6> --}}
                                                            {{ Form::button(' بازنشانی دسترسی ', array('type' => 'submit', 'class' => 'btn btn-secondary col-auto mx-1')) }}
                                                        {{ Form::close() }}
                                                    @endforeach

                                                </div>
                                            </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('js')
@endsection