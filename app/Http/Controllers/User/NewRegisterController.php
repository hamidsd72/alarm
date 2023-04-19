<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Sms;
use App\Model\Setting;
use App\Model\About;
use Carbon\Carbon;


class NewRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function store(Request $request)
    {
        if ( strlen($request->mobile) == 11 ) {
            $app_name = ' کد تایید سامانه '.Setting::find(1)->title.' : ';

            $number          = $request->mobile;
            $mobile_verified = rand(100000, 999999);
            $user            = User::where('mobile', $number)->first();

            if ($user) {
                if ($user->hasRole('مدیر ') || $user->hasRole('مدیر') ) {
                    $admin = $user;
                } else {
                    $admin = User::find($user->reagent_id);
                }

                if( $user->id > 1 && Setting::where('user_id' , $admin->id )->first('sign_in_type')->sign_in_type=='sms' ) {

                    if ($admin->sms_inventory > 0 ) {
                        $user->mobile_verified = $mobile_verified;
                        $user->update();
                        Sms::SendSms( $app_name.$user->mobile_verified , $number);
                        $admin->sms_inventory -= 1;
                        $admin->update(); 
                        return redirect()->route('user.sign-up-using-mobile.edit',$number);
                    } else {
                        $error = 'اعتبار پنل به پایان رسیده است.';
                    }
                } else {
                    return redirect()->route('user.sign-up-using-mobile.edit',$number);
                }
                    
            }
        }
        $error = 'شماره وارد شده نامعتبر است';
        return view('auth.login', compact('error') );
    }

    public function edit($sign_up_using_mobile)
    {
        $number = $sign_up_using_mobile;
        $user   = User::where('mobile',$sign_up_using_mobile)->first();
        if ($user->hasRole('مدیر ') || $user->hasRole('مدیر') ) {
            $admin = $user;
        } else {
            $admin = User::find($user->reagent_id);
        }

        $sms = false;
        if( $user->id > 1 && Setting::where('user_id' , $admin->id )->first('sign_in_type')->sign_in_type=='sms' ) {
            $sms = true;
        }

        return view('auth.verify', compact('number','sms') );
    }

    public function update(Request $request, $id)
    {
        $user = User::where('mobile',$id)->first();
        if ($user->hasRole('مدیر ') || $user->hasRole('مدیر') ) {
            $admin = $user;
        } else {
            $admin = User::find($user->reagent_id);
        }

        $error = 'کد وارد شده نامعتبر است';

        $sms = false;
        if( $user->id > 1 && Setting::where('user_id' , $admin->id )->first('sign_in_type')->sign_in_type=='sms' ) {
            $sms = true;

            if ( strlen($request->code) == 6 ) {            
                if ($user->mobile_verified == $request->code  && $user->updated_at->diffInMinutes(Carbon::now(), false) < 5) {
                    auth()->loginUsingId($user->id, true);
                    return redirect()->route('user.index');
                }
                $error  = 'کد صحیح نیست یا تاریخ گذشته است';
            }
        } else {
            if ( password_verify( $request->code , $user->password) ) {
                auth()->loginUsingId($user->id, true);
                return redirect()->route('user.index');
            }
            $error  = 'رمزعبور صحیح نیست';
        }

        $number = $id;
        return view('auth.verify', compact('number', 'error','sms') );
    }

    public function destroy($id)
    {
        //
    }

    public function sign_up(Request $request) {
        $this->validate($request, [
            'company_name' => 'required|max:240',
            'first_name' => 'required|max:240',
            'last_name' => 'required|max:240',
            'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric|unique:users',
            'email' => 'required|email|unique:users',
            'whatsapp' => 'required',
            // 'reagent_code' => 'integer',
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
                
        try {
            $item = new User();
            $item->mobile       = $request->mobile;
            $item->company_name = $request->company_name;
            $item->first_name   = $request->first_name;
            $item->last_name    = $request->last_name;
            $item->email        = $request->email;
            $item->whatsapp     = $request->whatsapp;
            $item->password     = $request->password;
            $item->reagent_id   = 1;
            $item->special_user = \Carbon\Carbon::now()->addWeek();
            $item->save();
            
            $item->assignRole('مدیر');
            auth()->loginUsingId($item->id, true);

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
            return redirect()->route('admin.index');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد کاربر بوجود آمده،مجددا تلاش کنید');
        }
    }

}
