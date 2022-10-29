<?php

namespace App\Http\Controllers\Admin;
use App\User;
use App\Model\TaskMaster;
use App\Model\Setting;
use App\Model\ServicePackage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskMasterController extends Controller {
    public function controller_title($type) {
        if ($type == 'sum') {
            return 'مدیریت سرپرست ها';
        } elseif ('single') {
            return 'مدیریت سرپرست';
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
        $items = User::role('سرپرست')->where('reagent_id', $this->user_id() )->paginate($this->controller_paginate());
        return view('admin.user.task_masters.index', compact('items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function store(Request $request) {
        $item = new TaskMaster();
        // try {
            $master_id   = User::role('سرپرست')->where('reagent_id', $this->user_id() )->where('id',$request->master_id)->firstOrFail();
            $employee_id = User::where('reagent_id', $this->user_id() )->where('id',$request->employee_id)->firstOrFail();

            $item->reagent_id = $this->user_id();
            $item->master_id = $master_id->id;
            $item->employee_id = $employee_id->id;
            $item->save();
            return redirect()->back()->withInput()->with('flash_message', 'آیتم با موفقیت به لیست سرپرست اضافه شد');
        // } catch (\Throwable $th) {
        //     return redirect()->back()->withInput()->with('err_message', 'مشکلی در عملیات بوجود آمده،مجددا تلاش کنید');
        // }
    }
    public function show($id) {
        $item  = User::role('سرپرست')->where('reagent_id', $this->user_id() )->findOrFail($id);
        $users = User::where('reagent_id', $this->user_id() )->where('id','!=',$id)->get(['id','first_name','last_name']);
        return view('admin.user.task_masters.show', compact('id','item','users'), ['title1' => $item->first_name.' '.$item->last_name, 'title2' => $this->controller_title('sum') ]);
    }
    public function destroy($id) {
        TaskMaster::where('reagent_id', $this->user_id() )->findOrFail($id)->delete();
        return redirect()->back()->withInput()->with('flash_message', 'آیتم با موفقیت از لیست سرپرست حذف شد');
    }
}


