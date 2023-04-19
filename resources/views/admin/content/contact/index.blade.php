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
                                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#filter">
                                    فیلتر کردن درخواست ها
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                            <div class="float-right">
                                <button class="btn btn-light px-3" onclick="ExportToExcel('xlsx')"><i class="fa fa-file-excel-o"></i></button>
                                <button class="btn btn-light px-3 mx-2" onclick="generatePDF()"><i class="fa fa-file-pdf-o"></i></button>
                            </div>
                        </div>
                        @if(count($items)>0)
                            @foreach($items as $item)
                                <div class="card-body res_table_in border mx-2 my-1 redu20">
                                    <span>
                                        وضعیت : 
                                        <span class="reply_email_ok {{$item->reply>0?'text-success':'text-danger'}}">
                                            {{$item->reply>0?'پاسخ داده شده':'در انتظار پاسخ'}}
                                        </span>
                                        <span class="mx-4">{{$item->user()->first()->first_name.' '.$item->user()->first()->last_name}}</span>
                                    </span>
                                    <h6 class="pt-1">{{$item->subject}}
                                        @if ($item->date){{' از '.explode(",",$item->date)[0].' تا '.explode(",",$item->date)[1]}}@endif
                                        @if ($item->time1 && $item->time2){{' از '.$item->time1.' تا '.$item->time2}}@endif
                                    </h6>
                                    <p class="m-0">{{' توضیحات : '.$item->text}}</p>
                                    @if ($item->attach)
                                        <a class="text-dark pt-1" href="{{url($item->attach)}}" download>
                                            <i class="fa fa-paperclip mt-2"></i>
                                            بارگیری فایل پیوست شده
                                        </a>
                                    @endif

                                    @foreach($sub_items->where('belongs_to_item', '=', $item->id) as $sub_item)
                                        <div class="card-body res_table_in border mx-1 my-1 rounded">
                                            <span>
                                                وضعیت : 
                                                <span class="reply_email_ok {{$sub_item->reply>0?'text-success':'text-danger'}}">
                                                    {{$sub_item->reply>0?'پاسخ داده شده':'در انتظار پاسخ'}}
                                                </span>
                                                <span class="mx-4">{{$item->user()->first()->first_name.' '.$item->user()->first()->last_name}}</span>
                                            </span>
                                            <h6 class="pt-1">{{$sub_item->subject}}
                                                @if ($item->date){{' از '.explode(",",$item->date)[0].' تا '.explode(",",$item->date)[1]}}@endif
                                                @if ($item->time1 && $item->time2){{' از '.$item->time1.' تا '.$item->time2}}@endif
                                            </h6>
                                            <p class="m-0">{{' توضیحات : '.$sub_item->text}}</p>
                                            @if ($sub_item->attach)
                                                <a class="text-dark pt-1" href="{{ url($sub_item->attach) }}" download>
                                                    <i class="fa fa-paperclip mt-2"></i>
                                                    بارگیری فایل پیوست شده
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach

                                    <div class="float-left">
                                        @switch($item->subject)
                                            @case('درخواست مساعده')
                                                <a href="javascript:void(0)" onclick="set_requ('btn_user_request','{{$item->id}}','{{$item->user_id}}','درخواست مساعده')" class="mx-3 btn btn-primary">ثبت درخواست</a>
                                                @break    
                                            @case('درخواست تنخواه')
                                                <a href="javascript:void(0)" onclick="set_requ('btn_user_request','{{$item->id}}','{{$item->user_id}}','درخواست تنخواه')" class="mx-3 btn btn-primary">ثبت درخواست</a>
                                                @break
                                            @case('درخواست مرخصی')
                                                <a href="javascript:void(0)" onclick="set_requ('btn_leaveDayCreate','{{$item->id}}','{{$item->user_id}}','{{$item->day}}','{{$item->start}}','{{$item->end}}','{{$item->time}}','{{$item->time1}}','{{$item->time2}}')" class="mx-3 btn btn-primary">ثبت درخواست</a>
                                                @break
                                            @default
                                                
                                        @endswitch
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#ModalAnsweTicket{{$item->id}}" class="btn btn-success">پاسخ درخواست</a>
                                    </div>
                                </div> 
                            @endforeach
                        @else
                            <div>
                                <td colspan="3" class="text-center">موردی یافت نشد</td>
                            </div>
                        @endif
                    </div>
                    <div class="pag_ul">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
        @foreach($items as $item)
            <div class="modal fade" id="ModalAnsweTicket{{$item->id}}" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content"> 
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h6 class="modal-title">{{$item->subject}}</h6>
                        </div>
                        <div class="modal-body">
                            <div class="content mt-0">
                                    <form method="post" action="{{ route('admin.contact.send.ticket',$item->id) }}" enctype="multipart/form-data">
                                        @csrf
                                    <fieldset>
                                        <input type="hidden" name="belongs_to_item" value="{{$item->id}}" id="contactbelongs_to_itemField">
                                        <input type="hidden" name="category" value="{{$item->category}}" id="contactbelongs_to_itemField">
                                        <div class="form-field form-text">
                                            <label class="contactMessageTextarea color-theme" for="contactMessageTextarea">متن:<span>(required)</span></label>
                                            <textarea name="text" rows="4" class="round-small form-control mb-2" id="contactMessageTextarea"></textarea>
                                        </div>
                                        <div>
                                            <label class="contactMessageTextarea color-theme" for="contactMessageTextarea">الحاق فایل:</label>
                                            <input type="file" name="attach" id="attach" class="form-control">
                                        </div>
                                        <div class="form-button">
                                            <input type="submit" class="btn btn-info col-12 mt-4" value="ارسال پیام" data-formid="contactForm">
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach

        <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="filterLabel" aria-hidden="true">
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
                                    <li style="padding: 6px;"><a class="text-dark" href="{{route('admin.contact.filter',$user->id)}}" title="انتخاب کاربر">{{$user->first_name.' '.$user->last_name}}</a></li>
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
        
        <div class="modal fade" id="leaveDayCreate" tabindex="-1" role="dialog" aria-labelledby="leaveDayCreateLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {{ Form::open(array('route' => 'admin.leave-day.store', 'method' => 'POST', 'files' => true)) }}
                        <div class="modal-header"><h5 class="leaveDayCreate-title"></h5></div>
                        <div class="modal-body">
                            {{ Form::hidden('user_id',null, array('class' => 'form-control','id' => 'leaveDayCreate_userId')) }}
                            {{ Form::hidden('type',null, array('class' => 'form-control','id' => 'leaveDayCreate_type')) }}
                            {{ Form::hidden('minute',null, array('class' => 'form-control','id' => 'leave_time_minute')) }}
                            {{ Form::hidden('ticket_id',null, array('class' => 'form-control','id' => 'leave_day_ticket_id')) }}
                            <div class="form-group daily">
                                {{ Form::label('count', '* تعداد روز') }}
                                {{ Form::number('count',null, array('class' => 'form-control text-left' ,'id' => 'leave_count')) }}
                            </div>
                            <div class="row m-0">
                                <div class="form-group col-lg-6 m-0">
                                    {{ Form::label('start_at', '* از تاریخ ') }}
                                    {{ Form::text('start_at',null, array('class' => 'form-control' ,'id' => 'leave_start_at', 'readonly' => 'readonly')) }}
                                    <img class="inline-left-logo" src="https://img.icons8.com/external-icematte-lafs/40/000000/external-Calendar-it-icematte-lafs.png">
                                </div>
                                <div class="form-group col-lg-6 m-0">
                                    {{ Form::label('end_at', '* تا تاریخ ') }}
                                    {{ Form::text('end_at',null, array('class' => 'form-control' ,'id' => 'leave_end_at', 'readonly' => 'readonly')) }}
                                    <img class="inline-left-logo" src="https://img.icons8.com/external-icematte-lafs/40/000000/external-Calendar-it-icematte-lafs.png">
                                </div>
    
                                <div class="form-group col-lg-6 m-0 hourly">
                                    {{ Form::label('start_time', ' از ساعت ') }}
                                    <input type="time" name="start_time" id="start_time" class="form-control" readonly>
                                    <img class="inline-left-logo" src="https://img.icons8.com/ultraviolet/40/null/clock--v1.png"/>
                                </div>
                                <div class="form-group col-lg-6 m-0 hourly">
                                    {{ Form::label('end_time', ' تا ساعت ') }}
                                    <input type="time" name="end_time" id="end_time" class="form-control" readonly>
                                    <img class="inline-left-logo" src="https://img.icons8.com/ultraviolet/40/null/clock--v1.png"/>
                                </div>
                            </div>

                            <div class="form-group hourly">
                                {{ Form::label('time', '* دقیقه (مرخصی ساعتی) ') }}
                                {{ Form::text('time',null, array('class' => 'form-control' ,'id' => 'leave_time_show', 'readonly' => 'readonly')) }}
                                <img class="inline-left-logo" src="https://img.icons8.com/ultraviolet/38/null/clock--v1.png"/>
                            </div>
                            <div class="form-group">
                                {{ Form::label('text', '* شرح مرخصی') }}
                                {{ Form::textarea('text',null, array('class' => 'form-control textarea')) }}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary m-0 mx-3" data-dismiss="modal">انصراف</button>
                            {{ Form::button('ثبت', array('type' => 'submit', 'class' => 'btn btn-success')) }}
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>

        <div class="modal fade" id="user_request" tabindex="-1" role="dialog" aria-labelledby="user_requestLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    {{ Form::open(array('route' => 'admin.user_request.store', 'method' => 'POST', 'files' => true)) }}
                        <div class="modal-header"><h5 class="user_request-title"></h5></div>
                        <div class="modal-body">
                            {{ Form::hidden('user_id',null, array('class' => 'form-control','id' => 'user_request_userId')) }}
                            {{ Form::hidden('ticket_id',null, array('class' => 'form-control','id' => 'user_request_ticket')) }}
                            <div class="form-group">
                                {{ Form::label('title', '* عنوان') }}
                                {{ Form::text('title',null, array('class' => 'form-control' ,'id' => 'request_title')) }}
                            </div>
                            <div class="form-group">
                                {{ Form::label('date', '* تاریخ درخواست') }}
                                {{ Form::text('date',null, array('class' => 'form-control date_p')) }}
                                <img class="inline-left-logo" src="https://img.icons8.com/external-icematte-lafs/40/000000/external-Calendar-it-icematte-lafs.png">
                            </div>
                            <div class="form-group">
                                {{ Form::label('description', '* توضیحات') }}
                                {{ Form::textarea('description',null, array('class' => 'form-control textarea')) }}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary m-0 mx-3" data-dismiss="modal">انصراف</button>
                            {{ Form::button('ثبت', array('type' => 'submit', 'class' => 'btn btn-success')) }}
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>

        <button data-toggle="modal" data-target="#leaveDayCreate" id="btn_leaveDayCreate" class="d-none">btn_leaveDayCreateLabel</button>
        <button data-toggle="modal" data-target="#user_request" id="btn_user_request" class="d-none">btn_user_requestLabel</button>

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
                location.href = '{{url('/')}}/admin/contact-destroy/'+id;
            }
        })
    }
    function set_requ(modal, id, user_id, day_or_title, start_date, end_date, minute, s_time, e_time) {
        console.log(modal, id, user_id, day_or_title, start_date, end_date);
        if (modal=='btn_user_request') {
            document.getElementById('user_request_ticket').value    = id;
            document.getElementById('user_request_userId').value    = user_id;
            document.getElementById('request_title').value          = day_or_title;
        }
        else if(modal=='btn_leaveDayCreate') {
            document.getElementById('leave_day_ticket_id').value    = id;
            document.getElementById('leaveDayCreate_userId').value  = user_id;
            document.getElementById('leave_count').value            = day_or_title;
            document.getElementById('leave_start_at').value         = start_date;
            document.getElementById('leave_end_at').value           = end_date;
            document.getElementById('start_time').value             = s_time;
            document.getElementById('end_time').value               = e_time;
            if (minute > 0) {
                let text    = '';
                let minutes = minute%60;
                if (minute > 60) {
                    let hour    = parseInt(minute/60);
                    if (hour > 0) {text += ` ${hour} ساعت `;}
                }
                if (minutes > 0) {text += ` ${minutes} دقیقه `;}
                document.getElementById('leave_time_show').value    = text;
                document.getElementById('leave_time_minute').value  = minute;
                document.getElementById('leaveDayCreate_type').value= 'minutely';
                
                document.querySelectorAll('.hourly').forEach( item => {
                    item.classList.remove('d-none');
                });

                document.querySelector('.daily').classList.add('d-none');
            } else {
                document.querySelector('.daily').classList.remove('d-none');
                
                document.querySelectorAll('.hourly').forEach( item => {
                    item.classList.add('d-none');
                });

                document.getElementById('leaveDayCreate_type').value= 'daily';
            }
        }
        
        document.getElementById(modal).click();
    }
</script>
@endsection