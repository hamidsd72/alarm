<?php

namespace App\Http\Controllers\User;
use App\User;
use App\Model\ServicePackage;
use App\Model\JobReport;
use App\Model\Setting;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobReportController extends Controller {
    public function controller_title($type) {
        if ($type == 'sum') {
            return 'گزارش فعالیت ها';
        } elseif ('single') {
            return 'گزارش فعالیت';
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
    public function show($id) {
        $item   = User::findOrFail(auth()->user()->id);
        $items  = ServicePackage::where('reagent_id', $this->user_id())->where('user_id', auth()->user()->id)->orderByDesc('sort_by')->paginate($this->controller_paginate());
        return view('user.job-report.show', compact('item','items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum') ]);
    }
    public function edit($id) {
        $item = ServicePackage::where('user_id',auth()->user()->id)->where('reagent_id', $this->user_id())->findOrFail($id);
        $items = JobReport::where('user_id',auth()->user()->id)->where('time', '>', 0 )->where('job_id', $id )->orderByDesc('created_at')->paginate($this->controller_paginate());
        return view('user.job-report.edit', compact('item','items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum') ]);
    }
    public function map($id) {
        $item = JobReport::where('user_id',auth()->user()->id)->findOrFail($id);
        $lat = explode(',',$item->location)[0];
        $lng = explode(',',$item->location)[1];
        $map_api_key = Setting::first('map_api_key')->map_api_key;
        return view('user.map', compact('lat','lng','map_api_key'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum') ]);
    }
}


