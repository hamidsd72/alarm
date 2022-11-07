<?php

namespace App\Http\Controllers\User;
use App\User;
use Carbon\Carbon;
use App\Model\LeaveDay;
use App\Model\RollCall;
use App\Model\ServicePackage;
use App\Model\Setting;
use App\Model\OffDay;
use App\Http\Controllers\Controller;

class ReportController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }
    function persianStartOfMonth() {
        return Carbon::now()->subDay( my_jdate(Carbon::now(), 'd') - 1 );
    }
    function persianEndOfMonth() {
        $firstOfMonth = $this->persianStartOfMonth();
        $month = my_jdate(Carbon::now(), 'm');


        if ($month == 12) {
            $endOfMonth = $firstOfMonth->addDay(29);
        } elseif ($month < 12 && $month > 6) {
            $endOfMonth = $firstOfMonth->addDay(30);
        } else {
            $endOfMonth = $firstOfMonth->addDay(31);
        }

        if ($month < my_jdate($endOfMonth, 'm')) {
            return $endOfMonth;
        }
        // برای سال کبیسه
        return $endOfMonth->addDay();
    }
    public function controller_paginate() {
        return Setting::select('paginate')->where('user_id', $this->user_id())->first()->paginate;
    }
    public function toEnNumber($input) {
        $replace_pairs = array(
              '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
              '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'
        );
        
        return strtr( $input, $replace_pairs );
    }
    function user_id() {
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            return auth()->user()->id;
        } else {
            return auth()->user()->reagent_id;
        }
    }
    public function show($user_my_report) {

        if ($user_my_report=='rollCall') {
            // این فانکشن تغداد روزهای تعطیل این ماه را حساب میکند
            function offDayCount( $offDay , $month = null , $endOfMonth = null) {
                if ($month === null) $month = Carbon::today()->startOfMonth();
            
                if ($endOfMonth === null) {
                    $nextMonth   = $month->copy()->endOfMonth();
                } else {
                    $nextMonth   = $endOfMonth;
                }

                $offDaycount = 0;

                if ($offDay) {
                    foreach ($offDay as $weekName) {
                        switch ($weekName) {
                            case 'دوشنبه':
                                $offDaycount += $month->diffInDaysFiltered(function ($date) {
                                    return $date->isMonday();
                                }, $nextMonth);
                                break;
                            case 'سه‌شنبه':
                                $offDaycount += $month->diffInDaysFiltered(function ($date) {
                                    return $date->isTuesday();
                                }, $nextMonth);
                                break;
                            case 'چهارشنبه':
                                $offDaycount += $month->diffInDaysFiltered(function ($date) {
                                    return $date->isWednesday();
                                }, $nextMonth);
                                break;
                            case 'پنجشنبه':
                                $offDaycount += $month->diffInDaysFiltered(function ($date) {
                                    return $date->isThursday();
                                }, $nextMonth);
                                break;
                            case 'جمعه':
                                $offDaycount += $month->diffInDaysFiltered(function ($date) {
                                    return $date->isFriday();
                                }, $nextMonth);
                                break;
                            case 'شنبه':
                                $offDaycount += $month->diffInDaysFiltered(function ($date) {
                                    return $date->isSaturday();
                                }, $nextMonth);
                                break;
                            case 'یکشنبه':
                                $offDaycount += $month->diffInDaysFiltered(function ($date) {
                                    return $date->isSunday();
                                }, $nextMonth);
                                break;
                        }
                    }
                }

                return $offDaycount;
            }

            // حضور و غیاب روزانه
            $items = RollCall::where('user_id',auth()->user()->id)->where('created_at','>', $this->persianStartOfMonth())->orderByDesc('id')->get(['created_at','updated_at']);

            foreach ($items->where('created_at','>',Carbon::now()->startOfMonth()) as $item) {
                $item->title = 'این ماه';
            }
            foreach ($items->where('created_at','>',Carbon::now()->startOfWeek()->subDay(2)) as $item) {
                $item->title = 'این هفته';
            }
            foreach ($items->where('created_at','>',Carbon::now()->startOfDay()) as $item) {
                $item->title = 'امروز';
            }

            // روزهای تعطیل هفته
            $set = Setting::where('user_id', $this->user_id() )->first('off_day');
            $offDay = $set->off_day?explode(',',$set->off_day):false;

            // روزهای تعطیل مناسبتی
            $offDayCount = OffDay::where('user_id' , $this->user_id() )->where('created_at' , '>' , $this->persianStartOfMonth())->where('created_at' , '<' , $this->persianEndOfMonth())->count();
            $workDay     = $offDayCount + offDayCount($offDay , $this->persianStartOfMonth() , $this->persianEndOfMonth()) + $items->count();

            $month = my_jdate(Carbon::now(), 'm');
            if ($month == 12) {
                $workDay -= 29;
            } elseif ($month < 12 && $month > 6) {
                $workDay -= 30;
            } else {
                $workDay -= 31;
            }

            return view('user.reports.show', compact('items','user_my_report','workDay'), ['title1' => 'گزارش کارکرد اخیر', 'title2' => 'گزارش کارکرد های اخیر']);
        } elseif ($user_my_report=='job') {

            $items  = ServicePackage::where('created_at', '>', Carbon::now()->startOfMonth()->subMonth())->where('user_id', auth()->user()->id)->take(100)->orderByDesc('sort_by')->get(['id','title']);
            return view('user.reports.show', compact('user_my_report','items'), ['title1' => 'گزارش فعالیت اخیر', 'title2' => 'گزارش فعالیت های اخیر']);
        } elseif ($user_my_report=='leave-day') {

            $items = LeaveDay::where('created_at', '>', Carbon::now()->startOfYear())->where('reagent_id', $this->user_id() )->where('user_id',auth()->user()->id)->get(['count','start_at','end_at','text']);
            return view('user.reports.show', compact('user_my_report','items'), ['title1' => 'گزارش مرخصی اخیر', 'title2' => 'گزارش مرخصی های اخیر']);
        }
        
        abort('503');
    }

}

