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
                                            @if($item->reply>0)
                                                <span class="reply_email_ok text-success">پاسخ داده شده</span>
                                            @else
                                                <span class="reply_email_no">در انتظار پاسخ</span>
                                            @endif
                                            <span class="mx-4">{{' کاربر : '.$item->user()->first()->first_name.' '.$item->user()->first()->last_name}}</span>
                                    </span>
                                    <h6 class="pt-1">{{$item->subject}}
                                        @if ($item->date){{' از '.explode(",",$item->date)[0].' تا '.explode(",",$item->date)[1]}}@endif
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
                                                @if($sub_item->reply>0)
                                                    <span class="reply_email_ok text-success">پاسخ داده شده</span>
                                                @else
                                                    <span class="reply_email_no">در انتظار پاسخ</span>
                                                @endif
                                                <span class="mx-4">{{$item->user()->first()->first_name.' '.$item->user()->first()->last_name}}</span>
                                            </span>
                                            <h6 class="pt-1">{{$sub_item->subject}}
                                                @if ($item->date){{' از '.explode(",",$item->date)[0].' تا '.explode(",",$item->date)[1]}}@endif
                                            </h6>
                                            <p class="m-0">{{' توضیحات : '.$sub_item->text}}</p>
                                            @if ($sub_item->attach)
                                                <a class="text-dark pt-1" href="/{{ $sub_item->attach }}" target="_blank">
                                                    <i class="fa fa-paperclip mt-2"></i>
                                                    مشاهده فایل پیوست شده
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                    <a href="javascript:void(0);" data-toggle="modal" data-target="#ModalAnsweTicket{{$item->id}}" class="float-left btn btn-success">پاسخ درخواست</a>
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
                                        {{-- <div class="form-field form-email">
                                            <label class="contactEmailField color-theme" for="contactEmailField">موضوع:<span>(required)</span></label>
                                            <input type="text" name="subject" value="{{$item->subject}}" class="round-small form-control" id="contactEmailField">
                                        </div> --}}
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
                        <h5 class="modal-title">فیلتر بر اساس وضعیت پیام شده</h5>
                    </div>
                    <div class="modal-body">
                        <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                فیلتر کردن پیام ها
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li style="padding: 6px;"><a class="text-success" href="{{route('admin.contact.list','active')}}" title="Courses">پیام های پاسخ داده شده</a></li>
                                <li style="padding: 6px;"><a class="text-danger" href="{{route('admin.contact.list','pending')}}" title="Courses">پیام های پاسخ داده نشده</a></li>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                    </div>
                </div>
            </div>
        </div>


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
</script>
@endsection