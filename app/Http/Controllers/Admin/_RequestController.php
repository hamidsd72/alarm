<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Model\Request;
use App\Model\Setting;
use App\Http\Controllers\Controller;

class JobReportController extends Controller {
    public function controller_title($type) {
        if ($type == 'sum') {
            return 'ثبت درخواست ها';
        } elseif ('single') {
            return 'ثبت درخواست';
        }
    } 
    public function controller_paginate() {
        return Setting::select('paginate')->where('user_id', $this->user_id())->first()->paginate;
    }
    public function __construct() {
        $this->middleware('auth');
    }
    function user_id() {
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            return auth()->user()->id;
        } else {
            return auth()->user()->reagent_id;
        }
    }
    public function index() {
        $items = Request::where('reagent_id', $this->user_id() )->orderByDesc('id')->paginate($this->controller_paginate());
        return view('admin.request.index', compact('items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function create() {
        $items = User::where('reagent_id', $this->user_id() )->get('id','first_name','last_name');
        return view('admin.request.create', compact('items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum') ]);
    }
    public function store(Request $request) {
        $this->validate($request, [
            'user_id'       => 'required',
            'title'         => 'required|max:255',
            'description'   => 'required|max:2500'
        ],[
            'user_id.required' => 'لطفا نام کاربر را انتخاب کنید',
            'title.required' => 'لطفا عنوان را وارد کنید',
            'title.max' => 'عنوان نباید بیشتر از ۲۵۵ کاراکتر باشد',
            'description.required' => 'لطفا توضیحات را وارد کنید',
            'description.max' => 'توضیحات نباید بیشتر از ۲۵۰۰ کاراکتر باشد'
        ]);
        User::where('reagent_id', $this->user_id() )->where('id',$request->user_id)->firstOrFail();
        try {
            $item = new Request();
            $item->user_id      = $request->user_id;
            $item->title        = $request->title;
            $item->description  = $request->description;
            $item->employee_id  = auth()->user()->id;
            $item->reagent_id   = $this->user_id();
            $item->save();
            return redirect()->route('admin.request.index')->with('flash_message', 'درخواست با موفقیت ثبت شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ثبت درخواست بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function edit($id) {
        $item = Request::where('reagent_id', $this->user_id())->findOrFail($id);
        $items = User::where('reagent_id', $this->user_id() )->get('id','first_name','last_name');
        return view('admin.request.edit', compact('item','items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum') ]);
    }
    public function update(Request $request, $id) {
        $this->validate($request, [
            'title'         => 'required|max:255',
            'description'   => 'required|max:2500'
        ],[
            'title.required' => 'لطفا عنوان را وارد کنید',
            'title.max' => 'عنوان نباید بیشتر از ۲۵۵ کاراکتر باشد',
            'description.required' => 'لطفا توضیحات را وارد کنید',
            'description.max' => 'توضیحات نباید بیشتر از ۲۵۰۰ کاراکتر باشد'
        ]);
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            $item = Request::where('reagent_id', $this->user_id() )->findOrFail($id);
        } else {
            $item = Request::where('reagent_id', $this->user_id() )->where('employee_id', auth()->user()->id)->findOrFail($id);
        }
        try {
            $item->title        = $request->title;
            $item->description  = $request->description;
            $item->update();
            return redirect()->route('admin.request.index')->with('flash_message', 'درخواست با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش درخواست بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function destroy($id) {
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            $item = Request::where('reagent_id', $this->user_id() )->findOrFail($id);
        } else {
            $item = Request::where('reagent_id', $this->user_id() )->where('employee_id', auth()->user()->id)->findOrFail($id);
        }
        try {
            $item->delete();
            return redirect()->route('admin.request.index')->with('flash_message', 'درخواست با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف درخواست بوجود آمده،مجددا تلاش کنید');
        }
    }
}


