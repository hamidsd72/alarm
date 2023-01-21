@extends('user.master')
@section('content')
    <section class="mt-5">
        <div class="card res_table mt-3" style="background: transparent;">
            <div class="card-header">
                <h3 class="card-title float-right">{{$title2}}</h3>
            </div>
            @foreach($items as $item)
                <div class="redu30 bg-white card-body res_table_in m-3 p-2">
                    @if($item->status=="pending")
                        <img class="mx-1" src="https://img.icons8.com/ultraviolet/18/000000/invisible.png"/>
                    @else
                    <img class="mx-1" src="https://img.icons8.com/ultraviolet/18/000000/visible.png"/>
                    @endif
                    <div class="float-end mt-1">
                        <a href="{{route('user.notification.show',$item->id)}}" class="btn btn-primary">نمایش پیام</a>
                    </div>
                    {{$item->subject}}
                    <p class="my-0 mx-2">{{my_jdate($item->created_at,'d F Y')}}</p>
                </div>
            @endforeach
        </div>
        <div class="pag_ul">
            {{ $items->links() }}
        </div>
    </section>
@endsection
