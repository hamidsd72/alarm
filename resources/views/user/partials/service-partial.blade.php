<style>
    .product-card-small .product-image-small {
        height: 180px !important;
        width: 100% !important;
    }
</style>
<div style="color: #ececec;">ldfksld</div>
<div class="card product-card-small mb-0">
    <div class="card-body">
        <div class="">
            <div class="product-image-small">
                <div class="background" style="background-image: url('{{ url($item->photo->path?$item->photo->path:'/source/asset/assets/images/categories/'.$ServiceCat->title.'.jpg') }}');">
                    <img src="{{ url($item->photo->path?$item->photo->path:'/source/asset/assets/images/categories/'.$ServiceCat->title.'.jpg') }}" alt="{{$ServiceCat->title}}" style="display: none;">
                </div>
                {{-- <div class="tag-images-count text-white bg-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-size-16 vm" viewBox="0 0 512 512">
                        <title>ionicons-v5-e</title>
                        <path d="M432,112V96a48.14,48.14,0,0,0-48-48H64A48.14,48.14,0,0,0,16,96V352a48.14,48.14,0,0,0,48,48H80" style="fill:none;stroke:#000;stroke-linejoin:round;stroke-width:32px"></path>
                        <rect x="96" y="128" width="400" height="336" rx="45.99" ry="45.99" style="fill:none;stroke:#000;stroke-linejoin:round;stroke-width:32px"></rect>
                        <ellipse cx="372.92" cy="219.64" rx="30.77" ry="30.55" style="fill:none;stroke:#000;stroke-miterlimit:10;stroke-width:32px"></ellipse>
                        <path d="M342.15,372.17,255,285.78a30.93,30.93,0,0,0-42.18-1.21L96,387.64" style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></path>
                        <path d="M265.23,464,383.82,346.27a31,31,0,0,1,41.46-1.87L496,402.91" style="fill:none;stroke:#000;stroke-linecap:round;stroke-linejoin:round;stroke-width:32px"></path>
                    </svg>
                    <span class="vm">10</span>
                </div> --}}

            </div>
        </div>
        <div class="row my-3">
            <div class="col">
                {{-- <p class="small"><a href="property-details.html" class="text-dark">{{$ServiceCat->title}}</a> </p> --}}
                <p class="small text-dark">{{$item->title}}</p>
            </div>
            <div class="col-auto">
                <p class="small vm">
                    <span class=" text-secondary">4.5</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-size-12 vm" viewBox="0 0 24 24">
                        <path d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M0 0h24v24H0z" fill="none"></path>
                        <path fill="#FFD500" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                    </svg>
                </p>
            </div>
        </div>
        {{-- <div class="row no-gutters mb-3">
            <div class="col">
                <p class="small vm">
                    <span class=" text-secondary">{{$item->title}}</span>
                        @switch($item->service_type)
                            @case('عریضه نویسی')
                                {{' قیمت '.number_format( $form_price->where("form_name" , "عریضه نویسی")->first()->amount )}}
                                @break
                            @case('عقد قرارداد')
                                توافقی
                                @break
                            @case('مشاوره خصوصی')
                                    @if ($ServiceCat->title=="ویزا")
                                        {{' قیمت '.number_format( $form_price->where("form_name" , "مشاوره خصوصی ویزا")->first()->amount )}}
                                    @elseif($ServiceCat->title=="حقوقی")
                                        {{' قیمت '.number_format( $form_price->where("form_name" , "مشاوره خصوصی حقوقی")->first()->amount )}}
                                    @endif
                                @break
                            @default
                                وبینار رایگان
                        @endswitch
                    </span>
                </p>
            </div>
            <div class="col-auto">
                <p class="small text-secondary"><small>{{$item->service_type}}</small></p>
            </div>
        </div> --}}
        <hr class="border-top border-color my-2">
        <div class="text-secondary">{!! $item->text !!}</div>
    </div>
</div>