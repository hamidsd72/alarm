<?php

namespace App\Http\Controllers\User;

use App\User;
use App\Model\Sms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    public function reset_password_show()
    {
        return view('auth.password.index');
    }
    public function reset_password_post(Request $request)
    {
        $this->validate($request, [
            'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric',
        ],
            [
                'mobile.required' => 'لطفا موبایل خود را وارد کنید',
                'mobile.regex' => 'لطفا موبایل خود را وارد کنید',
                'mobile.digits' => 'لطفا فرمت موبایل را رعایت کنید',
                'mobile.numeric' => 'لطفا موبایل خود را بصورت عدد وارد کنید',
            ]);
        $user=User::where('mobile',$request->mobile)->first();
        if($user)
        {
            $user->mobile_verified=rand(1001,9999);
            $user->update();
            $text='کد تایید سدارکارت : '.$user->mobile_verified;
            Sms::SendSms($text  ,$request->mobile);
            session(['mobile_num' => $request->mobile]);
            return redirect()->route('user.reset.password.verify')->with('flash_message', 'کد ارسال شده به شماره همراه خود را وارد کنید');
        }
        else
        {
            return redirect()->back()->with('err_message', 'شماره همراه وارد شده در اطلاعات سدار کارت یافت نشد');
        }
    }

    public function reset_password_verify()
    {
        return view('auth.password.code');
    }

    public function reset_password_verify_post(Request $request)
    {
        $user=User::where('mobile',session('mobile_num'))->first();
        if($user and $request->verify_code==$user->mobile_verified)
        {
            session(['verify_set' => 'ok']);
            return redirect()->route('user.new.password')->with('flash_message', 'لطفا پسورد جدید خود را وارد کنید');
        }
        else {
            return redirect()->back()->withInput()->with('err_message', 'لطفا کد تایید را صحیح وارد کنید');
        }
    }

    public function new_password()
    {
        if (!session()->has('verify_set')) {
            abort(404);
        }
        return view('auth.password.password');
    }

    public function new_password_post(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ],
            [
                'password.required'=>'لطفا رمز عبور خود را وارد کنید',
                'password.min'=>'رمز عبور نباید کمتر از 6 کاراکتر باشد',
                'password.confirmed'=>'رمز عبور با تکرار آن برابر نیست',
            ]);
        $item=User::where('mobile',session('mobile_num'))->first();
        try {
            if ($request->password) {
                $item->password = $request->password;
            }
            $item->update();
            session()->forget('mobile_num');
            session()->forget('verify_set');
            Auth::loginUsingId($item->id);
            return redirect()->route('admin.profile.show')->with('flash_message', 'رمز عبور با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message','مشکلی در تغیر رمز عبور بوجود آمده،مجددا تلاش کنید');
        }
    }

}
