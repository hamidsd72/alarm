<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Permission;
use App\Model\Role;
use App\Model\Setting;

class PermissionController extends Controller {

    function user_id() {
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            return auth()->user()->id;
        } else {
            return auth()->user()->reagent_id;
        }
    }

    public function controller_title($type) {
        if ($type == 'sum') {
            return 'مجوزهای دسترسی';
        } elseif ('single') {
            return 'مجوز دسترسی';
        }
    }

    public function controller_paginate() {
        return Setting::select('paginate')->latest()->firstOrFail->paginate;
    }

    public function __construct() {
        $this->middleware(['auth', 'SpecialUser']);
    }

    public function index() {
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            $items = Role::whereNotIn('name', ['مدیر','مدیر ارشد'])->whereIn('user_id',[ 1 , $this->user_id() ])->get();
            $permissions = Permission::where('user_id', auth()->user()->id)->get(['id','name','access']);
            return view('admin.permission.index', compact('items','permissions'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
        }
        abort(503);
    }

    public function store(Request $request) {
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            $access = array();
            if ($request->کاربران) { array_push($access, 'کاربران'); }
            if ($request->اعلانات) { array_push($access, 'اعلانات'); }
            if ($request->فعالیتها) { array_push($access, 'فعالیتها'); }
            if ($request->حسابداری) { array_push($access, 'حسابداری'); }
            if ($request->محتوا) { array_push($access, 'محتوا'); }
            if ($request->تنظیمات) { array_push($access, 'تنظیمات'); }

            $item = Permission::where('user_id',auth()->user()->id)->where('name', $request->role_name)->first();
            if ($item) {
                $item->access = implode(',',$access);
                $item->update();
            } else {
                $item           = new Permission();
                $item->user_id  = auth()->user()->id;
                $item->name     = $request->role_name;
                $item->access   = implode(',',$access);
                $item->save();
            }
            return redirect()->back()->with('flash_message', 'ویرایش دسترسی با موفقیت انجام شد');;
        }
        abort(503);
    }

    public function destroy($permission) {
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            Permission::where('user_id',auth()->user()->id)->findOrFail($permission)->delete();
            return redirect()->back()->with('flash_message', 'حذف دسترسی با موفقیت انجام شد');
        }
        abort(503);
    }

}