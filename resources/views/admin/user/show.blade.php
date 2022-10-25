@extends('layouts.admin')
@section('css')

@endsection
@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-9 m-auto">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            {{-- <img class="profile-user-img img-circle" src="{{$item->photo? url($item->photo->path) :asset('admin/img/user.png')}}" alt="User profile picture"> --}}
                            <img class="profile-user-img img-circle" src="{{$item->photo? url($item->photo->path) :'https://img.icons8.com/ultraviolet/100/000000/test-account.png'}}" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">@item($item->first_name) @item($item->last_name)</h3>

                        <p class="text-muted text-center">@item($item->education)</p>
                        <div class="container-fluid">
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong><i class="fa fa-at ml-1"></i> ایمیل </strong>
                                    <p class="text-muted">
                                        @if($item->email!=null) @item($item->email)
                                            {{-- @if($item->email_status=='pending')
                                                <span class="right badge badge-danger">تایید نشده</span>
                                            @elseif($item->email_status=='active')
                                                <span class="right badge badge-success">تایید شده</span>
                                            @endif --}}
                                        @else
                                            ثبت نشده
                                        @endif
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <strong><i class="fa fa-mobile ml-1"></i> موبایل</strong>
                                    <p class="text-muted">
                                        @if($item->mobile!=null) @item($item->mobile) @else ثبت نشده @endif
                                        {{-- @if($item->mobile_status=='pending')
                                            <span class="right badge badge-danger">تایید نشده</span>
                                        @elseif($item->mobile_status=='active')
                                             <span class="right badge badge-success">تایید شده</span>
                                        @endif --}}
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6">
                                    <strong><i class="fa fa-whatsapp ml-1"></i> شماره واتساپ فعال</strong>
                                    <p class="text-muted">
                                        @if($item->whatsapp!=null) @item($item->whatsapp) @else ثبت نشده @endif
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <strong><i class="fa fa-book ml-1"></i> تحصیلات</strong>
                                    <p class="text-muted">
                                        @if($item->education!=null) @item($item->education) @else ثبت نشده @endif
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <strong><i class="fa fa-map-marker ml-1"></i> موقعیت</strong>
                                    <p class="text-muted">
                                        @if($item->state) @item($item->state->name) - @endif
                                        @if($item->city) @item($item->city->name) - @endif
                                        @if($item->locate!=null) @item($item->locate) - @endif
                                        @if($item->address!=null) @item($item->address)  @endif
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong><i class="fa fa-calendar ml-1"></i> تاریخ تولد</strong>
                                    <p class="text-muted">
                                        @if($item->date_birth!=null) @item($item->date_birth) @else ثبت نشده @endif
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <strong><i class="fa fa-calendar-alt ml-1"></i> تاریخ ثبت</strong>
                                    <p class="text-muted">
                                        {{my_jdate($item->create,'d F Y')}}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <strong><i class="fa fa-toggle-on ml-1"></i> وضعیت</strong>
                                    <p class="text-muted">
                                        @if($item->user_status=='pending')
                                            <span class="right badge badge-warning">بررسی</span>
                                        @elseif($item->user_status=='blocked')
                                            <span class="right badge badge-danger">مسدود</span>
                                        @elseif($item->user_status=='active')
                                            <span class="right badge badge-success">تایید شده</span>
                                        @endif
                                    </p>
                                </div>
                                {{-- <div class="col-sm-6">
                                    <strong><i class="fa fa-registered ml-1"></i> معرف</strong>
                                    <p class="text-muted">
                                        @if($item->reagent_code!=null and $item->reagent_code=='rytl_user')
                                            رایتل (کد : @item($item->reagent_code))
                                        @elseif($item->reagent_code!=null and $item->reagent)
                                            @item($item->reagent->first_name) @item($item->reagent->last_name) (کد : @item($item->reagent_code))
                                        @else ثبت نشده @endif
                                    </p>
                                </div> --}}
                            </div>
                            <hr>
                            {{-- @if($item->reagent_id!=null)
                            <div class="row">
                                <div class="col-sm-12">
                                    <strong><i class="fa fa-link ml-1"></i> لینک دعوت</strong>
                                    <p class="text-muted text-left">
                                        <a title="برای کپی لینک دعوت کلیک کنید" href="javascript:void(0);" class="copy_btn" onclick="return alert('لینک کپی شد')" data-clipboard-text="{{route('user.register',$item->reagent_id)}}">{{route('user.register',$item->reagent_id)}}</a>
                                    </p>
                                </div>
                            </div>
                            <hr>
                            @endif --}}
                            {{-- <div class="row">
                                <div class="col-sm-6">
                                    <strong><i class="fa fa-calendar-alt ml-1"></i> تاریخ ثبت</strong>
                                    <p class="text-muted">
                                        {{my_jdate($item->create,'d F Y')}}
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <strong><i class="fa fa-toggle-on ml-1"></i> وضعیت</strong>
                                    <p class="text-muted">
                                        @if($item->user_status=='pending')
                                            <span class="right badge badge-warning">بررسی</span>
                                        @elseif($item->user_status=='blocked')
                                            <span class="right badge badge-danger">مسدود</span>
                                        @elseif($item->user_status=='active')
                                            <span class="right badge badge-success">تایید شده</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <hr> --}}
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div><!-- /.card -->
            </div>
        </div>
    </div>
</section>

@endsection
@section('js')

@endsection