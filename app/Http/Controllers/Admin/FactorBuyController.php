<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\BasketFactor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class FactorBuyController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return 'خرید ها';
        } elseif ('single') {
            return 'خرید ها';
        }
    }

    public function controller_paginate()
    {
        $settings = Setting::select('paginate')->latest()->firstOrFail();
        return $settings->paginate;
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $items="";

        if (Auth::user()->hasRole('مدیر')){
            $items = BasketFactor::where('status','!=','pending')->orderBy('id','desc')->paginate($this->controller_paginate());
        }
        elseif (Auth::user()->hasRole('کاربر')){
            $items = BasketFactor::where('status','!=','pending')->where('user_id',Auth()->user()->id)->orderBy('id','desc')->where('status','!=','blocked')->paginate($this->controller_paginate());
        }
        return view('admin.factor.buy.index', compact('items'), ['title1' => 'خدمات', 'title2' => $this->controller_title('sum')]);
    }

//    public function active($id, $type)
//    {
//        $item = ServiceFactor::find($id);
//        try {
//            $item->status = $type;
//            $item->update();
//            if ($type == 'cancel') {
//                return redirect()->back()->with('flash_message', ' با موفقیت کنسل شد.');
//            }
//            if ($type == 'working') {
//                return redirect()->back()->with('flash_message', ' با موفقیت تایید شد.');
//            }
//            if ($type == 'active') {
//                return redirect()->back()->with('flash_message', ' با موفقیت انجام شد.');
//            }
//        } catch (\Exception $e) {
//            return redirect()->back()->withInput()->with('err_message', 'مشکلی در تغییر وضعیت بوجود آمده،مجددا تلاش کنید');
//        }
//    }
}


