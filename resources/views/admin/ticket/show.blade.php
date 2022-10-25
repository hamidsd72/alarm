@extends('layouts.admin')
@section('css')

@endsection
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            {{--                                                <h4 class="mb-4 font-weight-bold">Basic</h4>--}}
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-md-12 mb-2 comment_head_show">
                                        <div class="container-fluid mb-0">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <p>
                                                        <strong>عنوان : </strong>
                                                        <span>{{$item->title?$item->title:'ثبت نشده'}}   @if($item->priority=='low')
                                                                <span class="badge badge-success">کم</span>
                                                            @elseif($item->priority=='medium')
                                                                <span class="badge badge-warning">متوسط</span>
                                                            @elseif($item->priority=='much')
                                                                <span class="badge badge-danger">زیاد</span>
                                                            @endif  </span>
                                                    </p>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p>
                                                        <strong>زمان ایجاد : </strong>
                                                        <span>{{my_jdate($item->created_at,'Y/m/d H:i')}}  </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <p>
                                                        <strong>وضعیت : </strong>
                                                        @if($item->status=='3_closed')
                                                            <span class="badge badge-danger">بسته شد</span>
                                                        @elseif($item->status=='2_done')
                                                            <span class="badge badge-info">انجام شد</span>
                                                        @elseif($item->status=='1_active')
                                                            <span class="badge badge-success">فعال</span>
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="col-sm-6">
                                                    <p>
                                                        <strong>زمان آخرین بروزرسانی : </strong>
                                                        <span>{{my_jdate($item->updated_at,'Y/m/d H:i')}}  </span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($item->status!='3_closed')
                                        @if(Auth::user()->hasRole('مدیر') || Auth::user()->id==$item->create_user_id)
                                            <a href="{{route('admin.ticket.close.ticket',$item->id)}}" onclick="return confirm('برای بستن تیکت مطمئن هستید؟')" class="btn btn-danger mb-2">بستن تیکت</a>
                                        @endif
                                    @else
                                        <div class="col-12 alert alert-danger text-center">بسته شد</div>
                                    @endif

                                    @if(Auth::user()->hasRole('مدیر') || Auth::user()->id==$item->create_user_id)
                                        @if(in_array($item->status,['1_active','2_done']))
                                            <div class="container-fluid my-3">
                                                {{ Form::open(array('route' => array('admin.ticket.show.store',$item->id), 'method' => 'POST','files'=>true,'class'=>'row')) }}
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        {{Form::label('description', ' پاسخ شما *')}}
                                                        {{Form::textarea('description', null, array('class' => 'form-control','required'))}}
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" id="gallery" name="attachs[]" multiple>
                                                                <label class="custom-file-label" dir="ltr" for="exampleInputFile">انتخاب فایل</label>
                                                            </div>
                                                        </div>
                                                        <p class="text-danger">_<small>حداکثر سایز 10Mb می
                                                                باشد</small></p>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 text-left">
                                                    {{Form::submit('ثبت پاسخ',array('class'=>'btn btn-primary','onclick'=>"return confirm('برای پاسخ مطمئن هستید؟')"))}}
                                                    <hr/>
                                                </div>
                                                {{ Form::close() }}
                                            </div>
                                        @endif
                                    @endif
                                    @foreach($item->children as $child)
                                        <div class="col-md-12 comment_text_show">
                                            <header class="{{$child->create_user_id==$item->create_user_id?'head_to':'head_you'}}">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <i class="fa fa-user"></i>
                                                            {{$child->user_create?$child->user_create->first_name.' '.$child->user_create->last_name:''}}
                                                            {{$child->user_create && $child->user_create->hasRole('مدیر') ? '(پشتیبانی)' : '' }}
                                                        </div>
                                                        <div class="col-sm-6 text-left">
                                                            <i class="fa fa-clock-o"></i>
                                                            {{my_jdate($child->created_at,'Y/m/d H:i')}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </header>
                                            <div class="body_comment_show">
                                                <p class="dis_show">
                                                    {{$child->description}}
                                                </p>
                                                @if(count($child->files))
                                                    <div class="col-md-12 mt-5">
                                                        <div class="container-fluid">
                                                            <div class="row">
                                                                @foreach($child->files as $file)
                                                                <div class="col-md-3 col-sm-6">
                                                                    <div class="doc_box_documents">
                                                                        <a href="{{url($file->path)}}"
                                                                           target="_blank">مشاهده پیوست </a>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-md-12 comment_text_show">
                                        <header class="head_to">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <i class="fa fa-user"></i>
                                                        {{$item->user_create?$item->user_create->first_name.' '.$item->user_create->last_name:''}}
                                                    </div>
                                                    <div class="col-sm-6 text-left">
                                                        <i class="fa fa-clock-o"></i>
                                                        {{my_jdate($item->created_at,'Y/m/d H:i')}}
                                                    </div>
                                                </div>
                                            </div>
                                        </header>
                                        <div class="body_comment_show">
                                            <p class="dis_show">
                                                {{$item->description}}
                                            </p>
                                            @if(count($item->files))
                                                <div class="col-md-12 mt-5">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            @foreach($item->files as $file)
                                                            <div class="col-md-3 col-sm-6">
                                                                <div class="doc_box_documents">
                                                                    <a href="{{url($file->path)}}"
                                                                       target="_blank">مشاهده پیوست  </a>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div><!-- /.card -->
                </div>
            </div>
        </div>
    </section>

@endsection

