@extends('layouts.user')

@section('content')

    <div class="login_pag mt-5" dir="rtl">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mt-5">
                    <h4 class="text-right">دسته بندی پکیج های آموزشی</h4>
                    <hr>
                    <div class="row">
                        @foreach($items as $key=>$item)
                            <div data-aos="zoom-in-left" class="col-md-4 col-sm-6 col-xs-12 mt-2">
                                <div class="hovereffect">
                                    <a href="{{route('user.packages',$item->slug)}}">
                                    <img class="img-responsive" src="{{$item->photo?url($item->photo->path):''}}" alt="سدارکارت">
                                    </a>
{{--                                        <div class="overlay">--}}
{{--                                        <h2> {{$item->title}} </h2>--}}
{{--                                        <a class="info" href="{{route('user.packages',$item->slug)}}">مشاهده</a>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="login_page_footer"></div>

@endsection
