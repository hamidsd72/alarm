<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\About;
use App\Model\AboutJoin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class AboutController extends Controller {
    public function controller_title($type) {
        if ($type == 'sum') {
            return 'درباره ما';
        } elseif ('single') {
            return 'درباره ما';
        }
    }
    public function controller_paginate() {
        return Setting::select('paginate')->where('user_id', $this->user_id())->first()->paginate;
    }
    public function __construct() {
        $this->middleware(['auth','Access','SpecialUser']);
    }
    function user_id() {
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            return auth()->user()->id;
        } else {
            return auth()->user()->reagent_id;
        }
    }
    public function index() {
        $item = About::where('user_id', $this->user_id())->first();
        $items = AboutJoin::where('type','about')->get();
        return view('admin.content.about.edit', compact('item','items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function edit($id) {
        if ( auth()->user()->hasRole('مدیر ارشد') ) { 
            $item = About::findOrFail($id);
            $items = AboutJoin::where('type','about')->get();
            return view('admin.content.about.edit', compact('item','items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
        }
        return false;
    }
    public function show($id) {
        if ( ! auth()->user()->hasRole('مدیر ارشد') ) { return false; }
        $item  = User::findOrFail($id);
        $items = AboutJoin::where('type','about')->get();
        return view('admin.content.about.create', compact('item','items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function store(Request $request) {
        $this->validate($request, [
            // 'title' => 'required|max:240',
            // 'text' => 'required',
            // 'title_target' => 'required|max:240',
            // 'text_target' => 'required',
            'title_home' => 'required|max:240',
            'text_home' => 'required',
            'pic' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'pic_home' => 'required|image|mimes:jpeg,jpg,png|max:5120',
        ],
            [
                'title.required' => 'لطفا عنوان درباره ما را وارد کنید',
                'title.max' => 'عنوان درباره ما نباید بیشتر از 240 کاراکتر باشد',
                'title_home.required' => 'لطفا عنوان درباره ما صفحه اصلی را وارد کنید',
                'title_home.max' => 'عنوان درباره ما صفحه اصلی نباید بیشتر از 240 کاراکتر باشد',
                'title_target.required' => 'لطفا عنوان اهداف ما را وارد کنید',
                'title_target.max' => 'عنوان اهداف ما نباید بیشتر از 240 کاراکتر باشد',
                'text.required' => 'لطفا متن درباره ما را وارد کنید',
                'text_home.required' => 'لطفا متن درباره ما صفحه اصلی را وارد کنید',
                'text_target.required' => 'لطفا متن اهداف ما را وارد کنید',
                'pic.image' => 'لطفا یک تصویر انتخاب کنید',
                'pic.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'pic.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                'pic_home.image' => 'لطفا یک تصویر انتخاب کنید',
                'pic_home.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'pic_home.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                'pic_home.required' => 'تصویر وارد نشده',
            ]);
        try {
            $item = new About();
            $item->user_id = $request->user_id;
            $item->title = $request->title;
            $item->title_home = $request->title_home;
            $item->title_target = $request->title_target;
            $item->text = $request->text;
            $item->text_home = $request->text_home;
            $item->text_target = $request->text_target;
            if ($request->hasFile('pic')) {
                $item->pic = file_store($request->pic, 'source/asset/uploads/about/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic-');

            }
            if ($request->hasFile('pic_home')) {
                $item->pic_home = file_store($request->pic_home, 'source/asset/uploads/about/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic_home-');
            }
            $item->save();
            // if(isset($request->title_join))
            // {
            //     $items=AboutJoin::where('type','about')->get();
            //     foreach ($items as $itemss)
            //     {
            //         $itemss->delete();
            //     }
            //     foreach ($request->title_join as $key=>$val)
            //     {
            //         $pic=null;
            //         if(isset($request->pic_join[$key]))
            //         {
            //             $pic=$request->pic_join[$key];
            //         }
            //         $about_join=new AboutJoin();
            //         $about_join->title=$val;
            //         $about_join->type='about';
            //         $about_join->text=$request->text_join[$key];
            //         if (is_file($pic)) {
            //             if(isset($request->pic_join1[$key]) and is_file($request->pic_join1[$key]))
            //             {
            //                 File::delete($request->pic_join1[$key]);
            //             }
            //             $about_join->pic = file_store($pic, 'source/asset/uploads/about/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic_'.$key.'-');;
            //         }
            //         elseif($request->pic_join1[$key]!=null)
            //         {
            //             $about_join->pic=$request->pic_join1[$key];
            //         }
            //     }
            // }

            return redirect()->route('admin.user.list')->with('flash_message', 'درباره ما با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش درباره ما بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function update(Request $request, $id) {
        $this->validate($request, [
            // 'title' => 'required|max:240',
            // 'text' => 'required',
            // 'title_target' => 'required|max:240',
            // 'text_target' => 'required',
            'title_home' => 'required|max:240',
            'text_home' => 'required',
            'pic' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'pic_home' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
        ],
            [
                'title_home.required' => 'لطفا عنوان درباره ما صفحه اصلی را وارد کنید',
                'title_home.max' => 'عنوان درباره ما صفحه اصلی نباید بیشتر از 240 کاراکتر باشد',
                'text_home.required' => 'لطفا متن درباره ما صفحه اصلی را وارد کنید',
                'title.required' => 'لطفا عنوان درباره ما را وارد کنید',
                'title.max' => 'عنوان درباره ما نباید بیشتر از 240 کاراکتر باشد',
                'title_target.required' => 'لطفا عنوان اهداف ما را وارد کنید',
                'title_target.max' => 'عنوان اهداف ما نباید بیشتر از 240 کاراکتر باشد',
                'text.required' => 'لطفا متن درباره ما را وارد کنید',
                'text_target.required' => 'لطفا متن اهداف ما را وارد کنید',
                'pic.image' => 'لطفا یک تصویر انتخاب کنید',
                'pic.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'pic.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                'pic_home.image' => 'لطفا یک تصویر انتخاب کنید',
                'pic_home.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'pic_home.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
            ]);
        if ( auth()->user()->hasRole('مدیر ارشد') ) { 
            $item = About::findOrFail($id);
        } else {
            $item = About::where('user_id', $this->user_id())->findOrFail($id);
        }
        try {
            // $item->title = $request->title;
            // $item->title_target = $request->title_target;
            // $item->text = $request->text;
            // $item->text_target = $request->text_target;
            $item->title_home = $request->title_home;
            $item->text_home = $request->text_home;
            if ($request->hasFile('pic')) {
                if (is_file($item->pic)) {
                    File::delete($item->pic);
                }
                $item->pic = file_store($request->pic, 'source/asset/uploads/about/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic-');

            }
            if ($request->hasFile('pic_home')) {
                if (is_file($item->pic_home)) {
                    File::delete($item->pic_home);
                }
                $item->pic_home = file_store($request->pic_home, 'source/asset/uploads/about/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic_home-');
            }
            $item->update();
            // if ($request->hasFile('pic_home')) {
            //     img_resize(
            //         $item->pic_home,//address img
            //         $item->pic_home,//address save
            //         700,// width: if width==0 -> width=auto
            //         0// height: if height==0 -> height=auto
            //     // end optimaiz
            //     );
            // }
            // if ($request->hasFile('pic')) {
            //     img_resize(
            //         $item->pic,//address img
            //         $item->pic,//address save
            //         700,// width: if width==0 -> width=auto
            //         0// height: if height==0 -> height=auto
            //     // end optimaiz
            //     );
            // }
            // if(isset($request->title_join))
            // {
            //     $items=AboutJoin::where('type','about')->get();
            //     foreach ($items as $itemss)
            //     {
            //         $itemss->delete();
            //     }
            //     foreach ($request->title_join as $key=>$val)
            //     {
            //         $pic=null;
            //         if(isset($request->pic_join[$key]))
            //         {
            //             $pic=$request->pic_join[$key];
            //         }
            //         $about_join=new AboutJoin();
            //         $about_join->title=$val;
            //         $about_join->type='about';
            //         $about_join->text=$request->text_join[$key];
            //         if (is_file($pic)) {
            //             if(isset($request->pic_join1[$key]) and is_file($request->pic_join1[$key]))
            //             {
            //                 File::delete($request->pic_join1[$key]);
            //             }
            //             $about_join->pic = file_store($pic, 'source/asset/uploads/about/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic_'.$key.'-');;
            //         }
            //         elseif($request->pic_join1[$key]!=null)
            //         {
            //             $about_join->pic=$request->pic_join1[$key];
            //         }
            //         // $about_join->save();
            //         // img_resize(
            //         //     $about_join->pic,//address img
            //         //     $about_join->pic,//address save
            //         //     700,// width: if width==0 -> width=auto
            //         //     0// height: if height==0 -> height=auto
            //         // // end optimaiz
            //         // );
            //     }
            // }

            return redirect()->back()->with('flash_message', 'درباره ما با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش درباره ما بوجود آمده،مجددا تلاش کنید');
        }
    }
}


                        