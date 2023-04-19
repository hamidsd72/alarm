<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\Network;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class SettingController extends Controller {
    public function controller_title($type) {
        if ($type == 'sum') {
            return 'شبکه های اجتماعی اپلیکیشن';
        } elseif ('single') {
            return 'شبکه اجتماعی اپلیکیشن';
        }
    } 
    public function controller_title2($type) {
        if ($type == 'sum') {
            return 'تنظیمات اپلیکیشن';
        } elseif ('single') {
            return 'تنظیمات اپلیکیشن';
        }
    }
    function user_id() {
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            return auth()->user()->id;
        } else {
            return auth()->user()->reagent_id;
        }
    }
    public function controller_paginate() {
        return Setting::select('paginate')->where('user_id', $this->user_id())->first()->paginate;
    }
    public function __construct() {
        $this->middleware(['auth', 'SpecialUser','Access']);
    }
    public function index() {
        $items = Network::where('user_id', $this->user_id() )->get();
        return view('admin.setting.network.index', compact('items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function create() {
        return view('admin.setting.network.create', ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function store(Request $request) {
        if ( $this->user_id() == $request->user_id ) {
            Network::create($request->all());
            return redirect()->route('admin.network-setting.index');
        }
        abort('503');
    }
    public function destroy($id) {
        Network::where('user_id', $this->user_id() )->findOrFail($id)->delete();
        return redirect()->route('admin.network-setting.index');
    }
    public function setting_create($id) {
        if ( auth()->user()->getRoleNames()->first()=='مدیر ارشد' ) {
            $user = User::findOrFail($id);
            $full_name = $user->first_name.' '.$user->last_name;
            return view('admin.setting.create', compact('id','full_name'), ['title1' => ' ثبت '.$this->controller_title2('single'), 'title2' => ' ثبت '.$this->controller_title2('sum')]);
        }
        abort('503');
    }
    public function setting_store(Request $request) {
        if ( auth()->user()->getRoleNames()->first()=='مدیر ارشد' ) {
            $this->validate($request, [
                'id' => 'required',
                'title' => 'required|max:240',
                'keyword' => 'nullable|max:500',
                'description' => 'nullable|max:500',
                'support_call' => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric',
                'paginate' => 'required',
                'logo_site' => 'nullable|image|mimes:png|max:5120',
                'icon_site' => 'nullable|image|mimes:png|max:5120',
            ],
                [
                    'id.required' => 'لطفا ای دی سایت را وارد کنید',
                    'title.required' => 'لطفا نام سایت را وارد کنید',
                    'title.max' => 'نام سایت نباید بیشتر از 240 کاراکتر باشد',
                    'keyword.max' => 'کلمات کلیدی نباید بیشتر از 500 کاراکتر باشد',
                    'description.max' => 'توضیحات سئو نباید بیشتر از 500 کاراکتر باشد',
                    'paginate.required' => 'تعداد نمایش فیلد در هر صفحه را وارد کنید',
                    'logo_site.image' => 'لطفا یک تصویر انتخاب کنید',
                    'support_call.required' => 'لطفا موبایل پشتیبانی را وارد کنید',
                    'support_call.regex' => 'لطفا موبایل پشتیبانی را وارد کنید',
                    'support_call.digits' => 'لطفا فرمت موبایل پشتیبانی را رعایت کنید',
                    'support_call.numeric' => 'لطفا موبایل پشتیبانی را بصورت عدد وارد کنید',
                    'logo_site.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                    'logo_site.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                    'icon_site.image' => 'لطفا یک تصویر انتخاب کنید',
                    'icon_site.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                    'icon_site.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                ]);
            $off_day = '';
            if ($request->شنبه && $request->شنبه=="on") {
                $off_day = $off_day."شنبه,";
            }
            if ($request->یکشنبه && $request->یکشنبه=="on") {
                $off_day = $off_day."یکشنبه,";
            }
            if ($request->دوشنبه && $request->دوشنبه=="on") {
                $off_day = $off_day."دوشنبه,";
            }
            if ($request->سه‌شنبه && $request->سه‌شنبه=="on") {
                $off_day = $off_day."سه‌شنبه,";
            }
            if ($request->چهارشنبه && $request->چهارشنبه=="on") {
                $off_day = $off_day."چهارشنبه,";
            }
            if ($request->پنجشنبه && $request->پنجشنبه=="on") {
                $off_day = $off_day."پنجشنبه,";
            }
            if ($request->جمعه && $request->جمعه=="on") {
                $off_day = $off_day."جمعه";
            }
            if ($request->leave_day_limit > 300) {
                return redirect()->back()->withInput()->with('err_message', 'میزان روز مرخصی سالانه وارد شده منطقی نیست');
            }
            $item = new Setting();
            try {
                $item->user_id          = $request->id;
                $item->title            = $request->title;
                $item->keyword          = $request->keyword;
                $item->description      = $request->description;
                $item->sign_in_type     = $request->sign_in_type;
                $item->paginate         = $request->paginate;
                $item->leave_day_limit  = $request->leave_day_limit;
                $item->off_day          = $off_day;
                $item->support_call     = $request->support_call;
                $item->dailyStartTime   = $request->dailyStartTime;
                $item->dailyFinishTime  = $request->dailyFinishTime;            
                if ($request->hasFile('logo_site')) {
                    $item->logo_site    = file_store($request->logo_site, 'source/asset/uploads/setting/' . $request->id. '/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'logo_site-');
                }
                
                if ($request->hasFile('icon_site')) {
                    $item->icon_site = file_store($request->icon_site, 'source/asset/uploads/setting/' . $request->id. '/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'icon_site-');
                }

                $item->save();
                return redirect()->route('admin.user.list')->with('flash_message', 'تنظیمات سایت با موفقیت ثبت شد.');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('err_message', 'مشکلی در ثبت تنظیمات سایت بوجود آمده،مجددا تلاش کنید');
            }

        }
        abort('503');
    }
    public function edit($id=null) {
        $item = Setting::where('user_id', auth()->user()->id )->first();
        if ( auth()->user()->getRoleNames()->first()=='مدیر ارشد' && $id ) {
            $item = Setting::findOrFail($id);
        }
        $shanbe     = '';
        $yekshanbe  = '';
        $doshanbe   = '';
        $seshanbe   = '';
        $charshanbe = '';
        $panjshanbe = '';
        $jome       = '';
        if (in_array("شنبه", explode(',',$item->off_day) )) {
            $shanbe       = 'checked';
        }
        if (in_array("یکشنبه", explode(',',$item->off_day) )) {
            $yekshanbe     = 'checked';
        }
        if (in_array("دوشنبه", explode(',',$item->off_day) )) {
            $doshanbe     = 'checked';
        }
        if (in_array("سه‌شنبه", explode(',',$item->off_day) )) {
            $seshanbe     = 'checked';
        }
        if (in_array("چهارشنبه", explode(',',$item->off_day) )) {
            $charshanbe   = 'checked';
        }
        if (in_array("پنجشنبه", explode(',',$item->off_day) )) {
            $panjshanbe    = 'checked';
        }
        if (in_array("جمعه", explode(',',$item->off_day) )) {
            $jome       = 'checked';
        }
        
        return view('admin.setting.edit', compact('item','shanbe','yekshanbe','doshanbe','seshanbe','charshanbe','panjshanbe','jome'), ['title1' => $this->controller_title2('single'), 'title2' => $this->controller_title2('sum')]);
    }
    public function update(Request $request, $id) {

        $this->validate($request, [
            'title' => 'required|max:240',
            'keyword' => 'nullable|max:500',
            'description' => 'nullable|max:500',
            'paginate' => 'required',
            // 'support_call' => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric',
            'support_call' => 'required|numeric',
            'logo_site' => 'nullable|image|mimes:png|max:5120',
            'icon_site' => 'nullable|image|mimes:png|max:5120',
        ],
            [
                'title.required' => 'لطفا نام سایت را وارد کنید',
                'title.max' => 'نام سایت نباید بیشتر از 240 کاراکتر باشد',
                'keyword.max' => 'کلمات کلیدی نباید بیشتر از 500 کاراکتر باشد',
                'description.max' => 'توضیحات سئو نباید بیشتر از 500 کاراکتر باشد',
                'paginate.required' => 'تعداد نمایش فیلد در هر صفحه را وارد کنید',
                'support_call.required' => 'لطفا موبایل پشتیبانی را وارد کنید',
                'support_call.regex' => 'لطفا موبایل پشتیبانی را وارد کنید',
                'support_call.digits' => 'لطفا فرمت موبایل پشتیبانی را رعایت کنید',
                'support_call.numeric' => 'لطفا موبایل پشتیبانی را بصورت عدد وارد کنید',
                'logo_site.image' => 'لطفا یک تصویر انتخاب کنید',
                'logo_site.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'logo_site.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                'icon_site.image' => 'لطفا یک تصویر انتخاب کنید',
                'icon_site.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'icon_site.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
            ]);
        $item = Setting::where('user_id', auth()->user()->id )->first();
        if ( auth()->user()->getRoleNames()->first()=='مدیر ارشد' ) {
            $item = Setting::findOrFail($id);
        }
        $off_day = '';
        if ($request->شنبه && $request->شنبه=="on") {
            $off_day = $off_day."شنبه,";
        }
        if ($request->یکشنبه && $request->یکشنبه=="on") {
            $off_day = $off_day."یکشنبه,";
        }
        if ($request->دوشنبه && $request->دوشنبه=="on") {
            $off_day = $off_day."دوشنبه,";
        }
        if ($request->سه‌شنبه && $request->سه‌شنبه=="on") {
            $off_day = $off_day."سه‌شنبه,";
        }
        if ($request->چهارشنبه && $request->چهارشنبه=="on") {
            $off_day = $off_day."چهارشنبه,";
        }
        if ($request->پنجشنبه && $request->پنجشنبه=="on") {
            $off_day = $off_day."پنجشنبه,";
        }
        if ($request->جمعه && $request->جمعه=="on") {
            $off_day = $off_day."جمعه";
        }
        if ($request->leave_day_limit > 300) {
            return redirect()->back()->withInput()->with('err_message', 'میزان روز مرخصی سالانه وارد شده منطقی نیست');
        }
        try {
            $item->title = $request->title;
            $item->dailyStartTime   = $request->dailyStartTime;
            $item->dailyFinishTime  = $request->dailyFinishTime;
            $item->keyword          = $request->keyword;
            $item->leave_day_limit  = $request->leave_day_limit;
            $item->sign_in_type     = $request->sign_in_type;
            $item->off_day          = $off_day;
            $item->description      = $request->description;
            $item->paginate         = $request->paginate;
            $item->support_call     = $request->support_call;
            if ($request->hasFile('logo_site')) {
                if (is_file($item->logo_site)) {
                    $old_path = $item->logo_site;
                    File::delete($old_path);
                }
                $item->logo_site = file_store($request->logo_site, 'source/asset/uploads/setting/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'logo_site-');
            }
            if ($request->hasFile('icon_site')) {
                if (is_file($item->icon_site)) {
                    $old_path = $item->icon_site;
                    File::delete($old_path);
                }
                $item->icon_site = file_store($request->icon_site, 'source/asset/uploads/setting/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'icon_site-');
            }
            $item->update();
            // if ($request->hasFile('logo_site')) {
            //     img_resize(
            //         $item->logo_site,//address img
            //         $item->logo_site,//address save
            //         150,// width: if width==0 -> width=auto
            //         0// height: if height==0 -> height=auto
            //     // end optimaiz
            //     );
            // }
            // if ($request->hasFile('icon_site')) {
            //     img_resize(
            //         $item->icon_site,//address img
            //         $item->icon_site,//address save
            //         50,// width: if width==0 -> width=auto
            //         0// height: if height==0 -> height=auto
            //     // end optimaiz
            //     );
            // }
            return redirect()->back()->with('flash_message', 'تنظیمات سایت با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->with('err_message', 'مشکلی در ویرایش تنظیمات سایت بوجود آمده،مجددا تلاش کنید');
        }
    }
}


