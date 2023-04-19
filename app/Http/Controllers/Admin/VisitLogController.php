<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\Visit;
use App\Model\Meta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;


class VisitLogController extends Controller {
    public function controller_title($type) {
        if ($type == 'sum') {
            return 'ردیابی کارمندان';
        } elseif ('single') {
            return 'ردیابی کارمند';
        }
    }

    public function controller_paginate() {
        return Setting::select('paginate')->where('user_id', $this->user_id())->first()->paginate;
    }

    function user_id() {
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            return auth()->user()->id;
        } else {
            return auth()->user()->reagent_id;
        }
    }

    public function __construct() {
        $this->middleware(['auth', 'SpecialUser','isAdmin','Access']);
    }

    public function index() {
        $items = Visit::where('reagent_id', $this->user_id() )->paginate($this->controller_paginate());
        $users = User::where('reagent_id', $this->user_id() )->get(['id','first_name','last_name']);
        return view('admin.visit_logs.index', compact('users','items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }

    public function show($id) {
        $items = Visit::where('reagent_id', $this->user_id() )->where('user_id', $id )->paginate($this->controller_paginate());
        $users = User::where('reagent_id', $this->user_id() )->get(['id','first_name','last_name']);
        return view('admin.visit_logs.index', compact('id','users','items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }

    public function edit($id) {
        $user = User::where('reagent_id', $this->user_id() )->where('id', $id)->firstOrFail('id');

        try {
            Visit::create([ 'reagent_id' => $this->user_id(),'user_id' => $user->id ]);
            return redirect()->back()->withInput()->with('flash_message', 'درخواست انجام شد');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در عملیات بوجود آمده،مجددا تلاش کنید');
        }
        
    }

}


