<?php

namespace App\Http\Controllers\Admin;
use App\User;
use Carbon\Carbon;
use App\Model\RollCall;
use App\Model\Setting;
use App\Http\Controllers\Controller;

class RollCallController extends Controller {
    public function controller_title($type) {
        if ($type == 'sum') {
            return 'حضور و غیاب کاربران';
        } elseif ('single') {
            return 'حضور و غیاب کاربر';
        }
    } 
    public function controller_paginate() {
        return Setting::select('paginate')->where('user_id', $this->user_id())->first()->paginate;
    }
    function persianStartOfMonth() {
        return Carbon::now()->subDay( my_jdate(Carbon::now(), 'd') - 1 );
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
        $items = RollCall::where('reagent_id', $this->user_id())->orderByDesc('id')->paginate($this->controller_paginate());
        // محاسبه ساعت کاری روز فرد
        foreach ($items as $item) {
            $item->reagent_id = $item->created_at->diffInMinutes($item->updated_at, false);
        }

        // گروه بندی به ترتیب روزهای شمسی
        foreach ($items->where('created_at','<',$this->persianStartOfMonth()) as $item) {
            $item->text = 'بیش از یک ماه قبل';
        }
        // این ماه
        foreach ($items->where('created_at','>',$this->persianStartOfMonth()) as $item) {
            $item->text = 'این ماه';
        }
        // این هفته
        foreach ($items->where('created_at','>',Carbon::now()->startOfWeek()->subDay(2)) as $item) {
            $item->text = 'این هفته';
        }
        // امروز
        foreach ($items->where('created_at','>',Carbon::now()->startOfDay()) as $item) {
            $item->text = 'امروز';
        }

        $users = User::where('reagent_id', $this->user_id() )->get(['id','first_name','last_name']);
        return view('admin.roll-call.index', compact('items','users'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function show($roll_call) {
        $id = $roll_call;
        $items = RollCall::where('reagent_id', $this->user_id())->where('user_id',$roll_call)->orderByDesc('id')->paginate($this->controller_paginate());
        foreach ($items as $item) {
            $item->reagent_id = $item->created_at->diffInMinutes($item->updated_at, false);
        }

        // گروه بندی به ترتیب روزهای شمسی
        foreach ($items->where('created_at','<',$this->persianStartOfMonth()) as $item) {
            $item->text = 'بیش از یک ماه قبل';
        }
        // این ماه
        foreach ($items->where('created_at','>',$this->persianStartOfMonth()) as $item) {
            $item->text = 'این ماه';
        }
        // این هفته
        foreach ($items->where('created_at','>',Carbon::now()->startOfWeek()->subDay(2)) as $item) {
            $item->text = 'این هفته';
        }
        // امروز
        foreach ($items->where('created_at','>',Carbon::now()->startOfDay()) as $item) {
            $item->text = 'امروز';
        }

        $users = User::where('reagent_id', $this->user_id() )->get(['id','first_name','last_name']);
        return view('admin.roll-call.index', compact('id','items','users'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    // public function edit($id) {
    //     $item = Request::where('reagent_id', $this->user_id())->findOrFail($id);
    //     $items = User::where('reagent_id', $this->user_id() )->get(['id','first_name','last_name']);
    //     return view('admin.roll-call.edit', compact('item','items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum') ]);
    // }
}


