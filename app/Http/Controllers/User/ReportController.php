<?php

namespace App\Http\Controllers\User;
use App\User;
use Carbon\Carbon;
use App\Model\LeaveDay;
use App\Model\RollCall;
use App\Model\ServicePackage;
use App\Model\Setting;
use App\Http\Controllers\Controller;

class ReportController extends Controller {
    public function __construct() {
        $this->middleware('auth');
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
    public function show($id) {

        if ($id=='rollCall') {
            $items = RollCall::where('user_id',auth()->user()->id)->orderByDesc('id')->get();
            foreach ($items as $item) {
                $item->reagent_id = $item->created_at->diffInMinutes($item->updated_at, false);
            }
            // سه ماه گذشته
            $treeMonth = $items->where('created_at','>',Carbon::now()->startOfMonth()->subMonth(3))->sum('reagent_id');
            // این ماه
            $Month = $items->where('created_at','>',Carbon::now()->startOfMonth())->sum('reagent_id');
            // این هفته
            $week = $items->where('created_at','>',Carbon::now()->startOfWeek())->sum('reagent_id');
            // امروز
            $today = $items->where('created_at','>',Carbon::now()->startOfDay())->sum('reagent_id');
            return view('user.reports.show', compact('id','treeMonth','Month','week','today'), ['title1' => 'گزارش کارکرد اخیر', 'title2' => 'گزارش کارکرد های اخیر']);
        } elseif ($id=='job') {
            $items  = ServicePackage::where('created_at', '<', Carbon::now()->startOfMonth()->subMonth())->where('user_id', auth()->user()->id)->orderByDesc('sort_by')->get();
            return view('user.reports.show', compact('id','items'), ['title1' => 'گزارش فعالیت اخیر', 'title2' => 'گزارش فعالیت های اخیر']);
        } elseif ($id=='leave-day') {
            $items = LeaveDay::where('reagent_id', $this->user_id() )->where('user_id',auth()->user()->id)->get();
            return view('user.reports.show', compact('id','items'), ['title1' => 'گزارش مرخصی اخیر', 'title2' => 'گزارش مرخصی های اخیر']);
        }
        
        abort('503');

    }
}


