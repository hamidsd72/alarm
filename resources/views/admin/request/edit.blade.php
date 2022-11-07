@extends('layouts.admin')
@section('css')
<style>
    .select2-container--default .select2-selection--single, .select2-selection .select2-selection--single {
        height: 46px;
    }
</style>

@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            {{ Form::model($item,array('route' => array('admin.user_request.update', $item->id), 'method' => 'PATCH', 'files' => true)) }}
                            <div class="row">
                                <div class="col-lg">
                                    <div class="form-group">
                                        {{ Form::label('user_id', '* کاربر') }}
                                        <select class="form-control select2" name="user_id" >
                                            @foreach($items as $user)
                                                <option value="{{$user->id}}" {{$user->id==$item->id?'selected':''}}>({{$user->first_name.' '.$user->last_name}})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="form-group">
                                        {{ Form::label('title', '* عنوان') }}
                                        {{ Form::text('title',null, array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="col-lg">
                                    <div class="form-group">
                                        {{ Form::label('date', '* تاریخ درخواست '.my_jdate($item->date,'d F Y')) }}
                                        {{-- {{ Form::text('date',null, array('class' => 'form-control date_p')) }} --}}
                                        <input type="text" name="date" id="date" class="form-control date_p">
                                        <img class="inline-left-logo" src="https://img.icons8.com/external-icematte-lafs/40/000000/external-Calendar-it-icematte-lafs.png">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {{ Form::label('description', '* توضیحات') }}
                                        {{ Form::textarea('description',null, array('class' => 'form-control textarea')) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col">
                                    {{ Form::button('ویرایش', array('type' => 'submit', 'class' => 'btn btn-success col-12')) }}
                                </div>
                                <div class="col">
                                    <a href="{{ URL::previous() }}" class="btn btn-secondary col-12">بازگشت</a>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('js')
<script>
    $('.date_p').persianDatepicker({
        observer: true,
        format: 'YYYY/MM/DD',
        altField: '.observer-example-alt',
        initialValue:false,
    });
        $(document).ready(function () {
            $('select[name=state_id]').on('change', function () {
                $.get("{{url('/')}}/city-ajax/" + $(this).val(), function (data, status) {
                    $('select[name=city_id]').empty();
                    $.each(data, function (key, value) {
                        $('select[name=city_id]').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    $('select[name=city_id]').trigger('change');
                });
            });
        });
</script>
@endsection
