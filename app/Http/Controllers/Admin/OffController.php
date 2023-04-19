<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\OffCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class OffController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return ' لیست کد تخفیف';
        } elseif ('single') {
            return ' کد تخفیف';
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

    public function index()
    {
        $items = OffCode::orderBy('id','desc')->paginate($this->controller_paginate());
        
        return view('admin.content.off.index', compact('items'), ['title1' => 'محتوا سایت', 'title2' => $this->controller_title('sum')]);
    }

    public function create()
    {
        $users=User::orderBy('id','asc')->get();
        return view('admin.content.off.create',compact('users'), ['title1' => 'محتوا سایت', 'title2' => 'افزودن کد تخفیف']);
    }

    public function store(Request $request)
    {
        $max = User::orderBy('id', 'asc')->count();
        if ($request->user_id == 0)
        {
            $this->validate($request, [
                'title' => 'required|max:240',
                'code' => 'required|between:5,10|regex:/(^([a-zA-Z0-9]+)(\d+)?$)/u|unique:off_codes',
                'percent' => 'required|integer|between:1,100',
                'inventory' => 'required|integer|between:1,'.$max,
            ],
                [
                    'title.required' => 'لطفا عنوان کد تخفیف را وارد کنید',
                    'title.max' => 'عنوان کد تخفیف  نباید بیشتر از 240 کاراکتر باشد',
                    'code.required' => 'لطفا کد تخفیف را وارد کنید',
                    'code.between' => 'کد تخفیف 5الی10 کاراکتر باشد ',
                    'code.regex' => 'کد تخفیف شامل حروف کوچک و بزرگ انگلیسی و اعداد می باشد ',
                    'code.unique' => ' کد تخفیف نباید تکراری باشد',
                    'percent.required' => 'لطفا درصد تخفیف را وارد کنید',
                    'percent.between' => 'درصد تخفیف بین 1الی100 باشد ',
                    'inventory.required' => 'لطفا تعداد را وارد کنید',
                    'inventory.between' => 'تعداد اعتبار بین 1الی تعداد کاربران باشد: تعداد کاربران '.$max,
                ]);
        }
        else {
            $this->validate($request, [
                'title' => 'required|max:240',
                'code' => 'required|between:5,10|regex:/(^([a-zA-Z0-9]+)(\d+)?$)/u|unique:off_codes',
                'percent' => 'required|integer|between:1,100',
            ],
                [
                    'title.required' => 'لطفا عنوان کد تخفیف را وارد کنید',
                    'title.max' => 'عنوان کد تخفیف  نباید بیشتر از 240 کاراکتر باشد',
                    'code.required' => 'لطفا کد تخفیف را وارد کنید',
                    'code.between' => 'کد تخفیف 5الی10 کاراکتر باشد ',
                    'code.regex' => 'کد تخفیف شامل حروف کوچک و بزرگ انگلیسی و اعداد می باشد ',
                    'code.unique' => ' کد تخفیف نباید تکراری باشد',
                    'percent.required' => 'لطفا درصد تخفیف را وارد کنید',
                    'percent.between' => 'درصد تخفیف بین 1الی100 باشد ',
                ]);
        }

        try {
            $item = new OffCode();
            $item->title = $request->title;
            $item->user_id = $request->user_id;
            $item->code = $request->code;
            $item->percent = $request->percent;
            if ($request->user_id == 0)
            {
                $item->inventory=$request->inventory;
            }
            else {
                $item->inventory=1;
            }
            $item->save();
            return redirect()->route('admin.off.list')->with('flash_message', ' کد تخفیف با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد کد تخفیف بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function edit($id)
    {
        $item = OffCode::find($id);
        $users=User::orderBy('id','asc')->get();
        return view('admin.content.off.edit', compact('item','users'), ['title1' => 'محتوا سایت', 'title2' => 'ویرایش کد تخفیف']);
    }

    public function update(Request $request, $id)
    {
        $max = User::orderBy('id', 'asc')->count();
        if ($request->user_id == 0)
        {
            $this->validate($request, [
                'title' => 'required|max:240',
                'code' => 'required|between:5,10|regex:/(^([a-zA-Z0-9]+)(\d+)?$)/u|unique:off_codes,code,'.$id,
                'percent' => 'required|integer|between:1,100',
                'inventory' => 'required|integer|between:1,'.$max,
            ],
                [
                    'title.required' => 'لطفا عنوان کد تخفیف را وارد کنید',
                    'title.max' => 'عنوان کد تخفیف  نباید بیشتر از 240 کاراکتر باشد',
                    'code.required' => 'لطفا کد تخفیف را وارد کنید',
                    'code.between' => 'کد تخفیف 5الی10 کاراکتر باشد ',
                    'code.regex' => 'کد تخفیف شامل حروف کوچک و بزرگ انگلیسی و اعداد می باشد ',
                    'code.unique' => ' کد تخفیف نباید تکراری باشد',
                    'percent.required' => 'لطفا درصد تخفیف را وارد کنید',
                    'percent.between' => 'درصد تخفیف بین 1الی100 باشد ',
                    'inventory.required' => 'لطفا تعداد را وارد کنید',
                    'inventory.between' => 'تعداد اعتبار بین 1الی تعداد کاربران باشد: تعداد کاربران '.$max,
                ]);
        }
        else {
            $this->validate($request, [
                'title' => 'required|max:240',
                'code' => 'required|between:5,10|regex:/(^([a-zA-Z0-9]+)(\d+)?$)/u|unique:off_codes,code,'.$id,
                'percent' => 'required|integer|between:1,100',
            ],
                [
                    'title.required' => 'لطفا عنوان کد تخفیف را وارد کنید',
                    'title.max' => 'عنوان کد تخفیف  نباید بیشتر از 240 کاراکتر باشد',
                    'code.required' => 'لطفا کد تخفیف را وارد کنید',
                    'code.between' => 'کد تخفیف 5الی10 کاراکتر باشد ',
                    'code.regex' => 'کد تخفیف شامل حروف کوچک و بزرگ انگلیسی و اعداد می باشد ',
                    'code.unique' => ' کد تخفیف نباید تکراری باشد',
                    'percent.required' => 'لطفا درصد تخفیف را وارد کنید',
                    'percent.between' => 'درصد تخفیف بین 1الی100 باشد ',
                ]);
        }
        $item = OffCode::find($id);
        try {
            $item->title = $request->title;
            $item->user_id = $request->user_id;
            $item->code = $request->code;
            $item->percent = $request->percent;
            if ($request->user_id == 0)
            {
                $item->inventory=$request->inventory;
            }
            else {
                $item->inventory=1;
            }
            $item->update();
            return redirect()->route('admin.off.list')->with('flash_message', 'کد تخفیف با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش کد تخفیف بوجود آمده،مجددا تلاش کنید');
        }
    }

    public function destroy($id)
    {
        $item = OffCode::find($id);
        try {
            $item->delete();
            return redirect()->back()->with('flash_message', 'کد تخفیف با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف کد تخفیف بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function active($id, $type)
    {
        $item = OffCode::find($id);
        try {
            $item->status = $type;
            $item->update();
            return redirect()->back()->with('flash_message', 'تغییر وضعیت کد تخفیف با موفقیت انجام شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در تغییر وضعیت کد تخفیف بوجود آمده،مجددا تلاش کنید');
        }
    }

}


