@extends('layouts.admin')
@section('css')

@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card res_table">
                        <div class="card-header bg-zard">
                            <h3>{{$title2}}</h3>
                        </div>
                        <div class="card-body res_table_in">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>کارمند</th>
                                    <th>{{$title2}}</th>
                                    <th>عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($items)>0)
                                    @foreach($items as $item)
                                        <tr >
                                            <td>{{$item->first_name.' '.$item->last_name}}</td>
                                            <td>{{$item->setJob()->count().' فعالیت دارد '}}</td>
                                            <td class="text-center">
                                                <a href="{{route('admin.job-report.show',$item->id)}}" class="badge bg-primary">بررسی </a>
                                            </td> 
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">موردی یافت نشد</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    <div class="pag_ul">
                        {{ $items->links() }}
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