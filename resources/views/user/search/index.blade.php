@extends('user.master')
@section('content')
    <div class="card card-style" style="background: none;box-shadow: none;">

        <form action="{{route('user.services-search')}}" method="post">
            @csrf
            <div class="input-group px-4">
                <div class="input-group-append bg-white text-dark p-2 px-3" style="border-radius:0px 20px 20px 0px;">
                <span class="bg-violet pr-3 pl-3 shadow" style="border-radius:20px 0px 0px 20px;">
                    <div class="mt-2">
                        <i class="fas fa-search"></i>
                    </div>
                </span>
                </div>
                <input type="text" name="search" class="form-control" style="border-radius:20px 0px 0px 20px;color:#3c0b64;border: none;" 
                 placeholder="جستجو در مشاوره ها" required>
                 <input type="hidden" name="category_id" value="{{$category_id}}">
            </div>

            <button type="submit" class="d-none">submit</button>
        </form>

        <div class="content mb-0" id="tab-group-1">
            <div class="tab-controls tabs-medium tabs-rounded mx-3" data-highlight="bg-highlight">
                <a href="#" class="font-600 bg-highlight no-click" data-active="" data-bs-toggle="collapse" data-bs-target="#tab-1" aria-expanded="true">جلسات عمومی</a>
                <a href="#" class="font-600 collapsed" data-bs-toggle="collapse" data-bs-target="#tab-2" aria-expanded="false">مشاوره اختصاصی</a>
                @foreach ($ServiceCats as $ServiceCat)
                    @if ($ServiceCat->title=="حقوقی")
                        <a href="#" class="font-600 collapsed" data-bs-toggle="collapse" data-bs-target="#tab-3" aria-expanded="false">عریضه نویسی</a>
                    @endif
                @endforeach
            </div>

            <div class="clearfix mb-3"></div>
            
            <div data-bs-parent="#tab-group-1" class="collapse show" id="tab-1" style="">
                <div>
                    @foreach ($items->where('service_type', 'جلسات عمومی') as $item)
                        <div class="card card-style bg-white">
                            {{-- <div class="card card-style m-2" data-card-height="200" style="background-image: url({{ asset('assets/images/listing/10m.jpg') }}); height: 200px;"> --}}
                            <div class="card card-style m-0" data-card-height="200" style="background-image: url({{ asset('assets/images/listing/10m.jpg') }}); height: 200px;border-radius: 20px 20px 0px 0px;">
                                <img src="{{ url('/source/asset/assets/images/categories/'.$ServiceCat->title.'.jpg') }}" alt="{{$ServiceCat->title}}">
                                <div class="card-top m-2">
                                    <a href="/service/{{$item->id.'/'.$item->slug}}">
                                        <span class="badge bg-blue-dark scale-box rounded-sm px-3 py-2 font-11 text-uppercase">{{$item->title}}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="content mt-2">
                                <div class="d-flex">
                                    <div class="align-self-center">
                                        <h3 class="font-20">{{$item->title}}</h3>
                                    </div>
                                </div>
                                <div class="d-flex mt-2">
                                    <a href="/service/{{$item->id.'/'.$item->slug}}" class="me-3 btn btn-sm rounded-sm w-100 text-uppercase font-700 text-right">
                                        {!! $item->text !!}
                                    </a>
                                </div>
                                <div class="mx-3">
                                    <div class="float-left h6 pt-1" style="font-weight: bold;">
                                        قیمت<del>{{$item->price}}</del>رایگان
                                    </div>
                                    <div class="text-right">
                                        @item(count($ServiceCat->service))
                                         قسمت
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    @endforeach
                </div>
            </div>
            <div data-bs-parent="#tab-group-1" class="collapse" id="tab-2" style="">
                <div>
                    @foreach ($items->where('service_type','مشاوره اختصاصی') as $item)
                        <div class="card card-style bg-white">
                            {{-- <div class="card card-style m-2" data-card-height="200" style="background-image: url({{ asset('assets/images/listing/10m.jpg') }}); height: 200px;"> --}}
                            <div class="card card-style m-0" data-card-height="200" style="background-image: url({{ asset('assets/images/listing/10m.jpg') }}); height: 200px;border-radius: 20px 20px 0px 0px;">
                                <img src="{{ url('/source/asset/assets/images/categories/'.$ServiceCat->title.'.jpg') }}" alt="{{$ServiceCat->title}}">
                                <div class="card-top m-2">
                                    <a href="/service/{{$item->id.'/'.$item->slug}}">
                                        <span class="badge bg-blue-dark scale-box rounded-sm px-3 py-2 font-11 text-uppercase">{{$item->title}}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="content mt-2">
                                <div class="d-flex">
                                    <div class="align-self-center">
                                        <h3 class="font-20">{{$item->title}}</h3>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <a href="/service/{{$item->id.'/'.$item->slug}}" class="btn btn-sm rounded-sm w-100 text-uppercase font-700 text-right">
                                        {!! $item->text !!}
                                    </a>
                                </div>
                                <div class="mx-3">
                                    <div class="float-left h6 pt-1" style="font-weight: bold;">
                                        {{' قیمت '.$item->price.' '}}
                                        @if ($item->sale_count > 0)
                                            <del>
                                                {{intval($item->price) - intval($item->sale_count)}}
                                            </del>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        @item(count($ServiceCat->service))
                                         قسمت
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    @endforeach
                </div>
            </div>
            <div data-bs-parent="#tab-group-1" class="collapse" id="tab-3" style="">
                <div>
                    @foreach ($items->where('service_type','عریضه نویسی') as $item)
                        <div class="card card-style bg-white">
                            {{-- <div class="card card-style m-2" data-card-height="200" style="background-image: url({{ asset('assets/images/listing/10m.jpg') }}); height: 200px;"> --}}
                            <div class="card card-style m-0" data-card-height="200" style="background-image: url({{ asset('assets/images/listing/10m.jpg') }}); height: 200px;border-radius: 20px 20px 0px 0px;">
                                <img src="{{ url('/source/asset/assets/images/categories/'.$ServiceCat->title.'.jpg') }}" alt="{{$ServiceCat->title}}">
                                <div class="card-top m-2">
                                    <a href="/service/{{$item->id.'/'.$item->slug}}">
                                        <span class="badge bg-blue-dark scale-box rounded-sm px-3 py-2 font-11 text-uppercase">{{$item->title}}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="content mt-2">
                                <div class="d-flex">
                                    <div class="align-self-center">
                                        <h3 class="font-20">{{$item->title}}</h3>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <a href="/service/{{$item->id.'/'.$item->slug}}" class="btn btn-sm rounded-sm w-100 text-uppercase font-700 text-right">
                                        {!! $item->text !!}
                                    </a>
                                </div>
                                <div class="mx-3">
                                    <div class="float-left h6 pt-1" style="font-weight: bold;">
                                        {{' قیمت '.$item->price.' '}}
                                        @if ($item->sale_count > 0)
                                            <del>
                                                {{intval($item->price) - intval($item->sale_count)}}
                                            </del>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        @item(count($ServiceCat->service))
                                         قسمت
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
