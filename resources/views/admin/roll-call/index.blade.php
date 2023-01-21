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
                            </div>
                            <div class="float-right">
                                <button class="btn btn-light px-3" onclick="ExportToExcel('xlsx')"><i class="fa fa-file-excel-o"></i></button>
                                <button class="btn btn-light px-3 mx-2" onclick="generatePDF()"><i class="fa fa-file-pdf-o"></i></button>
                            </div>
                        </div>
                        <div class="card-body res_table_in">
                            <p class="mb-3 text-danger">زمان حضور هر ۱۰ دقیقه بروزرسانی میشود</p>
                            <table id="example2" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>بازه زمانی</th>
                                    <th>کاربر</th>
                                    <th>شروع روز کاری</th>
                                    <th>آخرین زمان حضور</th>
                                    <th>ساعت کاری</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($items->count())
                                    @foreach($items as $key=>$item)
                                        <tr>
                                            <td class="bg-warning">{{$item->text}}</td>
                                            <td>{{$item->user()->first_name.' '.$item->user()->last_name}}</td>
                                            <td>{{my_jdate($item->created_at,'d F Y').' '.\Carbon\Carbon::parse($item->created_at)->format('H:i')}}</td>
                                            <td>{{my_jdate($item->updated_at,'d F Y').' '.\Carbon\Carbon::parse($item->updated_at)->format('H:i')}}</td>
                                            <td>{{intval($item->reagent_id / 60).':'.($item->reagent_id % 60).' زمان '}}</td>
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
                        {{ $items->count()?$items->links():'' }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{route('admin.job-call.filter')}}" class="get">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">فیلترکردن بر اساس کاربران</h5>
                    </div>
                    <div class="modal-body">
                        {{-- <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if(isset($id)) {{$users->where('id',$id)->first()?$users->where('id',$id)->first()->first_name.' '.$users->where('id',$id)->first()->last_name:$id}} @else کاربر انتخاب کنید @endif
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <input class="form-control" id="myInput" type="text" placeholder="کاربر را جستحو کنید">
                                @foreach($users as $user)
                                    <li style="padding: 6px;"><a class="text-dark" href="{{route('admin.roll-call.show',$user->id)}}" title="انتخاب کاربر">{{$user->first_name.' '.$user->last_name}}</a></li>
                                @endforeach
                            </div>
                        </div> --}}
                        @csrf
                        <div class="row my-2">
                            <div class="col-12 mb-3">
                                <select name="user_id" id="user_id" class="form-control select2">
                                    <option value="all" selected>همه کاربران</option>
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}">{{$user->first_name.' '.$user->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control date_p" name="start" id="start" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control date_p" name="end" id="end" required>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">جستحو</button>
                            <button type="button" class="btn btn-secondary mx-2" data-dismiss="modal">انصراف</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>

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