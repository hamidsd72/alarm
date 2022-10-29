<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\LeaveDay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaveDayController extends Controller {
    public function controller_title($type) {
        if ($type == 'sum') {
            return 'مرخصی ها';
        } elseif ('single') {
            return 'مرخصی';
        }
    }
    function user_id() {
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            return auth()->user()->id;
        } else {
            return auth()->user()->reagent_id;
        }
    }
    public function toEnNumber($input) {
        $replace_pairs = array(
              '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
              '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'
        );
        
        return strtr( $input, $replace_pairs );
    }
    public function controller_paginate() {
        return Setting::select('paginate')->where('user_id', $this->user_id())->first()->paginate;
    }
    public function __construct() {
        $this->middleware('auth');
    }
    public function index() {
        $users = User::where('reagent_id', $this->user_id() )->get(['id','first_name','last_name']);
        $items = LeaveDay::where('reagent_id', $this->user_id() )->paginate($this->controller_paginate());
        return view('admin.leave_days.index', compact('items','users'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function show($id) {
        $users = User::where('reagent_id', $this->user_id() )->get(['id','first_name','last_name']);
        $items = LeaveDay::where('reagent_id', $this->user_id() )->where('user_id',$id)->paginate($this->controller_paginate());
        return view('admin.leave_days.index', compact('items','users'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function create() {
        $users = User::where('reagent_id', $this->user_id() )->get(['id','first_name','last_name']);
        return view('admin.leave_days.create', compact('users'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function edit($id) {
        $item = LeaveDay::where('reagent_id', $this->user_id() )->findOrFail($id);
        $users = User::where('reagent_id', $this->user_id() )->get(['id','first_name','last_name']);
        return view('admin.leave_days.edit', compact('item','users'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function store(Request $request) {
        $this->validate($request, [
            'text' => 'required|max:240',
            'count'  => 'required|integer',
            'user_id'  => 'required|integer',
            'start_at'  => 'required|max:40',
            'end_at'  => 'required|max:40',
        ],
            [
                'user_id.required' => 'لطفا آی دی کاربر را وارد کنید',
                'user_id.max' => 'آی دی کاربر را به عدد لاتین وارد کنید',
                'text.required' => 'لطفا توضیحات را وارد کنید',
                'text.max' => 'توضیحات نباید بیشتر از 240 کاراکتر باشد',
                'count.required' => 'لطفا تعداد روز مرخصی را وارد کنید',
                'count.integer' => 'روز مرخصی را به عدد لاتین وارد کنید',
                'start_at.required' => 'لطفا تاریخ شروع مرخصی را وارد کنید',
                'start_at.max' => 'تاریخ شروع مرخصی نباید بیشتر از 40 کاراکتر باشد',
                'end_at.required' => 'لطفا تاریخ پایان مرخصی را وارد کنید',
                'end_at.max' => 'تاریخ پایان مرخصی نباید بیشتر از 40 کاراکتر باشد',
            ]);
        try {
            $user = User::where('reagent_id', $this->user_id() )->findOrFail($request->user_id);

            $item = new LeaveDay();
            $item->reagent_id   = $this->user_id();
            $item->employee_id  = auth()->user()->id;
            $item->user_id      = $user->id;
            $item->count        = $request->count;
            $item->text         = $request->text;
            $item->start_at     = j2g($this->toEnNumber($request->start_at));
            $item->end_at       = j2g($this->toEnNumber($request->end_at));
            $item->save();
            return redirect()->route('admin.leave-day.index')->with('flash_message', ' مرخصی کاربر با موفقیت اضافه شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در افزودن بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function destroy($id) {
        if ( auth()->user()->hasRole('مدیر') ) {
            LeaveDay::where('reagent_id', $this->user_id() )->findOrFail($id)->delete();
        } else {
            $item = LeaveDay::where('reagent_id', $this->user_id() )->where('employee_id', auth()->user()->id)->find($id);
            if (!$item) {
                return redirect()->back()->withInput()->with('err_message', 'مرخصی توسط شخص دیگری ثبت شده شما دسترسی به حذف آن را ندارید');
            }
            $item->delete();
        }
        return redirect()->back()->withInput()->with('flash_message', ' مرخصی کاربر با موفقیت حذف اضافه شد.');
    }
    public function update(Request $request, $id) {
        $this->validate($request, [
            'text' => 'required|max:240',
            'count'  => 'required|integer',
            'user_id'  => 'required|integer',
            'start_at'  => 'required|max:40',
            'end_at'  => 'required|max:40',
        ],
            [
                'user_id.required' => 'لطفا آی دی کاربر را وارد کنید',
                'user_id.max' => 'آی دی کاربر را به عدد لاتین وارد کنید',
                'text.required' => 'لطفا توضیحات را وارد کنید',
                'text.max' => 'توضیحات نباید بیشتر از 240 کاراکتر باشد',
                'count.required' => 'لطفا تعداد روز مرخصی را وارد کنید',
                'count.integer' => 'روز مرخصی را به عدد لاتین وارد کنید',
                'start_at.required' => 'لطفا تاریخ شروع مرخصی را وارد کنید',
                'start_at.max' => 'تاریخ شروع مرخصی نباید بیشتر از 40 کاراکتر باشد',
                'end_at.required' => 'لطفا تاریخ پایان مرخصی را وارد کنید',
                'end_at.max' => 'تاریخ پایان مرخصی نباید بیشتر از 40 کاراکتر باشد',
            ]);
        try {
            $user = User::where('reagent_id', $this->user_id() )->findOrFail($request->user_id);

            if ( auth()->user()->hasRole('مدیر') ) {
                $item = LeaveDay::where('reagent_id', $this->user_id() )->findOrFail($id);
            } else {
                $item = LeaveDay::where('reagent_id', $this->user_id() )->where('employee_id', auth()->user()->id)->find($id);
                if (!$item) {
                    return redirect()->back()->withInput()->with('err_message', 'مرخصی توسط شخص دیگری ثبت شده شما دسترسی به تغییر آن را ندارید');
                }
            }

            $item->user_id  = $user->id;
            $item->count    = $request->count;
            $item->text     = $request->text;
            $item->start_at = j2g($this->toEnNumber($request->start_at));
            $item->end_at   = j2g($this->toEnNumber($request->end_at));
            $item->update();
            return redirect()->back()->withInput()->with('flash_message', ' مرخصی کاربر با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش بوجود آمده،مجددا تلاش کنید');
        }
    }
}

