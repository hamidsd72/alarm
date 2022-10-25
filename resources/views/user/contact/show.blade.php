@extends('user.master')

@section('content')
<style> .opacity-80 { background: #2F2D51 !important; } </style>
    <div class="container pt-5 mt-3">
        <div class="card card-style preload-img entered loaded mt-4 mb-3" data-src="{{$about->pic_home?$about->pic_home:'images/pictures/18w.jpg'}}" data-card-height="180" data-ll-status="loaded" style="height: 180px; background-image: url({{$about->pic_home?$about->pic_home:'images/pictures/18w.jpg'}});">
            <div class="card-center ms-3">
                <h1 class="color-white mb-0">{{ $about->title_home }}</h1>
                <p class="color-white mt-n1 mb-0"></p>
            </div>
            <div class="card-center me-3">
            </div>
            <div class="card-overlay opacity-80"></div>
        </div>
        <div class="card card-style">
            <div class="content">
                <h4>{{ $about->title_home }}</h4>
                    {!! $about->text_home !!}
            </div>
        </div>
    </div>
    @include('includes.footer')

@endsection

