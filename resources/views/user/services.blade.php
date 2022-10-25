@extends('user.master')
@section('content')
<style>
    .modal-dialog-scrollable .modal-content { border-radius: 30px; }
    div.collapse a.text-white {
        /* background: #80D4FF; */
        border-radius: 50px !important;
        padding: 6px 0px;
        font-size: 14px;
        font-weight: bold;
        float: left;
        text-align: center;
        width: 100%;
    }
    .bg-highlight {
        background-color: #80D4FF !important;
        background-color: #fe5722 !important;
    }
    .tab-controls a {
        font-size: 9px;
    }
    .tabs-rounded a:first-child {
        border-bottom-right-radius: 15px;
    }
    .tabs-rounded a:last-child {
        border-bottom-left-radius: 16px;
        border-top-left-radius: 15px;
    }
    .modal-dialog-scrollable .modal-content {
        margin-top: 14%;
    }
</style>
    {{-- قرارداد عمومی --}}
    {{-- <div class="modal" id="modal-1">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    @include('user.partials.qarardad-gen')
                </div>
            </div>
        </div>
    </div> --}}
    {{-- قرارداد خصوصی --}}
    {{-- <div class="modal" id="modal-2">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    @include('user.partials.qarardad-pro')
                </div>
            </div>
        </div>
    </div> --}}
    {{-- فرم مشاوره خصوصی حقوقی --}}
    {{-- <div class="modal" id="modal-3">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    @include('user.partials.form-hoghoghi-khososi')
                </div>
            </div>
        </div>
    </div> --}}
    {{-- فرم عریضه نویسی --}}
    {{-- <div class="modal" id="modal-4">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    @include('user.partials.form-arize')
                </div>
            </div>
        </div>
    </div> --}}
    {{-- عقد قرارداد --}}
    {{-- <div class="modal" id="modal-6">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    @include('user.partials.qarardad-full')
                </div>
            </div>
        </div>
    </div> --}}
    {{-- ثبت فرم استعدادیابی --}}
    {{-- <div class="modal" id="modal-7">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body">
                    @include('user.partials.form-estedad')
                </div>
            </div>
        </div>
    </div> --}}

    <div class="mx-auto" style="max-width: 1000px;">

        {{-- searchbar --}}
        <div class="container mt-5">
            <div class="form-group mb-0">
                <form action="{{route('user.user-search.store')}}" method="post">
                    @csrf
                    <div class="row mb-0">
                        <input type="hidden" name="type" value="service">
                        <input type="hidden" name="category_id" value="{{$ServiceCat->id}}">
                        <input type="text" class="form-control search" name="search" placeholder="جستجو در وبینار و آموزش ها">
                    </div>
                </form>
            </div>
        </div>
        {{-- end searchbar --}}
        
        <div class="card card-style" style="background: none;box-shadow: none;">
            <div id="tab-group-1">
    
                {{-- <div class="tab-controls tabs-medium tabs-rounded mx-lg-3" data-highlight="bg-highlight">
                    @if ($ServiceCat->title=="استعدادیابی")
                        <a href="#" data-toggle="modal" data-target="#modal-7" class="font-600 bg-highlight">ثبت استعداد</a>
                    @else
                        <a href="#" class="font-600 bg-highlight no-click" data-active="" data-bs-toggle="collapse" data-bs-target="#tab-1" aria-expanded="true">وبینار رایگان</a>
                        <a href="#" class="font-600 collapsed" data-bs-toggle="collapse" data-bs-target="#tab-2" aria-expanded="false">مشاوره خصوصی</a>
                        @if ($ServiceCat->title=="حقوقی")
                            <a href="#" class="font-600 collapsed" data-bs-toggle="collapse" data-bs-target="#tab-3" aria-expanded="false">عریضه</a>
                        @endif
                        <a href="#" class="font-600 collapsed" data-bs-toggle="collapse" data-bs-target="#tab-5" aria-expanded="false">عقد قرارداد</a>
                    @endif
                </div>  --}}

                {{-- <div class="clearfix mb-0"></div> --}}
                @foreach ($items as $item)
                    @include('user.partials.service-partial')
                @endforeach 
                <div class="mt-4">
                    {{ $items->links() }}
                </div>
                {{-- @if ($ServiceCat->title=="استعدادیابی")
                    @foreach ($items as $item)
                        @include('user.partials.service-partial')
                    @endforeach 
                @endif --}}
                {{-- وبینار رایگان --}}
                {{-- <div data-bs-parent="#tab-group-1" class="collapse @unless ($ServiceCat->title=="استعدادیابی") show @endunless" id="tab-1">
                    <a href="#" data-toggle="modal" data-target="#modal-1" class="text-white btn-info">
                        {{' ثبت نام در وبینار رایگان '}}
                    </a>
                    @foreach ($items->where('service_type', 'وبینارها') as $item)
                        @include('user.partials.service-partial')
                    @endforeach 
                </div> --}}
                {{-- مشاوره خصوصی --}}
                {{-- <div data-bs-parent="#tab-group-1" class="collapse" id="tab-2">
                    @if ($ServiceCat->title=="ویزا")
                        <a href="#" data-toggle="modal" data-target="#modal-2" class="text-white btn-info">
                            {{' درخواست مشاوره خصوصی '}}
                        </a>
                    @elseif ($ServiceCat->title=="حقوقی")
                        <a href="#" data-toggle="modal" data-target="#modal-3" class="text-white btn-info">
                            {{' درخواست مشاوره خصوصی '}}
                        </a>
                    @endif
                    @foreach ($items->where('service_type','مشاوره خصوصی') as $item)
                        @include('user.partials.service-partial')
                    @endforeach
                </div> --}}
                {{-- عریضه --}}
                {{-- <div data-bs-parent="#tab-group-1" class="collapse" id="tab-3">
                    <a href="#" data-toggle="modal" data-target="#modal-4" class="text-white btn-info">
                        {{' درخواست عریضه '}}
                    </a>
                    @foreach ($items->where('service_type','عریضه نویسی') as $item)
                        @include('user.partials.service-partial')
                    @endforeach
                </div> --}}
                {{-- عقد قرارداد --}}
                {{-- <div data-bs-parent="#tab-group-1" class="collapse" id="tab-5">
                    <a href="#" data-toggle="modal" data-target="#modal-6" class="text-white btn-info">
                        درخواست عقد قرارداد
                    </a>
                    @foreach ($items->where('service_type','عقد قرارداد') as $item)
                        @include('user.partials.service-partial')
                    @endforeach
                </div> --}}
            </div>
        </div>

    </div>

@endsection
