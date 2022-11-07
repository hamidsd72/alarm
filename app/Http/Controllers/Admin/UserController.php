<?php
namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\Photo;
use App\Model\ProvinceCity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Model\About;

class UserController extends Controller {
    public function controller_title($type) {
        if (auth()->user()->hasRole('مدیر ارشد')) {
            if ($type == 'sum') {
                return 'مشتری ها';
            } elseif ('single') {
                return 'مشتری ها';
            }
        } else {
            if ($type == 'sum') {
                return 'لیست کاربران';
            } elseif ('single') {
                return 'کاربر';
            }
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
    public function userRole(Request $request) {
        if ($request->role_name=='مدیر ارشد' || $request->role_name=='مدیر') { return false; }

        if (auth()->user()->hasRole('مدیر ارشد')) {
            $user = User::findOrFail($request->id);
        } elseif (auth()->user()->hasRole('مدیر')) {
            if ($request->role_name=='مدیر') { return false; }
            $user = User::where('reagent_id', auth()->user()->id )->findOrFail($request->id);
        } else { abort(503); }

        if ($request->role_name) {
            foreach ($user->getRoleNames() as $role_name)
            {
                $user->removeRole($role_name);
            }
            $user->assignRole($request->role_name);
        }
        return back()->with('flash_message', 'رول با موفقیت تغییر یافت.');
    }
    public function index() {
        // $items = User::role('کاربر')->where('referrer_id', auth()->user()->reagent_id )->paginate($this->controller_paginate());
        // if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            $items = User::where('reagent_id', $this->user_id() )->paginate($this->controller_paginate());
            if ( auth()->user()->hasRole('مدیر ارشد') ) {
                foreach ($items as $item) {
                    $item->web_site = 'غیرفعال';
                    if( Carbon::parse($item->special_user)->diffInDays(Carbon::now(), false)<0 ) {
                        $item->web_site = 'فعال';
                    }
                }
            }
        // }
        return view('admin.user.index', compact('items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function show($id) {
        if (auth()->user()->hasRole('مدیر ارشد')) {
            $item = User::findOrFail($id);
        } else {
            $item = User::where('reagent_id', $this->user_id())->findOrFail($id);
        }
        return view('admin.user.show', compact('item'), ['title1' => $this->controller_title('single'), 'title2' => ' پروفایل '.$this->controller_title('single')]);
    }
    public function create() {
        $states = ProvinceCity::where('parent_id', null)->get();
        return view('admin.user.create', compact('states'), ['title1' => $this->controller_title('single'), 'title2' => ' افزودن '.$this->controller_title('single')]);
    }
    public function store(Request $request) {
        $this->validate($request, [
            'company_name' => 'max:240',
            'first_name' => 'required|max:240',
            'last_name' => 'required|max:240',
            'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric|unique:users',
            'email' => 'required|email|unique:users',
            'whatsapp' => 'required',
            'reagent_code' => 'integer',
            // 'date_birth' => 'required',
            // 'state_id' => 'required',
            // 'city_id' => 'required',
            // 'locate' => 'required',
            // 'address' => 'required',
            // 'education' => 'required',
            'password' => 'required|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
        ],
        [
            'first_name.required' => 'لطفا نام خود را وارد کنید',
            'first_name.max' => 'نام نباید بیشتر از 240 کاراکتر باشد',
            'company_name.max' => 'نام شرکت نباید بیشتر از 240 کاراکتر باشد',
            'last_name.required' => 'لطفا نام خانوادگی خود را وارد کنید',
            'last_name.max' => 'نام خانوادگی نباید بیشتر از 240 کاراکتر باشد',
            'mobile.required' => 'لطفا موبایل خود را وارد کنید',
            'mobile.regex' => 'لطفا موبایل خود را وارد کنید',
            'mobile.digits' => 'لطفا فرمت موبایل را رعایت کنید',
            'mobile.numeric' => 'لطفا موبایل خود را بصورت عدد وارد کنید',
            'mobile.unique' => 'موبایل وارد شده یکبار ثبت نام شده',
            'email.required' => 'لطفا ایمیل خود را وارد کنید',
            'email.email' => 'فرمت ایمیل را رعایت کنید',
            'email.unique' => ' ایمیل وارد شده یکبار ثبت نام شده',
            'whatsapp.required' => 'لطفا شماره واتساپ فعال خود را وارد کنید',
            'reagent_code.integer' => 'مبلغ حقوق ساعتی را به عدد وارد کنید',
            'date_birth.required' => 'لطفا تاریخ تولد خود را وارد کنید',
            'state_id.required' => 'لطفا استان خود را وارد کنید',
            'city_id.required' => 'لطفا شهر خود را وارد کنید',
            'locate.required' => 'لطفا منطقه خود را وارد کنید',
            'address.required' => 'لطفا آدرس خود را وارد کنید',
            'education.required' => 'لطفا مدرک تحصیلی خود را وارد کنید',
            'password.required' => 'لطفا رمز عبور خود را وارد کنید',
            'password.min' => 'رمز عبور نباید کمتر از 6 کاراکتر باشد',
            'password.confirmed' => 'رمز عبور با تکرار آن برابر نیست',
            'photo.image' => 'لطفا یک تصویر انتخاب کنید',
            'photo.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
            'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
        ]);
             
        if (auth()->user()->employees_count() > auth()->user()->employees_number) {
            return redirect()->back()->withInput()->with('err_message', 'ظرفیت کارمندان شما پر شده, برای ثبت جدید ابتدا پکیج خود را ارتقا دهید');
        }
        try {
            $item = new User();
            $item->company_name = $request->company_name;
            $item->first_name   = $request->first_name;
            $item->last_name    = $request->last_name;
            $item->mobile       = $request->mobile;
            $item->email        = $request->email;
            $item->whatsapp     = $request->whatsapp;
            $item->date_birth   = num_to_en($request->date_birth);
            $item->state_id     = $request->state_id;
            $item->city_id      = $request->city_id;
            $item->locate       = $request->locate;
            $item->address      = $request->address;
            $item->education    = $request->education;
            $item->password     = $request->password;
            $item->reagent_code = $request->reagent_code;
            $item->reagent_id   = $this->user_id();
            if ( auth()->user()->hasRole('مدیر ارشد') ) {
                $item->special_user = \Carbon\Carbon::now()->addWeek();
            }
            $item->save();

            if ( auth()->user()->hasRole('مدیر ارشد') ) {
                $item->assignRole('مدیر');

                $setting = new Setting();
                $setting->user_id       = $item->id;
                $setting->title         = $item->company_name;
                $setting->keyword       = 'هنوز وارد نشده';
                $setting->description   = 'هنوز وارد نشده';
                $setting->paginate      = 10;
                $setting->support_call  = $item->mobile;
                $setting->save();

                $about = new About();
                $about->user_id         = $item->id;
                $about->title_home      = ' درباره '.$item->company_name;
                $about->text_home       = ' توضیحات درباره '.$item->company_name;
                $about->save();

            } else {
                $item->assignRole('کاربر');
            }
            
            if ($request->hasFile('photo')) {
                $photo = new Photo();
                $photo->path = file_store($request->photo, 'source/asset/uploads/user/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
                $item->photo()->save($photo);
                // img_resize(
                //     $photo->path,//address img
                //     $photo->path,//address save
                //     100,// width: if width==0 -> width=auto
                //     100// height: if height==0 -> height=auto
                // // end optimaiz
                // );
            }
            return redirect()->route('admin.user.list')->with('flash_message', 'کاربر با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد کاربر بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function edit($id) {
        if (auth()->user()->hasRole('مدیر ارشد')) {
            $item = User::find($id);
        } else {
            $item = User::where('reagent_id',  $this->user_id())->find($id);
        }
        $states = ProvinceCity::where('parent_id', null)->get();
        $citys = ProvinceCity::where('parent_id', $item->state_id)->get();
        return view('admin.user.edit', compact('item', 'states', 'citys'), ['title1' => $this->controller_title('single'), 'title2' => ' ویرایش '.$this->controller_title('single')]);
    }
    public function update(Request $request, $id) {
        $this->validate($request, [
            'first_name' => 'required|max:240',
            'last_name' => 'required|max:240',
            'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric|unique:users,mobile,'.$id,
            'email' => 'required|email|unique:users,email,'.$id,
            'whatsapp' => 'required',
            'reagent_code' => 'integer',
            'date_birth' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'locate' => 'required',
            'address' => 'required',
            'education' => 'required',
            'password' => 'nullable|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
        ],
            [
                'first_name.required' => 'لطفا نام خود را وارد کنید',
                'first_name.max' => 'نام نباید بیشتر از 240 کاراکتر باشد',
                'last_name.required' => 'لطفا نام خانوادگی خود را وارد کنید',
                'last_name.max' => 'نام خانوادگی نباید بیشتر از 240 کاراکتر باشد',
                'mobile.required' => 'لطفا موبایل خود را وارد کنید',
                'mobile.regex' => 'لطفا موبایل خود را وارد کنید',
                'mobile.digits' => 'لطفا فرمت موبایل را رعایت کنید',
                'mobile.numeric' => 'لطفا موبایل خود را بصورت عدد وارد کنید',
                'mobile.unique' => 'موبایل وارد شده یکبار ثبت نام شده',
                'email.required' => 'لطفا ایمیل خود را وارد کنید',
                'email.email' => 'فرمت ایمیل را رعایت کنید',
                'email.unique' => ' ایمیل وارد شده یکبار ثبت نام شده',
                'reagent_code.integer' => 'مبلغ حقوق ساعتی را به عدد وارد کنید',
                'whatsapp.required' => 'لطفا شماره واتساپ فعال خود را وارد کنید',
                'date_birth.required' => 'لطفا تاریخ تولد خود را وارد کنید',
                'state_id.required' => 'لطفا استان خود را وارد کنید',
                'city_id.required' => 'لطفا شهر خود را وارد کنید',
                'locate.required' => 'لطفا منطقه خود را وارد کنید',
                'address.required' => 'لطفا آدرس خود را وارد کنید',
                'education.required' => 'لطفا مدرک تحصیلی خود را وارد کنید',
                'password.min' => 'رمز عبور نباید کمتر از 6 کاراکتر باشد',
                'password.confirmed' => 'رمز عبور با تکرار آن برابر نیست',
                'photo.image' => 'لطفا یک تصویر انتخاب کنید',
                'photo.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
            ]);
        if (auth()->user()->hasRole('مدیر ارشد')) {
            $item = User::find($id);
        } else {
            $item = User::where('reagent_id',  $this->user_id())->find($id);
        }
        try {
            $item->first_name   = $request->first_name;
            $item->last_name    = $request->last_name;
            $item->mobile       = $request->mobile;
            $item->email        = $request->email;
            $item->whatsapp     = $request->whatsapp;
            $item->date_birth   = num_to_en($request->date_birth);
            $item->state_id     = $request->state_id;
            $item->city_id      = $request->city_id;
            $item->locate       = $request->locate;
            $item->address      = $request->address;
            $item->education    = $request->education;
            $item->reagent_code = $request->reagent_code;
            if ($request->password) {
                $item->password = $request->password;
            }
            $item->update();
            if ($request->hasFile('photo')) {
                if ($item->photo)
                {
                    $old_path = $item->photo->path;
                    File::delete($old_path);
                    $item->photo->delete();
                }
                $photo = new Photo();
                $photo->path = file_store($request->photo, 'source/asset/uploads/user/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                $item->photo()->save($photo);
                img_resize(
                    $photo->path,//address img
                    $photo->path,//address save
                    100,// width: if width==0 -> width=auto
                    100// height: if height==0 -> height=auto
                );
            }
            return redirect()->route('admin.user.list')->with('flash_message', 'کاربر با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش کاربر بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function destroy($id) {
        if (auth()->user()->hasRole('مدیر ارشد')) {
            User::findOrFail($id)->delete();
        } else {
            User::where('reagent_id',  $this->user_id())->findOrFail($id)->delete();
        }
        return redirect()->back()->with('flash_message', 'کاربر با موفقیت حذف شد.');
    }
    public function active($id, $type) {
        if (auth()->user()->hasRole('مدیر ارشد')) {
            $item = User::find($id);
        } else {
            $item = User::where('reagent_id',  $this->user_id())->find($id);
        }
        try {
            $item->user_status = $type;
            $item->update();
            if ($type == 'blocked') {
                return redirect()->back()->with('flash_message', 'کاربر با موفقیت مسدود شد.');
            }
            if ($type == 'active') {
                return redirect()->back()->with('flash_message', 'کاربر با موفقیت فعال شد.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در تغییر وضعیت کاربر بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function fastLogin($id) {
        if (auth()->user()->hasRole('مدیر ارشد')) {
            auth()->loginUsingId($id, true);
            return redirect()->route('user.index');
        }
        abort(503);
    }
}


