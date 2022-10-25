@extends('user.master')
@section('content')
    <section class="mt-5 p-2">
        <div class="card res_table" style="background: transparent;">
            <div class="card-header">
                <h3 class="card-title float-right mt-2">{{$title2}}</h3>
                <a href="{{url()->previous()}}" class="float-left text-secondary h3 pt-2"><i class="fa fa-arrow-left"></i></a>
            </div>
            <div class="redu30 bg-white card-body res_table_in m-3 px-3">
                <h6 class="py-2">{{$item->subject}}</h6>
                {{$item->description}}
                @if ($item->atach)
                    <a href="{{url('/').'/'.$item->atach}}"  class="btn btn-info col-12 mt-3" target="_blank">نمایش فایل پیوست شده</a>
                @endif
            </div>
        </div>
    </section>



@endsection
