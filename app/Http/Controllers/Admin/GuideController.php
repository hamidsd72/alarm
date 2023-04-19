<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\About;
use App\Model\AboutJoin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class GuideController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return 'راهنمای کاربر';
        } elseif ('single') {
            return 'راهنمای کاربر';
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
    public function edit()
    {
        $item = About::find(1);
        $items = AboutJoin::where('type','guide')->get();
        return view('admin.content.guide.edit', compact('item','items'), ['title1' => 'محتوا سایت', 'title2' => 'ویرایش راهنمای کاربر']);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'video_link' => 'required',
         /*   'text_guide' => 'required',
            'pic_guide' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',*/
        ],
            [
                'title_guide.required' => 'لطفا عنوان درباره ما را وارد کنید',
                'title_guide.max' => 'عنوان درباره ما نباید بیشتر از 240 کاراکتر باشد',
                'text_guide.required' => 'لطفا متن درباره ما را وارد کنید',
                'pic_guide.image' => 'لطفا یک تصویر انتخاب کنید',
                'pic_guide.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'pic_guide.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
            ]);
        $item = About::find($id);
        try {
            $item->title_guide = $request->title_guide;
            $item->text_guide = $request->text_guide;
            $item->video_link = $request->video_link;

            if ($request->hasFile('pic_guide')) {
                if (is_file($item->pic_guide))
                {
                    $old_path = $item->pic_guide;
                    File::delete($old_path);
                }
                $item->pic_guide = file_store($request->pic_guide, 'source/asset/uploads/guide/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic-');;
            }
            $item->update();
            if ($request->hasFile('pic_guide')) {
                img_resize(
                    $item->pic_guide,//address img
                    $item->pic_guide,//address save
                    700,// width: if width==0 -> width=auto
                    0// height: if height==0 -> height=auto
                // end optimaiz
                );
            }
           /* if(isset($request->title_join)) {
                $items = AboutJoin::where('type', 'guide')->get();
                foreach ($items as $itemss) {
                    $itemss->delete();
                }
                foreach ($request->title_join as $key => $val) {
                    $pic = null;
                    if (isset($request->pic_join[$key])) {
                        $pic = $request->pic_join[$key];
                    }
                    $about_join = new AboutJoin();
                    $about_join->title = $val;
                    $about_join->type = 'guide';
                    $about_join->text = $request->text_join[$key];
                    if (is_file($pic)) {
                        if (isset($request->pic_join1[$key]) and is_file($request->pic_join1[$key])) {
                            File::delete($request->pic_join1[$key]);
                        }
                        $about_join->pic = file_store($pic, 'source/asset/uploads/guide/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic_' . $key . '-');;
                    } elseif ($request->pic_join1[$key] != null) {
                        $about_join->pic = $request->pic_join1[$key];
                    }
                    $about_join->save();
                    img_resize(
                        $about_join->pic,//address img
                        $about_join->pic,//address save
                        700,// width: if width==0 -> width=auto
                        0// height: if height==0 -> height=auto
                    // end optimaiz
                    );
                }
            }*/
            return redirect()->back()->with('flash_message', 'راهنمای کاربر با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش راهنمای کاربر بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function destroy($id)
    {
        $item = AboutJoin::find($id);
        try {
            if(is_file($item->pic))
            {
                File::delete($item->pic);
            }
            $item->delete();
            return redirect()->back()->with('flash_message', ' با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف بوجود آمده،مجددا تلاش کنید');
        }
    }
}


