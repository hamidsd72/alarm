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
    #checkbar input[type="range"] {
        direction: ltr;
        height: 10px;
        border-radius: 50px;
        overflow: hidden;
    }
    #checkbar input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: darkred;
        cursor: pointer;
        border: 2px solid red;
        box-shadow: -407px 0 0 400px khaki;
    }
    #checkbar .arrow {
        position: relative;
        left: {{ intval((100 * $leave_day_count) / $limit) }}%;
    }
    #checkbar .arrow .circle-num {
        border-radius: 50px;
        width: 28px;
        height: 27px;
        padding-top: 6px;
    }
</style>
@endsection
@section('content')
<section class="content">
    <div class="user-profile-box-border">
        <img class="profile-user-img img-circle" src="{{$item->photo? url($item->photo->path) :'https://img.icons8.com/ultraviolet/100/000000/test-account.png'}}" alt="User profile picture">
        <div class="fw-bold"> @item($item->first_name.' '.$item->last_name) <span class="font-weight-bold text-info">{{auth()->user()->getRoleNames()->first()}}</span></div>
    </div>

    <p class="m-0 mb-2 text-muted text-center">سرپرست ها : 
        @foreach (auth()->user()->my_employees()->get() as $item)
            {{$item->master()->first_name.' '.$item->master()->last_name.' '}}
        @endforeach
    </p>

    <div class="row">

        @if ($limit&&$limit > 0)
            <div class="col-lg-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <div id="checkbar" class="px-lg-2">
                            
                            <h2 class="float-right">{{$limit}}</h2>
                            <h2 class="float-left">0</h2>
                            <h1 id="value_checkbar" class="value text-center">{{$leave_day_count.' روز استفاده شده '}}</h1>
                            <div class="text-left arrow">
                                <h6 class="bg-light text-center text-dark border float-left circle-num">{{$leave_day_count}}</h6>
                            </div>
                            <input class="mx-auto bg-light" id="checkbar_range" onchange="changevalue()" type="range" min="0" max="{{$limit}}" step="1" value="{{$leave_day_count}}" disabled >
                        </div>
                    </div>
                    <a href="#" class="small-box-footer">مرخصی های استفاده شده</a>
                </div>
            </div>
        @endif
        <div class="col-lg-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{$item->email?$item->email:$item->mobile}}</h3>
                    <p><strong><i class="fa fa-calendar-alt ml-1"></i> تاریخ ثبت -  </strong>{{my_jdate($item->create,'d F Y')}}</p>
                </div>
                <div class="icon"><i class="fa fa-user text-secondary"></i></div>
                <a href="{{route('admin.profile.edit')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="small-box bg-primary">
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
            <div class="small-box bg-secondary">
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

    </div>
</section>

@endsection
{{-- <script>
    function changevalue() {
        let checkbar_range_value = document.getElementById('checkbar_range').value;
        document.getElementById('value_checkbar').innerHTML = checkbar_range_value;
    }
</script> --}}
@section('js')
@endsection