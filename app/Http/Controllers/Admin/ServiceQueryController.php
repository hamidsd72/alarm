<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\Service;
use App\Model\ServiceLevel;
use App\Model\ServiceQuery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ServiceQueryController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return 'سوالات';
        } elseif ('single') {
            return ' سوال';
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

    public function index($l_id)
    {
//        dd("dfdsf");
        $level = ServiceLevel::find($l_id);
        $items = ServiceQuery::where('level_id',$l_id)->paginate($this->controller_paginate());
        $title=$level?$level->title:'';
        $title1=$level->service?$level->service->title:'';
        return view('admin.service.level.question.index', compact('items','level'), ['title1' => 'خدمات', 'title2' => 'لیست سوالات سطح : '.$title.'، خدمت : '.$title1]);
    }

    public function create($l_id)
    {
        $level = ServiceLevel::find($l_id);
        $title=$level?$level->title:'';
        $title1=$level->service?$level->service->title:'';
        return view('admin.service.level.question.create',compact('level'), ['title1' => 'خدمات', 'title2' => 'افزودن سوال سطح : '.$title.'، خدمت : '.$title1]);
    }

    public function store(Request $request,$l_id)
    {
        $this->validate($request, [
            'question' => 'required',
            'reply1' => 'required|max:255',
            'reply2' => 'required|max:255',
            'reply3' => 'required|max:255',
            'reply4' => 'required|max:255',
            'reply_true' => 'required',
        ],
            [
                'question.required' => 'لطفا سوال را وارد کنید',
                'reply1.required' => 'لطفا پاسخ 1 را وارد کنید',
                'reply1.max' => 'پاسخ 1 نباید بیشتر از 255 کاراکتر باشد',
                'reply2.required' => 'لطفا پاسخ 2 را وارد کنید',
                'reply2.max' => 'پاسخ 2 نباید بیشتر از 255 کاراکتر باشد',
                'reply3.required' => 'لطفا پاسخ 3 را وارد کنید',
                'reply3.max' => 'پاسخ 3 نباید بیشتر از 255 کاراکتر باشد',
                'reply4.required' => 'لطفا پاسخ 4 را وارد کنید',
                'reply4.max' => 'پاسخ 4 نباید بیشتر از 255 کاراکتر باشد',
                'reply_true.required' => 'لطفا پاسخ صحیح را مشخص کنید',
            ]);
        try {
            $level=ServiceLevel::find($l_id);
            $item = new ServiceQuery();
            $item->question = $request->question;
            $item->reply1 = $request->reply1;
            $item->reply2 = $request->reply2;
            $item->reply3 = $request->reply3;
            $item->reply4 = $request->reply4;
            $item->reply_true = $request->reply_true;
            $item->level_id = $l_id;
            $item->service_id = $level->service_id;
            $item->save();

            return redirect()->route('admin.service.query.list',$l_id)->with('flash_message', ' سوال با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد سوال بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function edit($id)
    {
        $item = ServiceQuery::find($id);
        $title=$item->level?$item->level->title:'';
        $title1=$item->service?$item->service->title:'';
        return view('admin.service.level.question.edit', compact('item'), ['title1' => 'خدمات', 'title2' => 'ویرایش سوال سطح : '.$title.'، خدمت : '.$title1]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'question' => 'required',
            'reply1' => 'required|max:255',
            'reply2' => 'required|max:255',
            'reply3' => 'required|max:255',
            'reply4' => 'required|max:255',
            'reply_true' => 'required',
        ],
            [
                'question.required' => 'لطفا سوال را وارد کنید',
                'reply1.required' => 'لطفا پاسخ 1 را وارد کنید',
                'reply1.max' => 'پاسخ 1 نباید بیشتر از 255 کاراکتر باشد',
                'reply2.required' => 'لطفا پاسخ 2 را وارد کنید',
                'reply2.max' => 'پاسخ 2 نباید بیشتر از 255 کاراکتر باشد',
                'reply3.required' => 'لطفا پاسخ 3 را وارد کنید',
                'reply3.max' => 'پاسخ 3 نباید بیشتر از 255 کاراکتر باشد',
                'reply4.required' => 'لطفا پاسخ 4 را وارد کنید',
                'reply4.max' => 'پاسخ 4 نباید بیشتر از 255 کاراکتر باشد',
                'reply_true.required' => 'لطفا پاسخ صحیح را مشخص کنید',
            ]);
        $item = ServiceQuery::find($id);
        try {
            $item->question = $request->question;
            $item->reply1 = $request->reply1;
            $item->reply2 = $request->reply2;
            $item->reply3 = $request->reply3;
            $item->reply4 = $request->reply4;
            $item->reply_true = $request->reply_true;
            $item->update();
            return redirect()->route('admin.service.query.list',$item->level_id)->with('flash_message', 'سوال با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش سوال بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function destroy($id)
    {
        $item = ServiceQuery::find($id);
        try {
            $item->delete();
            return redirect()->back()->with('flash_message', 'سوال با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف سوال بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function active($id, $type)
    {
        $item = ServiceQuery::find($id);
        try {
            $item->status = $type;
            $item->update();
            if ($type == 'pending') {
                return redirect()->back()->with('flash_message', 'نمایش سوال با موفقیت غیرفعال شد.');
            }
            if ($type == 'active') {
                return redirect()->back()->with('flash_message', 'نمایش سوال با موفقیت فعال شد.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در تغییر وضعیت سوال بوجود آمده،مجددا تلاش کنید');
        }
    }
}


