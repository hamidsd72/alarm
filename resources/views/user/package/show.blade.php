@extends('user.master')
@section('content')
<link rel="stylesheet" href="https://cdn.map.ir/web-sdk/1.4.2/css/mapp.min.css">
<link rel="stylesheet" href="https://cdn.map.ir/web-sdk/1.4.2/css/fa/style.css">
<style>
    .vebinar-show-post-img {
        height: 200px;
    }
    .product-image-top {
        height: 260px;
    }
</style>

    <div class="container mt-5">
        <div class="mb-5 mx-md-1 pb-4 px-4 fixed-bottom col-lg-3">
            <h6>تماس با کارفرما</h6>
            <button onclick="window.open(`tel:{{$item->agent()->phone}}`);" class="btn p-0 p-md-2 px-2 px-md-3 btn-light">
                <img src="https://img.icons8.com/ultraviolet/18/000000/phone.png"/>
            </button>
            <button onclick="window.open(`tel:{{$item->agent()->mobile}}`);" class="btn p-0 p-md-2 px-2 px-md-3 btn-light mx-3">
                <img src="https://img.icons8.com/ultraviolet/18/000000/broken-phone.png"/>
            </button>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col">
                        <h6>{{$item->packageName()?$item->packageName()->title:'________'}}</h6>
                    </div>
                    <div class="col-auto">
                        <a href="{{ URL::previous() }}" class="text-secondary h6"><i class='fas fa-arrow-left'></i></a>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col">
                        <p class="small vm">
                            {{-- <span class=" text-secondary">4.5</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon-size-12 vm" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M0 0h24v24H0z" fill="none"></path>
                                <path fill="#FFD500" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                            </svg> --}}
                            <span class=" text-secondary">{{ ' کارفرما : '.$item->agent()->first_name.' '.$item->agent()->last_name }}</span>
                        </p>
                    </div>
                    <div class="col-auto">
                        <p class="small text-secondary">
                            {{my_jdate($item->started_at,'d F Y')}}
                        </p>
                    </div>
                    <div class="col-12">
                        <p>{{' محل فعالیت : '.$item->location_work}}</p>
                    </div>
                </div>
            </div>
            <div class="card-body border-top border-color">
                @if($item->file)
                    <a href="{{url($item->file->path)}}" class="btn btn-primary mb-2" download>دانلود فایل پیوست شده</a>
                @endif
                <div class="text-secondary px-2">
                    {!! $item->text !!}
                    آدرس : {{$item->agent()?$item->agent()->city.' '.$item->agent()->locate.' '.$item->agent()->address:'________'}}
                </div>
                @if ($item->agent()&&$item->agent()->long_lat)
                    {{-- <div>
                        <a target="_blank" href="{{'https://www.google.com/maps/@'.$item->agent()->long_lat}}">
                            نمایش آدرس از روی نقشه</a>
                    </div> --}}
                    <div class="py-3">
                        <div id="app" style="height: 400px"></div>
                    </div>
                @endif
                @if ($item->jobRuning->count())
                    <button onclick="openModal('{{$item->id}}')" class="btn btn-danger col-12">پایان فعالیت</button>
                @else
                    {{-- @if ($package->job->where('created_at','>',\Carbon\Carbon::now()->startOfDay())->count())
                        <a href="{{ route('user.job_create',$package->id ) }}" class="text-success">ادامه فعالیت</a>
                    @else --}}
                        <a href="{{ route('user.job_create',$item->id ) }}" class="btn btn-success col-12">شروع کردن</a>
                    {{-- @endif --}}
                @endif
            </div>
        </div>
    </div>
    <button id="clickToOpenModal" class="d-none" data-toggle="modal" data-target="#ModalTicket2">openModal</button>

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

    <script>
        function openModal($id) {
            document.getElementById('clickToOpenModal').click();
            document.getElementById('job_id').value = $id;
        }

        function copy() {
            var copyText = document.getElementById("share");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            alert('آدرس کارگاه در کلیپبورد ذخیره شد');
        }
    </script>
    <script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/mapp.env.js"></script>
    <script type="text/javascript" src="https://cdn.map.ir/web-sdk/1.4.2/js/mapp.min.js"></script>
    <script>
        $(document).ready(function() {
            var app = new Mapp({
                element: '#app',
                presets: {
                    latlng: {
                        lat: @json($lat),
                        lng: @json($lng)
                    },
                    zoom: 10
                },
                apiKey: @json($map_api_key)
            });
            app.addLayers();
            // app.addZoomControls();
            app.markReverseGeocode({
                state: {
                    latlng: {
                        lat: @json($lat),
                        lng: @json($lng),
                    },
                    zoom: 16,
                },
            });
        })
    </script>
@endsection

