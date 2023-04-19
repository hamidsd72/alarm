<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\ServicePackage;
use App\Model\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ServicePackageVideoController extends Controller
{

    public function controller_paginate()
    {
        $settings = Setting::select('paginate')->latest()->firstOrFail();
        return $settings->paginate;
    }

    public function __construct()
    {
        $this->middleware(['auth', 'SpecialUser']);
    }

    public function index($p_id)
    {
        $package = ServicePackage::find($p_id);
        $items = Video::where('videos_type','App\Model\ServicePackage')->where('videos_id',$p_id)->orderBy('sort','asc')->get();
        $title=$package?$package->title:'';
        return view('admin.service.package.video.index', compact('items','package'), ['title1' => 'خدمات', 'title2' => 'لیست ویدئو : '.$title]);
    }

    public function store(Request $request,$p_id)
    {
        $this->validate($request, [
            'title' => 'required|max:245',
            'video' => 'required|mimes:mp4|max:51200',
        ],
            [
                'title.required' => 'لطفا عنوان ویدئو را وارد کنید',
                'title.max' => 'لطفا عنوان ویدئو بیشتر از 240 کاراکتر نباشد',
                'video.required' => 'لطفا ویدئو را وارد کنید',
                'video.mimes' => 'لطفا یک ویدئو با پسوند (mp4) انتخاب کنید',
                'video.max' => 'لطفا حجم ویدئو حداکثر 50 مگابایت باشد',
            ]);
        try {
            if ($request->hasFile('video')) {
                $path = file_store($request->video, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/videos/', 'video-learn-');;
            }
            $item = new Video();
            $item->videos_type = 'App\Model\ServicePackage';
            $item->videos_id = $p_id;
            $item->path = $path;
            $item->type = $request->type;
            $item->title = $request->title;
            $item->save();

            return redirect()->back()->with('flash_message', '  با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد ویدئو پکیج بوجود آمده،مجددا تلاش کنید');
        }
    }


    public function destroy($id)
    {
        $item = Video::find($id);
        try {
            File::delete($item->path);
            $item->delete();
            return redirect()->back()->with('flash_message', ' با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف ویدئو پکیج بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function active($id,$type)
    {
        $item = Video::find($id);
        try {
            $item->status = $type;
            $item->update();
            if ($type == 'pending') {
                return redirect()->back()->with('flash_message', 'نمایش ویدئو با موفقیت غیرفعال شد.');
            }
            if ($type == 'active') {
                return redirect()->back()->with('flash_message', 'نمایش ویدئو با موفقیت فعال شد.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در تغییر وضعیت ویدئو پکیج بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function sort(Request $request,$id)
    {
        $item = Video::find($id);
        try {
            $item->sort=$request->sort;
            $item->update();
            return redirect()->back()->with('flash_message', ' با موفقیت انجام شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در سورت ویدئو پکیج بوجود آمده،مجددا تلاش کنید');
        }
    }
}


