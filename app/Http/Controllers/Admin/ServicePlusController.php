<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\Service;
use App\Model\ServicePlus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ServicePlusController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return 'خدمت +';
        } elseif ('single') {
            return 'خدمت +';
        }
    }

    public function controller_paginate()
    {
        $settings = Setting::select('paginate')->latest()->firstOrFail();
        return $settings->paginate;
    }

    public function __construct()
    {
        $this->middleware(['auth', 'SpecialUser']);
    }

    public function index($s_id)
    {
        $service = Service::find($s_id);
        $items = ServicePlus::where('service_id',$s_id)->paginate($this->controller_paginate());
        return view('admin.service.plus.index', compact('items','service'), ['title1' => 'خدمات', 'title2' => 'لیست خدمت + : '.$service->title]);
    }

    public function create($s_id)
    {
        $service = Service::find($s_id);
        return view('admin.service.plus.create',compact('service'), ['title1' => 'خدمات', 'title2' => 'افزودن خدمت + : '.$service->title]);
    }

    public function store(Request $request,$s_id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'time' => 'required',
            'price' => 'required',
        ],
            [
                'title.required' => 'لطفا عنوان را وارد کنید',
                'title.max' => 'عنوان نباید بیشتر از 240 کاراکتر باشد',
                'time.required' => 'لطفا زمان را وارد کنید',
                'price.required' => 'لطفا هزینه را وارد کنید',
            ]);
        try {
            $item = new ServicePlus();
            $item->title = $request->title;
            $item->time = $request->time;
            $item->time_type = $request->time_type;
            $item->price = $request->price;
            $item->service_id = $s_id;
            $item->save();

            return redirect()->route('admin.service.plus.list',$s_id)->with('flash_message', ' خدمت + با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد خدمت + بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function edit($id)
    {
        $item = ServicePlus::find($id);
        return view('admin.service.plus.edit', compact('item'), ['title1' => 'خدمات', 'title2' => 'ویرایش خدمت + : '.$item->service->title]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'time' => 'required',
            'price' => 'required',
        ],
            [
                'title.required' => 'لطفا عنوان را وارد کنید',
                'title.max' => 'عنوان نباید بیشتر از 240 کاراکتر باشد',
                'time.required' => 'لطفا زمان را وارد کنید',
                'price.required' => 'لطفا هزینه را وارد کنید',
            ]);
        $item = ServicePlus::find($id);
        try {
            $item->title = $request->title;
            $item->time = $request->time;
            $item->time_type = $request->time_type;
            $item->price = $request->price;
            $item->update();
            return redirect()->route('admin.service.plus.list',$item->service_id)->with('flash_message', 'خدمت + با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش خدمت + بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function destroy($id)
    {
        $item = ServicePlus::find($id);
        try {
            $item->delete();
            return redirect()->back()->with('flash_message', 'خدمت + با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در خدمت + سوال بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function active($id, $type)
    {
        $item = ServicePlus::find($id);
        try {
            $item->status = $type;
            $item->update();
            if ($type == 'pending') {
                return redirect()->back()->with('flash_message', 'نمایش خدمت + با موفقیت غیرفعال شد.');
            }
            if ($type == 'active') {
                return redirect()->back()->with('flash_message', 'نمایش خدمت + با موفقیت فعال شد.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در تغییر وضعیت خدمت + بوجود آمده،مجددا تلاش کنید');
        }
    }
}


