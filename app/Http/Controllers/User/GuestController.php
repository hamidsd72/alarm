<?php

namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Sms;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Model\Filep; 
use App\Model\ProvinceCity;
use App\Model\Slider;
use App\Model\ServiceCat;
use App\Model\Photo;
use App\Model\Custom;
use App\Model\About;
use App\Model\Service;
use App\Model\OffCode;
use App\Model\ServicePackage;
use App\Model\Network;
use App\Model\Setting;
use App\Model\Item;
use App\Model\ServicePlusBuy;
use App\Model\ServicePackagePrice;
use Illuminate\Support\Facades\Auth;
use App\Model\Contact;
use Illuminate\Support\Facades\Cookie;
use App\Notifications\Withdrawal;

class GuestController extends Controller
{
    public function index()
    {
        if (auth()->user()) {
            return redirect()->route('user.index');
        }
        $setting    = Setting::first();
        $items      = Item::where('page_name', 'landing')->where('status', 'active')->orderBy('sort')->get();
        $network    = Network::where('user_id', 1)->where('status', 'active')->orderByDesc('sort')->get();
        return view('user.landing', compact('network','setting','items'));
        
    }

    public function create()
    {
        if (auth()->user()) {
            return redirect()->route('user.index');
        }

        $show_modal = true;
        return view('auth.register1', compact('show_modal'));
    }

    public function register()
    {
        if (auth()->user()) {
            return redirect()->route('user.index');
        }

        $show_modal = true;
        return view('auth.register2', compact('show_modal'));
    }

    public function remember_password($number) {
        $user   = User::where('mobile', $number)->first();
        if ($user && $user->email) {
            $hash   = Hash::make($user->email.$user->mobile.Carbon::now());
            $hash   = str_replace('/', '1', $hash);
            $hash   = str_replace('?', '2', $hash);
            $hash   = str_replace('.', '3', $hash);
            $user->password_reset_link          = $hash;
            $user->password_reset_created_at    = Carbon::now();
            $user->update();
            $user->notify(new Withdrawal( $user->password_reset_link ));
            return response()->json(['log' => 'یک ایمیل حاوی لینک بازیابی رمزعبور برای شما ارسال شد'] , 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        return response()->json(['log' => 'کاربری با این شماره یافت نشد'] , 404, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

    public function set_password_by_token($token) {
        $user   = User::where('password_reset_link', $token)->first();
        if (Carbon::parse($user->password_reset_created_at)->diffInMinutes(Carbon::now(), false) < 15) {
            return view('auth.reset', compact('token'));
        }
        abort('404');
    }

    public function update_password_by_token(Request $request) {
        $user   = User::where('password_reset_link', $request->p_token)->first();
        if (Carbon::parse($user->password_reset_created_at)->diffInMinutes(Carbon::now(), false) < 15) {
            if ($request->password == $request->confirm_password) {
                $user->password = $request->password;
                $user->update();
                auth()->loginUsingId($user->id, true);
                return redirect()->route('user.index');
            }
            return redirect()->back();
        }
        abort('404');
    }

}