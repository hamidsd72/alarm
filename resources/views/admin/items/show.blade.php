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
                        <div class="card-header">
                            <h3 class="card-title float-right">{{$title2}}</h3>
                            <button type="button" class="btn btn-primary float-left" data-toggle="modal" data-target="#exampleModalLong">انتخاب سکشن ها</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body res_table_in">
                            @if (isset($items))
                                <table id="example2" class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            {{-- <th>نام صفحه</th> --}}
                                            <th>سکشن</th>
                                            <th>محل قرارگیری</th>
                                            <th>ترتیب</th>
                                            <th>عنوان</th>
                                            <th>وضعیت</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($items)>0)
                                            @foreach($items as $item)
                                                <tr>
                                                    {{-- <td>@item($item->page_name)</td> --}}
                                                    <td>@item($item->section)</td>
                                                    <td>@item($item->position)</td>
                                                    <td>@item($item->sort)</td>
                                                    <td>@item($item->title)</td>
                                                    <td class="text-{{$item->status=='active'?'success':'danger'}}">{{$item->status=='active'?'فعال':'غیر فعال'}}</td>
                                                    <td class="text-center">
                                                        <a href="{{route('admin.items.edit',$item->id)}}" class="badge bg-primary ml-1" title="ویرایش"><i class="fa fa-edit"></i> </a>
                                                        {{-- <a href="javascript:void(0);" onclick="del_row('{{$item->id}}')" class="badge bg-danger ml-1" title="حذف"><i class="fa fa-trash"></i> </a>
                                                        @if($item->status=='active')
                                                            <a href="javascript:void(0);" onclick="active_row('{{$item->id}}','pending')" class="badge bg-success ml-1" title="نمایش فعال است غیرفعال شود؟"><i class="fa fa-check"></i> </a>
                                                        @endif
                                                        @if($item->status=='pending')
                                                            <a href="javascript:void(0);" onclick="active_row('{{$item->id}}','active')" class="badge bg-warning ml-1" title="نمایش غیر فعال است فعال شود؟"><i class="fa fa-close"></i> </a>
                                                        @endif --}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="text-center">موردی یافت نشد</td>
                                            </tr>
                                        @endif
                                </table>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    @if (isset($items))
                        <div class="pag_ul">
                            {{ $items->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">انتخاب سکشن</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach (\App\Model\Item::distinct()->orderBy('section')->get('section') as $section)
                        <div class="border-bottom py-2">
                            <a href="{{ route('admin.items.show', $section->section) }}" class="btn btn-info">{{' نمایش محتوا بخش '.$section->section}}</a>    
                        </div>                        
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
<script>
    function active_row(id,type) {
        if(type=='pending')
        {
            var text_user=' نمایش غیرفعال می شود';
        }
        if(type=='active')
        {
            var text_user=' نمایش فعال می شود';
        }
        Swal.fire({
            title: text_user ,
            text: 'برای تغییر وضعیت مطمئن هستید؟',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = '{{url('/')}}/admin/service-category-active/'+id+'/'+type;
            }
        })
    }
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
                location.href = '{{url('/')}}/admin/service-category-destroy/'+id;
            }
        })
    }
</script>
@endsection
