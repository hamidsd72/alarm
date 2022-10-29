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
                    {{$item->subject}}
                    <div class="text-end">
                        <a href="{{route('user.notification.show',$item->id)}}" class="btn btn-primary mt-2 py-0">نمایش پیام</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="pag_ul">
            {{ $items->links() }}
        </div>
    </section>
@endsection
