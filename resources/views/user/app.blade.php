@extends('user.master')
<style>
    #mamad span:hover img {
        padding: 18px;
        transition: 0.4s;
    }
    #mamad span img {
        padding: 12px;
    }
</style>
@section('content')
    @if ($runningJob)
        <div class="runningJob">
            <a href="#" class="text-danger" id="clickToOpenModal2"data-toggle="modal" data-target="#ModalTicket2">
                توقف کار
                <i class="fa fa-refresh fa-spin" style="font-size:12px"></i>
            </a>
        </div>
    @endif

    <!-- page content start -->
    <button id="clickToOpenModal" class="d-none" data-toggle="modal" data-target="#ModalTicket">openModal</button>
    <button id="clickToOpenModal2" class="d-none" data-toggle="modal" data-target="#ModalTicket2">openModal</button>
    <button id="clickToOpenModal3" class="d-none" data-toggle="modal" data-target="#ModalTicket3">openModal</button>

    <div class="container">
        <div class="form-group mb-0 mt-5 pt-2">
            <form action="{{route('user.user-search.store')}}" method="post">
                @csrf
                <div class="row mb-0">
                    <div class="col">
                        <input type="hidden" name="type" value="package">
                        <input type="text" class="form-control search" name="search" placeholder="جستجو در فعالیت های من">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- demo slider top -->
    <div class="my-4 container">
        <div id="demo" class="carousel slide" data-ride="carousel">
            <ul class="carousel-indicators">
                @for ($i = 0; $i < $sliders->count(); $i++)
                    <li data-target="#demo" data-slide-to="{{$i}}" class="{{$i==0?'active':''}}"></li> 
                @endfor
            </ul>
            <div class="carousel-inner">
                @foreach ($sliders as $key => $slider)
                    <div class="carousel-item {{$key==0?'active':''}}">
                        <a href="{{$slider->link}}" >
                            <img src="{{$slidersPhotos->where('pictures_id', $slider->id)->first()->path}}" alt="Los Angeles">
                            <div class="carousel-caption p-1 p-lg-2" style="background: #20364bad;right: 2%;width: 96%;bottom: 4% !important;border-radius: 12px">
                                <a href="{{$slider->link}}" class="px-2 text-white" style="font-size: 16px;">{{$slider->title}}</a>
                                <div class="float-left">
                                    <div class="tag-images-count text-white px-2">
                                        <span class="vm px-1">{{($key+1).' از '.$sliders->count()}}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon-size-16 vm" viewBox="0 0 512 512">
                                            <title>ionicons-v5-e</title>
                                            <path d="M432,112V96a48.14,48.14,0,0,0-48-48H64A48.14,48.14,0,0,0,16,96V352a48.14,48.14,0,0,0,48,48H80" style="fill:none;stroke:#000;stroke-linejoin:round;stroke-width:32px"></path>
                                            <rect x="96" y="128" width="400" height="336" rx="45.99" ry="45.99" style="fill:none;stroke:#000;stroke-linejoin:round;stroke-width:32px"></rect>
                                            <ellipse cx="372.92" cy="219.64" rx="30.77" ry="30.55" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:32px"></ellipse>
                                            <path d="M342.15,372.17,255,285.78a30.93,30.93,0,0,0-42.18-1.21L96,387.64" style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></path>
                                            <path d="M265.23,464,383.82,346.27a31,31,0,0,1,41.46-1.87L496,402.91" style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></path>
                                        </svg>
                                    </div>
                                </div>

                            </div>   
                        </a>
                    </div>
                @endforeach
            </div> 
        </div>
    </div>

    {{-- فعالیت ها --}}
    @unless ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') )
        <div class="container mt-4">
            <div class="card">
                <div class="card-header">
                    <div class="row mb-0">
                        <div class="col">
                            <h6 class="text-dark my-1">
                                <img src="https://img.icons8.com/ultraviolet/18/000000/new-job.png"/>
                                <span class="vm ml-2">فعالیت های امروز</span>
                            </h6>
                        </div>
                        <div class="col-auto">
                            <a class="dropdown-item" href="{{ route('user.packages') }}">نمایش همه</a>
                        </div>
                    </div>
                </div>
                @if ($packages->count()<1)
                    <h6 class="text-center mb-2">برای امروز موردی یافت نشد</h6>
                @endif
                @foreach($packages as $key => $package)
                    <div class="col-lg-12">
                        <div class="card product-card-small mb-0" style="box-shadow: none;">
                            <div class="card-body pt-0">
                                <div class="row mb-0 border redu30">
                                    <div class="col mt-2 px-3">
                                        <div class="row mb-1">
                                            <div class="col">
                                                {{-- <p ><a href="{{route('user.package',$package->slug)}}" class="text-dark">{{$package->title }}</a></p> --}}
                                                <h6>{{$package->packageName()?$package->packageName()->title:'________'}}</h6>
                                                <p>
                                                    {{-- {{$package->agent()?$package->agent()->city.' '.$package->agent()->locate.' '.$package->agent()->address:'________'}} --}}
                                                    {{$package->agent()?$package->agent()->city.' '.$package->agent()->locate.' ...':'________'}}
                                                </p>
                                            </div>
                                            <div class="col-auto">
                                                <p class="small vm show_job_time" id="{{$package->id.'show_job_time'}}">
                                                    <span class=" text-secondary">
                                                        @if ($package->jobRuning->count())
                                                            <a href="#" id="clickToOpenModal2"data-toggle="modal" data-target="#ModalTicket2">
                                                                <i class="fa fa-refresh fa-spin" style="font-size:12px"></i>
                                                                {{( $package->jobTodayTime() + $package->jobRuning->first()->created_at->diffInMinutes(\Carbon\Carbon::now(), false) + 1 ).' دقیقه '}}
                                                            </a>
                                                            <br>
                                                        @endif
                                                        @if ($package->job->count())
                                                            {{ ' کل زمان '.$package->jobTodayTime().' دقیقه '}}
                                                        @else
                                                            هنوز شروع نکرده اید
                                                        @endif
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row mb-0 no-gutters">
                                            <div class="col">
                                                <p class="small vm">
                                                    {{-- <span class="text-secondary">{{$package->started_at}}</span> --}}
                                                    <span class="text-dark">{{' محل فعالیت : '.$package->location_work}}</span>
                                                </p>
                                            </div>
                                            <div class="col-auto mb-1">
                                                <p class="small text-secondary">
                                                    <a href="{{ route('user.package',$package->slug) }}" class="btn btn-primary p-0 px-3">نمایش جزییات</a>

                                                    <small class="job_staus_run_btn ms-1" id="{{$package->id.'job_staus_run_btn'}}">
                                                        @if ($package->jobRuning->count())
                                                            <button onclick="openModal2('{{$package->id}}')" class="btn btn-danger p-0 px-3">پایان فعالیت</button>
                                                        @else
                                                            {{-- @if ($package->job->where('created_at','>',\Carbon\Carbon::now()->startOfDay())->count())
                                                                <a href="{{ route('user.job_create',$package->id ) }}" class="text-success">ادامه فعالیت</a>
                                                            @else --}}
                                                            <button onclick="start_job('{{$package->id,$package->location_work}}')" class="btn btn-success p-0 px-3">شروع کردن</button>
                                                            {{-- @endif --}}
                                                        @endif
                                                    </small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endunless
    
    {{-- درخواست ها --}}
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <div class="row mb-0">
                    <div class="col">
                        <h6 class="text-dark my-1">
                            <img src="https://img.icons8.com/ultraviolet/18/000000/chat.png"/>
                            <span class="vm ml-2">ارسال درخواست</span>
                        </h6>
                    </div>
                    <div class="col-auto">
                        <a class="dropdown-item" href="{{ route('user.tickets') }}">نمایش همه</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row px-2 mb-0" id="mamad">
                    <div class="col-6 col-md-3 px-2 mb-3" onclick="openModal('درخواست مساعده')">
                        <input type="radio" name="facilitiestype" class="checkbox-boxed" id="parking">
                        <label class="checkbox-lable" for="parking">
                            <span class="image-boxed text-white">
                                <img src="https://img.icons8.com/ultraviolet/40/000000/get-cash.png"/>
                            </span>
                            <span class="pt-2 h6">مساعده</span>
                        </label>
                    </div>
                    <div class="col-6 col-md-3 px-2 mb-3" onclick="openModal('درخواست تنخواه')">
                        <input type="radio" name="facilitiestype" class="checkbox-boxed" id="sport">
                        <label class="checkbox-lable" for="sport">
                            <span class="image-boxed text-white">
                                <img src="https://img.icons8.com/ultraviolet/40/000000/get-cash.png"/>
                            </span>
                            <span class="pt-2 h6">تنخواه</span>
                        </label>
                    </div>
                    <div class="col-6 col-md-3 px-2 mb-3" onclick="openModal('درخواست مرخصی')">
                        <input type="radio" name="facilitiestype" class="checkbox-boxed" id="garden">
                        <label class="checkbox-lable" for="garden">
                            <span class="image-boxed text-white">
                                <img src="https://img.icons8.com/ultraviolet/40/000000/leaving-queue.png"/>
                            </span>
                            <span class="pt-2 h6">مرخصی</span>
                        </label>
                    </div>
                    <div class="col-6 col-md-3 px-2 mb-3" onclick="openModal('درخواست ثبت گزارش کار')">
                        <input type="radio" name="facilitiestype" class="checkbox-boxed" id="gardeeen">
                        <label class="checkbox-lable" for="gardeeen">
                            <span class="image-boxed text-white">
                                <img src="https://img.icons8.com/ultraviolet/40/000000/rebalance-portfolio.png"/>
                            </span>
                            <span class="pt-2 h6">گزارش کار</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-2">
        <div class="card" id="addtodevice">               
            <div class="card-body">
                <h6 class="text-dark">
                    <img src="https://img.icons8.com/ultraviolet/18/000000/rebalance-portfolio.png">
                    بررسی <span class="font-weight-bold">گزارشات اخیر</span>
                </h6>

                <div class="row my-3 border redu30">
                    <div class="col-auto align-self-center">
                        <img src="https://img.icons8.com/ultraviolet/40/000000/rebalance-portfolio.png"/ class="rounded ms-2">
                    </div>
                    <div class="col text-secondary pl-0">
                        <p class=" text-secondary my-1">گزارش کارکرد های اخیر</p>
                        <a href="{{ route('user.user-my-report.show','rollCall') }}" class="btn btn-primary mb-2 p-0 px-4">نمایش</a>
                    </div>
                </div>
                <div class="row my-3 border redu30">
                    <div class="col-auto align-self-center">
                        <img src="https://img.icons8.com/ultraviolet/40/000000/new-job.png"/ class="rounded ms-2">
                    </div>
                    <div class="col text-secondary pl-0">
                        <p class=" text-secondary my-1">گزارش فعالیت های اخیر</p>
                        <a href="{{ route('user.user-my-report.show','job') }}" class="btn btn-primary mb-2 p-0 px-4">نمایش</a>
                    </div>
                </div>
                <div class="row my-3 border redu30">
                    <div class="col-auto align-self-center">
                        <img src="https://img.icons8.com/ultraviolet/40/000000/leaving-queue.png"/ class="rounded ms-2">
                    </div>
                    <div class="col text-secondary pl-0">
                        <p class=" text-secondary my-1">گزارش مرخصی های اخیر</p>
                        <a href="{{ route('user.user-my-report.show','leave-day') }}" class="btn btn-primary mb-2 p-0 px-4">نمایش</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    {{-- تماس با پشتیبانی --}}
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h5><img class="me-1" src="https://img.icons8.com/ultraviolet/18/000000/phone.png"/>تماس با پشتیبانی</h5>
                <p class="text-secondary mb-2">جهت دریافت راهنمایی با کلیک روی دکمه زیر با واحد پشتیبانی تماس بگیرید</p>
                <button onclick="window.open(`tel:{{$setting->support_call}}`);" class="btn btn-success">
                    <img class="me-1" src="https://img.icons8.com/ultraviolet/18/000000/phone.png"/>
                    تماس 
                </button>
            </div>
        </div>
    </div>

    @include('includes.footer')

    <div class="modal fade" id="ModalTicket" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content redu20"> 
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="content mt-0">
                        <form method="post" action="{{route('user.contact.post')}}" enctype="multipart/form-data">
                            @csrf
                            <fieldset>
                                <input type="hidden" name="subject" id="subject" >
                                                                
                                <div class="col-12" id="perDate">
                                    <div class="row m-0 ms-3">
                                        <div class="col">
                                            <div class="form-field form-text">
                                                <label class="contactMessageTextarea color-theme" for="date">از تاریخ</label>
                                                <div class="row">
                                                    <div class="col-10 p-0">
                                                        <input type="text" name="date" class="col-12 round-small mb-0 date_p" id="date">
                                                    </div>
                                                    <div class="col-2">
                                                        <img src="https://img.icons8.com/external-icematte-lafs/28/000000/external-Calendar-it-icematte-lafs.png">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-field form-text">
                                                <label class="contactMessageTextarea color-theme" for="date">تا تاریخ</label>
                                                <div class="row">
                                                    <div class="col-10 p-0">
                                                        <input type="text" name="date2" class="col-12 round-small mb-0 date_p" id="date">
                                                    </div>
                                                    <div class="col-2">
                                                        <img src="https://img.icons8.com/external-icematte-lafs/28/000000/external-Calendar-it-icematte-lafs.png">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="lorem-box">
                                    <div class="form-field form-text">
                                        <label class="contactMessageTextarea color-theme" for="lorem2">زمان مرخصی</label>
                                        <select id="lorem2" name="lorem2" id="lorem2" class="form-control mb-3">
                                            <option value=" - مرخصی روزانه " selected>روزانه</option>
                                            <option value=" - مرخصی ساعتی ">ساعتی</option>
                                            <option value=" - مرخصی استعلاجی ">استعلاجی</option>
                                            <option value=" - مرخصی تشویقی ">تشویقی</option>
                                        </select>
                                    </div>
                                    <div class="form-field form-text">
                                        <label class="contactMessageTextarea color-theme" for="lorem3">نوع مرخصی</label>
                                        <select id="lorem3" name="lorem3" id="lorem3" class="form-control mb-3">
                                            <option value=" با حقوق " selected>با حقوق</option>
                                            <option value=" بدون حقوق ">بدون حقوق</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-field form-text">
                                    <label class="contactMessageTextarea color-theme" for="text">متن:<span>(required)</span></label>
                                    <textarea name="text" class="round-small mb-0" id="text"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label class="contactMessageTextarea color-theme" for="attach">الحاق فایل:</label>
                                    <input type="file" name="attach" id="attach" class="form-control">
                                </div>
                                <div class="form-button">
                                    <input type="submit" class="btn btn-primary col-12" value="ارسال پیام" data-formid="contactForm">
                                </div>
                            </fieldset> 
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="ModalTicket2" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content redu20"> 
                <div class="modal-header">
                    <h4 class="modal-title">ثبت گزارش از فعالیت انجام شده</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="content mt-0">
                        <form method="POST" action="{{route('user.job_stop')}}" enctype="multipart/form-data">
                            @csrf
                            <fieldset>
                                <input type="hidden" name="job_id" id="job_id">
                                                 
                                <div class="form-field form-text">
                                    <label class="contactMessageTextarea color-theme" for="description">متن:<span>(required)</span></label>
                                    <textarea name="description" class="round-small mb-0" id="description" required></textarea>
                                </div>
                                <div class="form-field form-text">
                                    <label class="contactMessage color-theme" for="price">هزینه ها:<span>(required)</span></label>
                                    <input type="number" name="price" id="price" class="col-12 text-end round-small mb-0">
                                </div>
                                <div class="mb-4">
                                    <label class="contactMessageTextarea color-theme" for="attach">الحاق فایل:</label>
                                    <input type="file" name="attach" id="attach" class="form-control">
                                </div>
                                <div class="form-button">
                                    <input type="submit" class="btn btn-primary col-12" value=" ثبت گزارش و پایان فعالیت" data-formid="contactForm">
                                </div>
                            </fieldset> 
                        </form>
                    </div>
                </div>
            </div>
    
        </div>
    </div>

    <div class="modal fade" id="ModalTicket3" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content redu20"> 
                <div class="modal-header">
                    <h4 class="modal-title">ثبت گزارش از فعالیت انجام شده (آفلاین)</h4>
                    <button type="button" id="closeToOpenModal3" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="content mt-0">
                            @csrf
                        <fieldset>
                            <div class="form-field form-text">
                                <label class="contactMessageTextarea color-theme" for="description">متن:<span>(required)</span></label>
                                <textarea id="description_offline_job" name="description" class="round-small mb-0" required></textarea>
                            </div>
                            {{-- <div class="mb-4">
                                <label class="contactMessageTextarea color-theme" for="attach">الحاق فایل:</label>
                                <input type="file" name="attach" id="attach" class="form-control">
                            </div> --}}
                            <div class="form-button">
                                <input onclick="stop_job()" class="btn btn-primary col-12" value=" ثبت گزارش و پایان فعالیت" data-formid="contactForm">
                            </div>
                        </fieldset> 
                    </div>
                </div>
            </div>
    
        </div>
    </div>

    <script>
        function stop_job() {
            let description = document.getElementById("description_offline_job").value
            localStorage.setItem("job_description", description);
            document.getElementById("offline_start_job_alert").innerHTML = "<div class='text-center p-0 m-0 mt-5 pt-4 pb-2 alert alert-warning' role='alert'>گزارش فعالیت بصورت آفلاین ثبت شد, برای ارسال به سرور صفحه را بارگذاری مجدد کنید<button type='button' class='close h6' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button></div>";
            document.getElementById('closeToOpenModal3').click();
            check_job_started()
        }
            
        function check_job_started() {
            let elementOne = `${localStorage.getItem("job_id")}show_job_time`;
            let elementTwo = `${localStorage.getItem("job_id")}job_staus_run_btn`;
            
            if (localStorage.getItem("job_id")) {
                // اگر جاب بسته شده بود 
                if (localStorage.getItem("job_description")) {
                    // اگر آنلاین بود حاب رو ارسال کن
                    if (navigator.onLine) {
                        console.log('انلاین');
                        let send_offline_job = '{{url('/')}}'+`/offline/job/create/${localStorage.getItem("job_id")}/${localStorage.getItem("job_created_at")}/${localStorage.getItem("job_description")}`;
                        location.href = send_offline_job;
                        localStorage.removeItem("job_id");
                        localStorage.removeItem("job_created_at");
                        localStorage.removeItem("job_description");                        
                        check_job_started()
                    }
                    const one = document.getElementsByClassName("show_job_time");
                    for (let i = 0; i < one.length; i++) {
                        one[i].innerHTML = "<button >در انتظار ارسال</button>";
                    }
                    const two = document.getElementsByClassName("job_staus_run_btn");
                    for (let i = 0; i < two.length; i++) {
                        two[i].innerHTML = "<button class='btn btn-warning p-0 px-3'>در انتظار ارسال</button>";
                    }
                }
                // اگر جاب در حال اجرا بود
                else {
                    document.getElementById(elementOne).innerHTML = "<button >شروع درحالت آفلاین<i class='fa fa-refresh fa-spin text-warning' style='font-size:12px'></i></button>";
                    document.getElementById(elementTwo).innerHTML = "<button onclick='openModal3()' class='btn btn-danger p-0 px-3'>پایان فعالیت</button>";
                }
            }
        }

        function start_job(id,state) {
            let url = '{{url('/')}}'+`/job/create/${id}`;

            let time_now = new Date();
            let date = `${time_now.getFullYear()}-${time_now.getMonth()+1}-${time_now.getDate()}`;
            let time = `${time_now.getHours()}:${time_now.getMinutes()}:${time_now.getSeconds()}`;
            let created_at = `${date} ${time}`;

            // اگر آنلاین بود ارسال بشه
            if (navigator.onLine) {
                location.href = url;
            } 
            // اگر آفلاین بود و جاب فعال داشت اخطار بده
            else if (localStorage.getItem("job_id")) {
                document.getElementById("offline_start_job_alert").innerHTML = "<div class='text-center p-0 m-0 mt-5 pt-4 pb-2 alert alert-danger' role='alert'>یک فعالیت در حال اجرا هست<button type='button' class='close h6' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button></div>";
            } 
            // اگر آفلاین بود و حاب هم نداشت حاب آفلاین ثبت بشه
            else {
                if (state=='خارج از شهر') {
                    localStorage.setItem("job_id", id);
                    localStorage.setItem("job_created_at", created_at);
                    document.getElementById("offline_start_job_alert").innerHTML = "<div class='text-center p-0 m-0 mt-5 pt-4 pb-2 alert alert-warning' role='alert'>شروع فعالیت در حالت آفلاین<button type='button' class='close h6' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button></div>";
                    check_job_started()
                } else {
                    alert('ثبت آفلاین برای فعالیت های داخل شهری دردسترس نیست')
                }
            }
        }
        
        function openModal($name) {
            document.getElementById('clickToOpenModal').click();
            document.getElementById('subject').value = $name;
            document.getElementById("modal-title").innerHTML = `<span>${$name}</span>`;
            if ($name == 'درخواست مرخصی') {
                document.getElementById("lorem-box").style.display = "block";
                document.getElementById("perDate").style.display = "block";
            }
            else if ($name == 'درخواست ثبت گزارش کار') {
                document.getElementById("lorem-box").style.display = "none";
                document.getElementById("perDate").style.display = "block";
            } else {
                document.getElementById("lorem-box").style.display = "none";
                document.getElementById("perDate").style.display = "none";
            }
        }

        function openModal2($id) {
            document.getElementById('clickToOpenModal2').click();
            document.getElementById('job_id').value = $id;
        }

        function openModal3() {
            document.getElementById('clickToOpenModal3').click();
        }

        function ConvertNumberToPersion() {
            let persian = { 0: '۰', 1: '۱', 2: '۲', 3: '۳', 4: '۴', 5: '۵', 6: '۶', 7: '۷', 8: '۸', 9: '۹' };
            function traverse(el) {
                if (el.nodeType == 3) {
                    var list = el.data.match(/[0-9]/g);
                    if (list != null && list.length != 0) {
                        for (var i = 0; i < list.length; i++)
                            el.data = el.data.replace(list[i], persian[list[i]]);
                    }
                }
                for (var i = 0; i < el.childNodes.length; i++) {
                    traverse(el.childNodes[i]);
                }
            }
            traverse(document.body);
        }

        ConvertNumberToPersion()
        check_job_started()
    </script>

@endsection
