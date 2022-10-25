<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Sms;
use Carbon\Carbon;


class NewRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if ( strlen($request->mobile) == 11 ) {
            $app_name = ' کد تایید سامانه '.\App\Model\Setting::find(1)->title.' : ';

            $number          = $request->mobile;
            $mobile_verified = rand(100000, 999999);
            $user            = User::where('mobile', $number)->first();

            if ($user) {
                if ($user->hasRole('مدیر ') || $user->hasRole('مدیر') ) {
                    $admin = $user;
                } else {
                    $admin = User::find($user->reagent_id);
                }

                if ($admin->sms_inventory > 0) {
                    $user->mobile_verified = $mobile_verified;
                    $user->update();
                    Sms::SendSms( $app_name.$user->mobile_verified , $number);
                    $admin->sms_inventory -= 1;
                    $admin->update(); 
                    return redirect('/sign-up-using-mobile/'.$number.'/edit');
                } else {
                    $error = 'اعتبار پنل به پایان رسیده است.';
                }
            }
            // $user = User::where('email', $request->mobile)->first();
            // if ($user) {
                // if ( password_verify( $request->password, $user->password) ) {
                //     auth()->loginUsingId($user->id, true);
                //     return redirect()->route('user.index');
                // }
            // }
            // $error = 'ایمیل یا رمزعبور نامعتبر است';
            // return view('auth.login', compact('error') );
        }
        $error = 'شماره وارد شده نامعتبر است';
        return view('auth.login', compact('error') );
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $number = $id;
        return view('auth.verify', compact('number') );
    }

    public function update(Request $request, $id)
    {
        
        if ( strlen($request->code) == 6 ) {
            $user = User::where('mobile',$id)->first();
            
            if ($user->mobile_verified == $request->code  && $user->updated_at->diffInMinutes(Carbon::now(), false) < 5) {
                auth()->loginUsingId($user->id, true);
                return redirect()->route('user.index');
            }
            $error  = 'کد صحیح نیست یا تاریخ گذشته است';
        } else {
            $error = 'کد وارد شده نامعتبر است';
        }

        $number = $id;
        return view('auth.verify', compact('number', 'error') );
    }

    public function destroy($id)
    {
        //
    }
}