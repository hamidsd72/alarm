
@if ( auth()->user()->user_status=='active' && !auth()->user()->hasRole('مدیر ارشد') )
    <div id="footer-bar" class="footer-bar-1" >
        <a href="{{ route('user.contact.show') }}" class="{{ \Request::route()->getName() == 'user.contact.show' ? 'active-nav' : '' }}">
            <img src="https://img.icons8.com/ultraviolet/28/000000/forgot-password.png"/>
            <span>درباره ما</span></a>
        <a href="{{ route('user.packages') }}" class="{{ \Request::route()->getName() == 'user.packages' ? 'active-nav' : '' }}">
            <img src="https://img.icons8.com/ultraviolet/28/000000/approve.png"/>
            <span>فعالیت ها</span></a>
        <a href="{{ route('user.index') }}" class="{{ \Request::route()->getName() == 'user.index' ? 'active-nav' : '' }}">
            <div class="home_route">
                <img src="https://img.icons8.com/external-icematte-lafs/36/000000/external-Home-it-icematte-lafs.png"/>
                <span style="font-size: 14px;">خانه</span>
            </div>
        </a>
        <a href="{{ route('user.tickets') }}" class="{{ \Request::route()->getName() == 'user.tickets' ? 'active-nav' : '' }}">
            <img src="https://img.icons8.com/ultraviolet/28/000000/edit-property.png"/>
            <span>درخواست ها</span>
        </a>
        {{-- @if(auth()->user()->getRoleNames()->first()=='مدیر' || auth()->user()->getRoleNames()->first()=='مدیر ارشد') --}}
        <a href="{{ route('admin.profile.show') }}" class="{{ \Request::route()->getName() == 'admin.profile.show' ? 'active-nav' : '' }}" >
            <img src="https://img.icons8.com/ultraviolet/28/000000/guest-male.png"/>
            <span>پروفایل</span>
        </a>
        {{-- @else
            <a href="{{route('user.notification.index')}}" class="{{ \Request::route()->getName() == 'user.notification.index' ? 'active-nav' : '' }}">
                <i class="fa fa-comment"></i><span>پیام ها</span></a>
        @endif --}}
    </div>
@endif
