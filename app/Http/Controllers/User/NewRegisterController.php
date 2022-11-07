<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Sms;
use App\Model\Setting;
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

                if( Setting::where('user_id' , $admin->id )->first('sign_in_type')->sign_in_type=='sms' ) {

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
        if( Setting::where('user_id' , $admin->id )->first('sign_in_type')->sign_in_type=='sms' ) {
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
        if( Setting::where('user_id' , $admin->id )->first('sign_in_type')->sign_in_type=='sms' ) {
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
}