<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\ServicePackage;
use App\Model\ServicePackagePrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ServicePackagePriceController extends Controller
{

    public function controller_paginate()
    {
        $settings = Setting::select('paginate')->latest()->firstOrFail();
        return $settings->paginate;
    }

    public function __construct()
    {
        $this->middleware(['auth', 'SpecialUser']);
    }

    public function index($p_id)
    {
        $package = ServicePackage::find($p_id);
        $items = ServicePackagePrice::where('package_id',$p_id)->orderBy('month_time','asc')->paginate($this->controller_paginate());
        $title=$package?$package->title:'';
        return view('admin.service.package.price.index', compact('items','package'), ['title1' => 'خدمات', 'title2' => 'لیست قیمت : '.$title]);
    }

    public function store(Request $request,$p_id,$type)
    {
        $this->validate($request, [
            'month_time' => 'required',
            'price' => 'required',
        ],
            [
                'month_time.required' => 'لطفا ماه را وارد کنید',
                'price.required' => 'لطفا قیمت را وارد کنید',
            ]);
        try {
            $item = new ServicePackagePrice();
            $item->month_time = $request->month_time;
            $item->price = $request->price;
            $item->package_id = $p_id;
            $item->type = $type;
            $item->save();

            return redirect()->back()->with('flash_message', '  با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد قیمت پکیج بوجود آمده،مجددا تلاش کنید');
        }
    }


    public function destroy($id)
    {
        $item = ServicePackagePrice::find($id);
        try {
            $item->delete();
            return redirect()->back()->with('flash_message', ' با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف قیمت پکیج بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function active($id,$type)
    {
        $item = ServicePackagePrice::find($id);
        try {
            $item->status = $type;
            $item->update();
            if ($type == 'pending') {
                return redirect()->back()->with('flash_message', 'نمایش قیمت با موفقیت غیرفعال شد.');
            }
            if ($type == 'active') {
                return redirect()->back()->with('flash_message', 'نمایش قیمت با موفقیت فعال شد.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در تغییر وضعیت قیمت پکیج بوجود آمده،مجددا تلاش کنید');
        }
    }
}


