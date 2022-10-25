<?php

namespace App\Http\Controllers\Admin;

use App\Model\Setting;
use App\Model\Slider;
use App\Model\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class SliderController extends Controller {
    public function controller_title($type) {
        if ($type == 'sum') {
            return ' لیست اسلایدر';
        } elseif ('single') {
            return ' اسلایدر';
        }
    }
    public function controller_paginate() {
        return Setting::select('paginate')->where('user_id', $this->user_id())->first()->paginate;
    }
    public function __construct() {
        $this->middleware('auth');
    }
    function user_id() {
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            return auth()->user()->id;
        } else {
            return auth()->user()->reagent_id;
        }
    }
    public function index() {
        $items = Slider::where('user_id', $this->user_id())->orderBy('sort','asc')->paginate($this->controller_paginate());
        return view('admin.content.slider.index', compact('items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function create() {
        return view('admin.content.slider.create', ['title1' => $this->controller_title('single'), 'title2' => 'افزودن '.$this->controller_title('single')]);
    }
    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required|max:240',
            'photo' => 'required|image|mimes:jpeg,jpg|max:5120',
        ],
            [
                'title.required' => 'لطفا عنوان اسلایدر را وارد کنید',
                'title.max' => 'عنوان اسلایدر  نباید بیشتر از 240 کاراکتر باشد',
                'photo.required' => 'لطفا یک تصویر انتخاب کنید',
                'photo.image' => 'لطفا یک تصویر انتخاب کنید',
                'photo.mimes' => 'لطفا یک تصویر با پسوندهای (jpg,jpeg) انتخاب کنید',
                'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
            ]);
        try {
            $item = new Slider();
            $item->title = $request->title;
            $item->user_id = $this->user_id();
            $item->link = $request->link;
            $item->save();
            if ($request->hasFile('photo')) {
                $photo = new Photo();
                $path_pic='source/asset/uploads/slider/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/';
                $photo->path = file_store($request->photo,$path_pic , 'photo-');
                $item->photo()->save($photo);
                img_resize(
                    $photo->path, //address img
                    $photo->path, //address save
                    1300,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );
                $mobile= $path_pic.'mobile-pic'.time().'-'.rand(10001,99999).'.'.$request->photo->getClientOriginalExtension();
                img_resize(
                    $photo->path, //address img
                    $mobile,//address save
                    600,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );
                $photo = new Photo();
                $photo->path = $mobile;
                $photo->device_type = 'mobile';
                $item->photo()->save($photo);
            }
            return redirect()->route('admin.slider.list')->with('flash_message', ' اسلایدر با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد اسلایدر بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function edit($id) {
        $item = Slider::where('user_id', $this->user_id())->findOrFail($id);
        return view('admin.content.slider.edit', compact('item'), ['title1' => 'محتوا سایت', 'title2' => 'ویرایش اسلایدر']);
    }
    public function update(Request $request, $id) {
        $this->validate($request, [
            'title' => 'required|max:240',
            'photo' => 'nullable|image|mimes:jpeg,jpg|max:5120',
        ],
            [
                'title.required' => 'لطفا اسلایدر خدمت را وارد کنید',
                'title.max' => 'عنوان اسلایدر  نباید بیشتر از 240 کاراکتر باشد',
                'photo.image' => 'لطفا یک تصویر انتخاب کنید',
                'photo.mimes' => 'لطفا یک تصویر با پسوندهای (jpg,jpeg) انتخاب کنید',
                'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
            ]);
        $item = Slider::where('user_id', $this->user_id())->findOrFail($id);
        try {
            $item->title = $request->title;
            $item->link = $request->link;
            $item->update();
            if ($request->hasFile('photo')) {
                if ($item->photo)
                {
                    $old_path = $item->photo->path;
                    File::delete($old_path);
                    $item->photo->delete();
                }
                if ($item->photo_mobile)
                {
                    $old_path = $item->photo_mobile->path;
                    File::delete($old_path);
                    $item->photo_mobile->delete();
                }
                $photo = new Photo();
                $photo->path = file_store($request->photo, 'source/asset/uploads/slider/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;

                $item->photo()->save($photo);
                img_resize(
                    $photo->path, //address img
                    $photo->path, //address save
                    1300,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );
                   $mobile= 'source/asset/uploads/slider/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/mobile/mobile-pic'.time().'-'.rand(10001,99999).'.'.$request->photo->getClientOriginalExtension();
                img_resize(
                    $photo->path, //address img
                    $mobile, //address save
                    600,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );
                $photo = new Photo();
                $photo->path = $mobile;
                $photo->device_type = 'mobile';
                $item->photo()->save($photo);
            }
            return redirect()->route('admin.slider.list')->with('flash_message', 'اسلایدر با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش اسلایدر بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function destroy($id) {
        $item = Slider::where('user_id', $this->user_id())->findOrFail($id);
        try {
            $item->delete();
            return redirect()->back()->with('flash_message', 'اسلایدر با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف اسلایدر بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function sort($id,Request $request) {
        $item = Slider::where('user_id', $this->user_id())->findOrFail($id);
        try {
            if($request->sort<0)
            {
                return redirect()->back()->withInput()->with('err_message', 'عدد منفی وارد نکنید');
            }
            $item->sort=$request->sort;
            $item->update();
            return redirect()->back()->with('flash_message', 'بروزرسانی ترتیب نمایش اسلایدر با موفقیت انجام شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ترتیب نمایش اسلایدر بوجود آمده،مجددا تلاش کنید');
        }
    }
}


