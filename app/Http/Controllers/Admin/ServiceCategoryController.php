<?php

namespace App\Http\Controllers\Admin;

use App\Model\Setting;
use App\Model\ServiceCat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ServiceCategoryController extends Controller {
    public function controller_title($type) {
        if ($type == 'sum') {
            return 'دسته بندی وبینارها و آموزش ها';
        } elseif ('single') {
            return 'دسته بندی وبینار و آموزش';
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

        $items = ServiceCat::where('type','service')->where('user_id',$this->user_id())->paginate($this->controller_paginate());
        return view('admin.service.category.index', compact('items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function create() {
        return view('admin.service.category.create', ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required|max:240',
            'slug' => 'required|max:250|unique:service_cats',
        ],
            [
                'title.required' => 'لطفا نام دسته بندی را وارد کنید',
                'title.max' => 'نام دسته بندی نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده', 
                'pic' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            ]);
        try {
            $item = new ServiceCat();
            $item->user_id = $this->user_id();
            $item->title = $request->title;
            $item->slug = $request->slug;
            if ($request->hasFile('pic')) {
                if ($item->pic != null) {
                    $old_path = $item->pic;
                    File::delete($old_path);
                }
                $item->pic = file_store($request->pic, 'source/asset/uploads/service_cat/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic_card-');;
            }
            $item->save();
            return redirect()->route('admin.service.category.list')->with('flash_message', 'دسته بندی خدمت با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد دسته بندی خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function edit($id) {
        $item = ServiceCat::where('user_id',$this->user_id())->findOrFail($id);
        return view('admin.service.category.edit', compact('item'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function update(Request $request, $id) {
        $this->validate($request, [
            'title' => 'required|max:240',
            'slug' => 'required|max:250|unique:service_cats,slug,'.$id,
            'pic' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
        ],
            [
                'title.required' => 'لطفا نام دسته بندی را وارد کنید',
                'title.max' => 'نام دسته بندی نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
            ]);
        $item = ServiceCat::where('user_id',$this->user_id())->findOrFail($id);
        try {
            $item->title = $request->title;
            if ($request->hasFile('pic')) {
                if ($item->pic != null) {
                    $old_path = $item->pic;
                    File::delete($old_path);
                }
                $item->pic = file_store($request->pic, 'source/asset/uploads/service_cat/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic_card-');;
            }
            $item->slug = $request->slug;
            $item->update();
            return redirect()->route('admin.service.category.list')->with('flash_message', 'دسته بندی خدمت با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش دسته بندی خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function destroy($id) {
        $item = ServiceCat::where('user_id',$this->user_id())->findOrFail($id);
        try {
            if(count($item->service)>0) {
                return redirect()->back()->withInput()->with('err_message', 'دسته دارای خدمات می باشد و نمیتوان حذف کرد');
            }
            $item->delete();
            return redirect()->back()->with('flash_message', 'دسته بندی خدمت با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف دسته بندی خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function active($id, $type) {
        $item = ServiceCat::where('user_id',$this->user_id())->findOrFail($id);
        try {
            $item->status = $type;
            $item->update();
            if ($type == 'pending') {
                return redirect()->back()->with('flash_message', 'نمایش دسته بندی خدمت با موفقیت غیرفعال شد.');
            }
            if ($type == 'active') {
                return redirect()->back()->with('flash_message', 'نمایش دسته بندی خدمت با موفقیت فعال شد.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در تغییر وضعیت دسته بندی خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }
}


