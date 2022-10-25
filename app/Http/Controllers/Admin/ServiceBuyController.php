<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\ServiceBuy;
use App\Model\ServiceFactor;
use App\Model\BasketFactor;
use App\Model\Service;
use App\Model\Photo;
use App\Model\Filep;
use App\Model\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ServiceBuyController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return ' خدمات خریداری شده';
        } elseif ('single') {
            return ' خدمات خریداری شده';
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
        $items = BasketFactor::orderBy('id','desc');
        if (Auth::user()->hasRole('کاربر'))
        {
            $items=$items->where('user_id',Auth()->user()->id);
        }
        $items=$items->paginate($this->controller_paginate());
        
        return view('admin.service.buy.index', compact('items'), ['title1' => 'خدمات', 'title2' => $this->controller_title('sum')]);
    }

    public function active($id, $type)
    {
        $item = BasketFactor::find($id);
        try {
            $item->status = $type;
            $item->update();
            if ($type == 'cancel') {
                return redirect()->back()->with('flash_message', ' با موفقیت کنسل شد.');
            }
            if ($type == 'working') {
                return redirect()->back()->with('flash_message', ' با موفقیت تایید شد.');
            }
            if ($type == 'active') {
                return redirect()->back()->with('flash_message', ' با موفقیت انجام شد.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در تغییر وضعیت بوجود آمده،مجددا تلاش کنید');
        }
    }
}


