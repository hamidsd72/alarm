<?php

namespace App\Http\Controllers\User;
use App\Model\Contact;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class TicketController extends Controller {
    public function __construct() {
       $this->middleware('auth');
    }  
    public function form_post(Request $request) {
        // validate
        if ($request->subject=='درخواست مرخصی' || $request->subject=='درخواست ثبت گزارش کار') {
            if (!$request->date || !$request->date2) {
                return redirect()->back()->with('err_message', 'تاریخ وارد نشده');
            }
            $start_date = Carbon::parse(j2g(num_to_en($request->date)));
            $end_date   = Carbon::parse(j2g(num_to_en($request->date2)));
            if ($start_date->diffInDays($end_date ,false) < 0) {
                return redirect()->back()->with('err_message', 'تاریخ وارد شده صحیح نیست');
            }
        }

        try {
            $name = 'بدون نام';
            $belongs_to_item = 0;
            if (auth()->user()->first_name || auth()->user()->last_name) {
                $name = auth()->user()->first_name.' '.auth()->user()->last_name;
            }
            if ($request->belongs_to_item) {
                $belongs_to_item = $request->belongs_to_item;
            }
            $ticket = new Contact();
            $ticket->user_id         = auth()->user()->id; 
            $ticket->full_name       = $name;
            $ticket->subject         = $request->subject;
            switch ($request->subject) {
                case 'درخواست پاداش':
                    $ticket->category = 'حسابدار';
                    break;
                case 'درخواست مساعده':
                    $ticket->category = 'حسابدار';
                    break;
                case 'درخواست تنخواه':
                    $ticket->category = 'حسابدار';
                    break;
                case 'درخواست مرخصی':
                    $ticket->category = 'اداری';
                    break;
                case 'درخواست محاسبه ساعت کار':
                    $ticket->category = 'اداری';
                    break;
                case 'درخواست ثبت گزارش کار':
                    $ticket->category = 'اداری';
                    break;
            }
            $ticket->reagent_id      = auth()->user()->reagent_id;
            if ($request->date) {
                $ticket->date = $request->date;
                if ($request->date2) {
                    $ticket->date = $request->date.','.$request->date2;
                    $ticket->start_date = $start_date;
                    $ticket->end_date   = $end_date;
                }
            }
            if ($ticket->subject=='درخواست مرخصی') {
                if ($request->lorem2) {
                    $ticket->date       = $ticket->date.' '.$request->lorem2;
                }
                if ($request->lorem3) {
                    $ticket->date       = $ticket->date.' '.$request->lorem3;
                }
                if ($request->type_ticket == 'hourly') {
                    $ticket->time1 = $request->time1;
                    $ticket->time2 = $request->time2;
                }
            }
            $ticket->text           = $ticket->text.' '.$request->text;
            $ticket->belongs_to_item = $belongs_to_item;

            $ticket->answered        = 'no';
            if ($request->hasFile('attach')) {
                $ticket->attach = file_store($request->attach, 'source/asset/uploads/ticket/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
                // $request->validate([
                //     'attach' => 'required|mimes:pdf,xlx,csv|max:2048',
                // ]);
            }
            $ticket->save();
            return redirect()->back()->with('flash_message', 'پیام شما با موفقیت ارسال شد');
        }
        catch (\Exception $error)
        {
            return redirect()->back()->with('err_message', 'مشکلی در ارسال فرم بوجود آمده ، مجدد تلاش کنید');
        }
    }
}
