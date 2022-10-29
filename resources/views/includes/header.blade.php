<style>
    .menu-overlay .main-menu .menu-container .nav-pills .nav-item .nav-link {
        text-align: right !important;
    }
</style>

@if (auth()->user()->user_status=='active')

    <header class="header" style="min-height: 60px !important;">
        <div class="row mb-0 pt-1">
            <div class="col-auto px-0">
            </div>
            <div class="text-left col">
                <a class="navbar-brand" href="#">
                    <div class="icon icon-44 text-white" style="height: 40px;width: 40px;">
                        <img src="{{ $setting->icon_site?url($setting->icon_site):'' }}" alt="{{ $setting->title }}" style="width: 100%;">
                    </div>
                    {{-- <a href="#" class="px-3 text-dark h6">{{ $setting->title }}</a> --}}
                </a>
            </div>
            <div class="ml-auto col-auto">
                <a href="{{route('user.notification.index')}}" class="mx-2 small">
                    <img src="https://img.icons8.com/ultraviolet/18/000000/reading-confirmation.png"/>
                    {{$notification>0?$notification.' خوانده نشده ':''}}
                </a>
                <button class="menu-btn btn btn-link-default" type="button">
                    <img src="https://img.icons8.com/ultraviolet/28/000000/drag-list-down.png"/>
                </button>
            </div>
        </div>
    </header>

    <div class="main-menu">
        <div class="menu-container">
            <div class="icon icon-100 position-relative">
                <figure class="background">
                    <img src="{{ $setting->icon_site?url($setting->icon_site):'' }}" alt="{{ $setting->title }}" style="width: 100%;">
                </figure>
            </div>
            <ul class="nav nav-pills flex-column ">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('user.index') }}">
                        <i class="me-1 fa fa-home"></i>
                        صفحه اصلی
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.profile.show') }}">
                        <i class="me-1 fa fa-user"></i>
                        پروفایل
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.tickets') }}">
                        <i class="me-1 fa fa-edit"></i>
                        درخواست ها
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.packages') }}">
                        <i class="me-1 fa fa-check-square"></i>
                        فعالیت ها
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.notification.index') }}">
                        <i class="me-1 fa fa-envelope-open"></i>
                        پیام ها
                    </a>
                </li>
                
                @role('مدیر') 
                    <li class="nav-item">
                        <a href="{{route('user.user-transaction.create')}}" class="nav-link">
                            <i class="me-1 fa fa-dollar"></i>
                            ارتقا پکیج
                        </a>
                    </li>
                @endrole

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('user.contact.show') }}">
                        <i class="mx-1 fa fa-info"></i>
                        درباره ما
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ env('LEARN_CHANNEL_URl') }}" target="_blank">
                        <i class="fa fa-desktop"></i>
                        چنل آموزش ها
                    </a>
                </li>
                
            </ul>
            <a class="text-danger my-2 d-block" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="me-1 fa fa-sign-out"></i>
                خروج از حساب
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            <button class="btn btn-secondary sqaure-btn close text-white"><svg xmlns='http://www.w3.org/2000/svg' class="icon-size-24" viewBox='0 0 512 512'>
                    <title>ionicons-v5-l</title>
                    <line x1='368' y1='368' x2='144' y2='144' style='fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px' />
                    <line x1='368' y1='144' x2='144' y2='368' style='fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px' />
                </svg></button>
        </div>
    </div>

@endif

