<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\ServiceCat;
use App\Model\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class LearnPackageCategoryController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return 'دسته بندی خدمات آموزشگاهی';
        } elseif ('single') {
            return 'دسته بندی خدمت آموزشگاهی';
        }
    }

    public function controller_paginate()
    {
        $settings = Setting::select('paginate')->latest()->firstOrFail();
        return $settings->paginate;
    }

    public function __construct()
    {
        $this->middleware(['auth', 'SpecialUser']);
    }

    public function index()
    {
        $items = ServiceCat::where('type','package')->paginate($this->controller_paginate());
        return view('admin.service.package.learn.cat.index', compact('items'), ['title1' => 'خدمات', 'title2' => $this->controller_title('sum')]);
    }

    public function create()
    {
        return view('admin.service.package.learn.cat.create', ['title1' => 'خدمات', 'title2' => 'افزودن دسته بندی خدمت']);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:240',
            'slug' => 'required|max:250|unique:service_cats',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:5120',
        ],
            [
                'title.required' => 'لطفا نام دسته بندی را وارد کنید',
                'title.max' => 'نام دسته بندی نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
                'photo.required' => 'لطفا یک تصویر انتخاب کنید',
                'photo.image' => 'لطفا یک تصویر انتخاب کنید',
                'photo.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
            ]);
        try {
            $item = new ServiceCat();
            $item->title = $request->title;
            $item->slug = $request->slug;
            $item->type = 'package';
            $item->save();
            if ($request->hasFile('photo')) {
                $photo = new Photo();
                $photo->path = file_store($request->photo, 'source/asset/uploads/package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                $item->photo()->save($photo);
            }

            return redirect()->route('admin.learn.package.category.list')->with('flash_message', 'دسته بندی خدمت با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد دسته بندی خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function edit($id)
    {
        $item = ServiceCat::find($id);
        return view('admin.service.package.learn.cat.edit', compact('item'), ['title1' => 'خدمات', 'title2' => 'ویرایش دسته بندی خدمت']);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:240',
            'slug' => 'required|max:250|unique:service_cats,slug,'.$id,
        ],
            [
                'title.required' => 'لطفا نام دسته بندی را وارد کنید',
                'title.max' => 'نام دسته بندی نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
            ]);
        $item = ServiceCat::find($id);
        try {
            $item->title = $request->title;
            $item->slug = $request->slug;
            $item->update();
            if ($request->hasFile('photo')) {
                if ($item->photo)
                {
                    $old_path = $item->photo->path;
                    File::delete($old_path);
                    $item->photo->delete();
                }
                $photo = new Photo();
                $photo->path = file_store($request->photo, 'source/asset/uploads/package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                $item->photo()->save($photo);
                img_resize(
                    $photo->path, //address img
                    $photo->path, //address save
                    500,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );
            }

            return redirect()->route('admin.learn.package.category.list')->with('flash_message', 'دسته بندی خدمت با موفقیت ویرایش شد.');
        } catch (\Exception $e) {

            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش دسته بندی خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function destroy($id)
    {
        $item = ServiceCat::find($id);
        try {
            if(count($item->packages)>0)
            {
                return redirect()->back()->withInput()->with('err_message', 'دسته دارای خدمات می باشد و نمیتوان حذف کرد');
            }
            $item->delete();
            return redirect()->back()->with('flash_message', 'دسته بندی خدمت با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف دسته بندی خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }
}


