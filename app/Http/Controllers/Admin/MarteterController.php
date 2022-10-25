<?php

namespace App\Http\Controllers\Admin;

use App\Model\Setting;
use App\Model\Agent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MarteterController extends Controller {
    public function controller_title($type) {
        if ($type == 'sum') {
            return 'لیست مشتریان ها';
        } elseif ('single') {
            return 'مشتریان';
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
        $items = Agent::where('user_id', $this->user_id())->paginate($this->controller_paginate());
        return view('admin.user.marketer.index', compact('items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function show($id) {
        $item = Agent::where('user_id', $this->user_id())->findOrFail($id);
        return view('admin.user.marketer.show', compact('item'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function create() {
        $map_api_key = Setting::first('map_api_key')->map_api_key;
        $lat = '35.73249';
        $lng = '51.42268';
        return view('admin.user.marketer.create',compact('map_api_key','lat','lng'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function store(Request $request) {
        $this->validate($request, [
            'city'          => 'required|max:240',
            'locate'        => 'required|max:240',
            'first_name'    => 'required|max:240',
            'last_name'     => 'required|max:240',
            'address'       => 'required|max:240',
            'company_name'  => 'required|max:240',
            'mobile'        => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric',
            'phone'         => 'required|regex:/(0)[0-9]{10}/|digits:11|numeric',
            'text'          => 'max:1000',
            'long_lat'      => 'max:40',
        ],
            [
                'city.required'         => 'لطفا شهر را وارد کنید',
                'city.max'              => 'شهر نباید بیشتر از 240 کاراکتر باشد',
                'locate.required'       => 'لطفا منطقه را وارد کنید',
                'locate.max'            => 'منطقه نباید بیشتر از 240 کاراکتر باشد',
                'first_name.required'   => 'لطفا نام را وارد کنید',
                'first_name.max'        => 'نام نباید بیشتر از 240 کاراکتر باشد',
                'last_name.required'    => 'لطفا نام خانوادگی را وارد کنید',
                'last_name.max'         => 'نام خانوادگی نباید بیشتر از 240 کاراکتر باشد',
                'address.required'      => 'لطفا آدرس را وارد کنید',
                'address.max'           => 'آدرس نباید بیشتر از 240 کاراکتر باشد',
                'company_name.required' => 'لطفا نوع قرارداد را وارد کنید',
                'company_name.max'      => 'نوع قرارداد نباید بیشتر از 240 کاراکتر باشد',
                'mobile.required'       => 'لطفا موبایل را وارد کنید',
                'mobile.regex'          => 'لطفا موبایل را وارد کنید',
                'mobile.digits'         => 'لطفا فرمت موبایل را رعایت کنید',
                'mobile.numeric'        => 'لطفا موبایل خود را بصورت عدد وارد کنید',
                'phone.required'        => 'لطفا تلفن را وارد کنید',
                'phone.regex'           => 'لطفا تلفن را وارد کنید',
                'phone.digits'          => 'لطفا فرمت تلفن را رعایت کنید',
                'phone.numeric'         => 'لطفا تلفن خود را بصورت عدد وارد کنید',
                'text.max'              => 'توضیحات حداکثر ۱۰۰۰ کاراکتر باشد',
                'long_lat.max'          => 'مختصات حداکثر ۴۰ کاراکتر باشد',
            ]);
        try {
            $item = new Agent();
            $item->user_id      = $this->user_id();
            $item->city         = $request->city;
            $item->locate       = $request->locate;
            $item->first_name   = $request->first_name;
            $item->last_name    = $request->last_name;
            $item->address      = $request->address;
            $item->company_name = $request->company_name;
            $item->mobile       = $request->mobile;
            $item->phone        = $request->phone;
            $item->text         = $request->text;
            $item->long_lat     = $request->long_lat;
            $item->save();
            return redirect()->route('admin.marketer.list')->with('flash_message', 'مشتری با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد مشتری بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function edit($id) {
        $item = Agent::where('user_id', $this->user_id())->findOrFail($id);
        $map_api_key = Setting::first('map_api_key')->map_api_key;
        $lat = '35.73249';
        $lng = '51.42268';
        if ($item&&$item->long_lat) {
            $lat = explode(',',$item->long_lat)[0];
            $lng = explode(',',$item->long_lat)[1];
        }
        return view('admin.user.marketer.edit', compact('item','map_api_key','lat','lng'), ['title1' => 'کاربران', 'title2' => 'ویرایش باراریاب']);
    }
    public function update(Request $request, $id) {
        $this->validate($request, [
            'city'          => 'required|max:240',
            'locate'        => 'required|max:240',
            'first_name'    => 'required|max:240',
            'last_name'     => 'required|max:240',
            'address'       => 'required|max:240',
            'company_name'  => 'required|max:240',
            'mobile'        => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric',
            'phone'         => 'required|regex:/(0)[0-9]{10}/|digits:11|numeric',
            'text'          => 'max:1000',
            'long_lat'      => 'max:255',
        ],
            [
                'city.required'         => 'لطفا شهر را وارد کنید',
                'city.max'              => 'شهر نباید بیشتر از 240 کاراکتر باشد',
                'locate.required'       => 'لطفا منطقه را وارد کنید',
                'locate.max'            => 'منطقه نباید بیشتر از 240 کاراکتر باشد',
                'first_name.required'   => 'لطفا نام را وارد کنید',
                'first_name.max'        => 'نام نباید بیشتر از 240 کاراکتر باشد',
                'last_name.required'    => 'لطفا نام خانوادگی را وارد کنید',
                'last_name.max'         => 'نام خانوادگی نباید بیشتر از 240 کاراکتر باشد',
                'address.required'      => 'لطفا آدرس را وارد کنید',
                'address.max'           => 'آدرس نباید بیشتر از 240 کاراکتر باشد',
                'company_name.required' => 'لطفا نوع قرارداد را وارد کنید',
                'company_name.max'      => 'نوع قرارداد نباید بیشتر از 240 کاراکتر باشد',
                'mobile.required'       => 'لطفا موبایل را وارد کنید',
                'mobile.regex'          => 'لطفا موبایل را وارد کنید',
                'mobile.digits'         => 'لطفا فرمت موبایل را رعایت کنید',
                'mobile.numeric'        => 'لطفا موبایل خود را بصورت عدد وارد کنید',
                'phone.required'        => 'لطفا تلفن را وارد کنید',
                'phone.regex'           => 'لطفا تلفن را وارد کنید',
                'phone.digits'          => 'لطفا فرمت تلفن را رعایت کنید',
                'phone.numeric'         => 'لطفا تلفن خود را بصورت عدد وارد کنید',
                'text.max'              => 'توضیحات حداکثر ۱۰۰۰ کاراکتر باشد',
                'long_lat.max'          => 'مختصات حداکثر ۲۵۵ کاراکتر باشد',
            ]);
        $item = Agent::where('user_id', $this->user_id())->findOrFail($id);
        try {
            $item->city         = $request->city;
            $item->locate       = $request->locate;
            $item->first_name   = $request->first_name;
            $item->last_name    = $request->last_name;
            $item->address      = $request->address;
            $item->company_name = $request->company_name;
            $item->mobile       = $request->mobile;
            $item->phone        = $request->phone;
            $item->text         = $request->text;
            $item->long_lat     = $request->long_lat;
            $item->update();
            return redirect()->route('admin.marketer.list')->with('flash_message', 'مشتری با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش مشتری بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function destroy($id) {
        Agent::where('user_id', $this->user_id())->findOrFail($id)->delete();
        return redirect()->back()->with('flash_message', 'بازاریاب با موفقیت حذف شد.');
    }
    public function re_activate($id) {
        $item = Agent::where('user_id', $this->user_id())->findOrFail($id);
        if ($item->status=='pending') {
            $item->status = 'active';
        } else {
            $item->status = 'pending';
        }
        $item->save();
        return redirect()->back()->with('flash_message', 'وضعیت مشتری با موفقیت تغییر کرد');
    }
}


