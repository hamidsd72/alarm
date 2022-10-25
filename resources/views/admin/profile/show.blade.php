@extends('layouts.admin')
@section('css')
<style>
    .user-profile-box-border {
        border: 1px solid gray;
        border-radius: 4px;
        padding: 0px;
    }
    @media only screen and (max-width: 640px) {
        .small-box h3 {
            font-size: 16px !important;
        }
    }
    .small-box > .small-box-footer {
        font-size: 12px !important;
    }
    .small-box {
        border-radius: 20px;
    }
    .small-box>.small-box-footer {
        border-radius: 20px;
        margin: 0px 12px;
    }
    .user-profile-box-border {
        border: none;
        text-align: center;
    }
    .row .small-box .inner h3 , .row .small-box .inner p {
        color: white !important;
    }
    @media only screen and (max-width: 640px) {
        .row .small-box .inner h3 , .row .small-box .inner p {
            margin: 0px;
        }
    }
</style>
@endsection
@section('content')
<section class="content">
    {{-- @role('مدیر ارشد') 
        <div class="text-center pb-3">بخش ویژه ادمین</div>
        <div class="row mb-5">
            <div class="col-6 col-lg-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{App\Model\Transaction::where('status',100)->count()}} مورد</h3>
                        <p>سفارشات موفق</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('admin.service.buy.list')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                    <a href="{{route('admin.report.transaction.list')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{App\Model\Transaction::where('status','!=',100)->count()}} مورد</h3>
                        <p>سفارشات ناموفق</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('admin.report.transaction.create')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                    <a href="{{route('admin.service.buy.list')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{App\User::count()}} نفر</h3>
                        <p>کاربران ثبت شده</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{route('admin.user.list')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div> --}}
            {{-- <div class="col-6 col-lg-4">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{App\Model\Visit::whereDate('created_at',date('Y-m-d'))->sum('view')}} مرتبه</h3>
                        <p>بازدید روز</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer"> <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{App\Model\UserForm::where("pay_status" , "active")->count()}} نفر
                            {{App\Model\UserForm::where("pay_status" , "active")->where('status', '=', 'درحال بررسی')->count()}} در انتظار</h3>
                        <p>سفارش قرارداد و فرم</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check-square-o"></i>
                    </div>
                    <a href="{{route('user.forms.index')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{App\Model\TourForm::where('cancel', 'active')->count().' کل '.App\Model\TourForm::where('cancel', 'cancel')->count().' کنسلی '}}</h3>
                        <p>سفارش تور و مسافرت</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-plane"></i>
                    </div>
                    <a href="{{route('user.user-tours.index')}}" class="small-box-footer"> <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div> --}}
        {{-- </div>
    @endrole --}}
    <div class="user-profile-box-border">
        <img class="profile-user-img img-circle" src="{{$item->photo? url($item->photo->path) :'https://img.icons8.com/ultraviolet/100/000000/test-account.png'}}" alt="User profile picture">
        <div class="fw-bold"> @item($item->first_name) @item($item->last_name)</div>
    </div>

    <p class="text-muted text-center mb-2">@item($item->education)</p>
    <div class="container-fluid pb-3">
        {{-- <div class="row">
            <div class="col-sm-6">
                <strong><i class="fa fa-calendar-alt ml-1"></i> تاریخ ثبت</strong>
                <p class="text-muted">
                    {{my_jdate($item->create,'d F Y')}}
                </p>
            </div>
            <div class="col-sm-6">
                <strong><i class="fa fa-mobile ml-1"></i> موبایل</strong>
                <p class="text-muted">
                    @if($item->mobile!=null) @item($item->mobile) @else ثبت نشده @endif
                    @if($item->mobile_status=='pending')
                        <span class="right badge badge-danger">تایید نشده</span>
                    @elseif($item->mobile_status=='active')
                            <span class="right badge badge-success">تایید شده</span>
                    @endif
                </p>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-lg-6">
                <div class="small-box bg-dark">
                    <div class="inner">
                        <h3>
                            {{-- @if($item->mobile!=null) @item($item->mobile) @else ثبت نشده @endif --}}
                            {{$item->email?$item->email:$item->mobile}}
                            {{-- @if($item->mobile_status=='pending')
                                <span class="right badge badge-danger">تایید نشده</span>
                            @elseif($item->mobile_status=='active')
                                    <span class="right badge badge-success">تایید شده</span>
                            @endif --}}
                        </h3>
                        <p><strong><i class="fa fa-calendar-alt ml-1"></i> تاریخ ثبت -  </strong>{{my_jdate($item->create,'d F Y')}}</p>
                    </div>
                    <div class="icon"><i class="fa fa-user text-secondary"></i></div>
                    <a href="{{route('admin.profile.edit')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div>
            {{-- <div class="col-6 col-lg-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{App\Model\UserForm::where("pay_status" , "active")->where('user_id',auth()->user()->id)->count()}} مورد</h3>
                        <p>فرم و قرارداد های من</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check-square-o"></i>
                    </div>
                    <a href="{{route('user.forms.index')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{App\Model\TourForm::where('user_id',auth()->user()->id)->where('cancel', 'active')->count().' نفر '}}
                            {{App\Model\TourForm::where('user_id',auth()->user()->id)->where('cancel', 'cancel')->count().' کنسلی '}}</h3>
                        <p>تور و مسافرت های من</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-plane"></i>
                    </div>
                    <a href="{{route('user.user-tours.index')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div>
            <div class="col-6 col-lg-4">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{App\Model\Transaction::where('user_id',auth()->user()->id)->where('status',100)->count()}} مورد</h3>
                        <p>تراکنش های من</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('admin.report.transaction.list')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div> --}}
            <div class="col-lg-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{App\Model\ServicePackage::where('user_id', auth()->user()->id)->where('status', 'active')->where('type', 'sample')->count()}} مورد</h3>
                        <p>محاسبه فعالیت های من</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="{{route('user.job-report.show',auth()->user()->id)}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{App\Model\ServicePackage::where('user_id', auth()->user()->id)->where('status', 'active')->where('type', 'sample')->count()}} مورد</h3>
                        <p>فعالیت های من</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="{{route('user.packages')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{App\Model\Notification::where('user_id',auth()->user()->id)->where('status',"pending")->count()}} جدید</h3>
                        <p>پیام های من</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-comment-o"></i>
                    </div>
                    <a href="{{route('user.notification.index')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{App\Model\Contact::where('user_id', auth()->user()->id )->count()}} تیکت</h3>
                        <p>تیکت های من</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-comment-o"></i>
                    </div>
                    <a href="{{route('user.tickets')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div>
            
            @role('مدیر ارشد') 
                <div class="col-lg-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{App\User::where('reagent_id', auth()->user()->id)->count()}} نفر</h3>
                            <p>تعداد مشتریان</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{route('admin.user.list')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
            @endrole
            @role('مدیر') 
                <div class="col-lg-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>افزایش اعتبار</h3>
                            <p>{{ App\User::where('reagent_id', auth()->user()->id )->count().' از '.auth()->user()->employees_number.' کارمند و ' }}
                                {{ auth()->user()->sms_inventory.' پیامک باقی مانده دارید ' }}
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-dollar"></i>
                        </div>
                        <a href="{{route('user.user-transaction.create')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
            @endrole
            
            {{-- <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{App\User::count()}}</h3>

                        <p>کاربران ثبت شده</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{route('admin.user.list')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{App\Model\Visit::whereDate('created_at',date('Y-m-d'))->sum('view')}}</h3>

                        <p>بازدید روز</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="" class="small-box-footer"> <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div>  --}}
        </div>
        {{-- 
        <div class="row">
            <div class="col-sm-6">
                <strong><i class="fa fa-at ml-1"></i> ایمیل </strong>
                <p class="text-muted">
                    @if($item->email!=null) @item($item->email)
                    @if($item->email_status=='pending')
                        <span class="right badge badge-danger">تایید نشده</span>
                    @elseif($item->email_status=='active')
                        <span class="right badge badge-success">تایید شده</span>
                    @endif
                    @else
                        ثبت نشده
                    @endif
                </p>
            </div>
            <div class="col-sm-6">
                <strong><i class="fa fa-mobile ml-1"></i> موبایل</strong>
                <p class="text-muted">
                    @if($item->mobile!=null) @item($item->mobile) @else ثبت نشده @endif
                    @if($item->mobile_status=='pending')
                        <span class="right badge badge-danger">تایید نشده</span>
                    @elseif($item->mobile_status=='active')
                            <span class="right badge badge-success">تایید شده</span>
                    @endif
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
            <div class="col-sm-6">
                <strong><i class="fa fa-whatsapp ml-1"></i> تاریخ تولد</strong>
                <p class="text-muted">
                    @if($item->date_birth!=null) @item($item->date_birth) @else ثبت نشده @endif
                </p>
            </div>
            <div class="col-sm-6">
                <strong><i class="fa fa-registered ml-1"></i> معرف</strong>
                <p class="text-muted">
                    @if($item->reagent_code!=null and $item->reagent_code=='rytl_user')
                        رایتل (کد : @item($item->reagent_code))
                    @elseif($item->reagent_code!=null and $item->reagent)
                        @item($item->reagent->first_name) @item($item->reagent->last_name) (کد : @item($item->reagent_code))
                    @else ثبت نشده @endif
                </p>
            </div>
        </div>
        <hr>
        @if($item->reagent_id!=null)
        <div class="row">
            <div class="col-sm-12">
                <strong><i class="fa fa-link ml-1"></i> لینک دعوت</strong>
                <p class="text-muted text-left">
                    <a title="برای کپی لینک دعوت کلیک کنید" href="javascript:void(0);" class="copy_btn" onclick="return alert('لینک کپی شد')" data-clipboard-text="{{route('user.register',$item->reagent_id)}}">{{route('user.register',$item->reagent_id)}}</a>
                </p>
            </div>
        </div>
        <hr>
        @endif
        <div class="row">
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
        <hr>
        <div class="row">
            <div class="col">
                <a href="{{route('admin.profile.edit')}}" class="btn btn-block btn-outline-primary"><b>ویرایش پروفایل</b></a>
            </div>
            <div class="col">
                <a href="{{route('admin.password.edit')}}" class="btn btn-block btn-outline-secondary"><b>ویرایش رمز عبور</b></a>
            </div>
        </div> --}}
    </div>
</section>

@endsection
@section('js')
    
@endsection