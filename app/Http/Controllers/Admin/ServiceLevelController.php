<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\Service;
use App\Model\ServiceLevel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ServiceLevelController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return ' سطح خدمت';
        } elseif ('single') {
            return ' سطح خدمت';
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

    public function index($s_id)
    {
        $service = Service::find($s_id);
        $items = ServiceLevel::where('service_id',$s_id)->orderBy('level','asc')->paginate($this->controller_paginate());
        $title=$service?$service->title:'';
        return view('admin.service.level.index', compact('items','service'), ['title1' => 'خدمات', 'title2' => 'لیست سطح خدمت : '.$title]);
    }

    public function create($s_id)
    {
        $service = Service::find($s_id);
        $title=$service?$service->title:'';
        return view('admin.service.level.create',compact('service'), ['title1' => 'خدمات', 'title2' => 'افزودن سطح خدمت : '.$title]);
    }

    public function store(Request $request,$s_id)
    {
        $this->validate($request, [
            'title' => 'required|max:240',
            'level' => 'required',
        ],
            [
                'title.required' => 'لطفا عنوان سطح خدمت را وارد کنید',
                'title.max' => 'عنوان سطح خدمت  نباید بیشتر از 240 کاراکتر باشد',
                'level.required' => 'لطفا سطح را وارد کنید',
            ]);
        try {
            $item = new ServiceLevel();
            $item->title = $request->title;
            $item->level = $request->level;
            $item->service_id = $s_id;
            $item->text = $request->text;
            $item->count_correct_answer = $request->count_correct_answer;
            $item->count_query = $request->count_query;
            $item->time_answer = $request->time_answer;
            $item->save();

            return redirect()->route('admin.service.level.list',$s_id)->with('flash_message', ' سطح خدمت با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد سطح خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function edit($id)
    {
        $item = ServiceLevel::find($id);
        $service = Service::find($item->service_id);
        $title=$service?$service->title:'';
        return view('admin.service.level.edit', compact('item'), ['title1' => 'خدمات', 'title2' => 'ویرایش سطح خدمت : '.$title]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:240',
            'level' => 'required',
        ],
            [
                'title.required' => 'لطفا عنوان سطح خدمت را وارد کنید',
                'title.max' => 'عنوان سطح خدمت  نباید بیشتر از 240 کاراکتر باشد',
                'level.required' => 'لطفا سطح را وارد کنید',
            ]);
        $item = ServiceLevel::find($id);
        try {
            $item->title = $request->title;
            $item->level = $request->level;
            $item->text = $request->text;
            $item->count_correct_answer = $request->count_correct_answer;
            $item->count_query = $request->count_query;
            $item->time_answer = $request->time_answer;
            $item->update();
            return redirect()->route('admin.service.level.list',$item->service_id)->with('flash_message', 'سطح خدمت با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش سطح خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function destroy($id)
    {
        $item = ServiceLevel::find($id);
        try {
            if(count($item->questions))
            {
                return redirect()->back()->withInput()->with('err_message', 'سطح خدمت دارای سوال می باشد و قابل حذف نمی باشد');
            }
            $item->delete();
            return redirect()->back()->with('flash_message', 'سطح خدمت با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف سطح خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }
}


