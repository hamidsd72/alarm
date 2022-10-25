<?php

namespace App\Http\Controllers\Admin;

use App\Model\Setting;
use App\Model\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller {
    public function controller_title($type) {
        if ($type == 'sum') {
            return 'لیست درخواست ها';
        } elseif ('single') {
            return 'درخواست ها ';
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
        $this->middleware('auth');
    }
    public function index($type=null) {
        if (Auth::user()->hasRole('مدیر ارشد') || Auth::user()->hasRole('مدیر'))  {
            $items = Contact::where('reagent_id',auth()->user()->id)->where('answered', 'no')->where('belongs_to_item', '=', 0)->orderByDesc('id');
        } else {
            $items = Contact::where('reagent_id',auth()->user()->reagent_id)->where('category',auth()->user()->getRoleNames()->first())->where('answered', 'no')->where('belongs_to_item', '=', 0)->orderByDesc('id');
        }
        if ($type && $type=='pending') {
            $items->where('reply', '=', 0);
        } else if($type && $type=='active') {
            $items->where('reply', '>', 0);
        }
        $items = $items->paginate($this->controller_paginate());
        $sub_items = '';
        if ($items->count()) {
            $sub_items = Contact::where('answered', 'no')->whereIn('belongs_to_item', $items->pluck('id') )->get();
        }
        return view('admin.content.contact.index', compact('items','sub_items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function send_email(Request $request,$id) {
        $item=Contact::findOrFail($id);
        try {
        send_mail($item->email, 'پاسخ به تماس با ما آی مشاور با موضوع : '.$item->subject,$request->text);
        $item->reply+=1;
        $item->update();
        return redirect()->back()->with('flash_message', 'ارسال ایمیل با موفقیت انجام شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ارسال ایمیل تماس بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function send_ticket(Request $request,$id) {
        if (Auth::user()->hasRole('مدیر ارشد') || Auth::user()->hasRole('مدیر'))  {
            $reagent_id = auth()->user()->id;
        } else {
            $reagent_id = auth()->user()->reagent_id;
        }
        $item = Contact::where('reagent_id',$reagent_id)->findOrFail($id);
        $sub_items = Contact::where('belongs_to_item', $item->id )->get();
        try {
            $belongs_to_item              = 0;
            if ($request->belongs_to_item) {
                $belongs_to_item = $request->belongs_to_item;
            }
            $ticket = new Contact();
            $ticket->user_id              = $item->user_id;
            $ticket->reagent_id           = $reagent_id;
            $ticket->full_name            = $item->full_name;
            $ticket->belongs_to_item      = $belongs_to_item;
            $ticket->subject              = 'پاسخ به : '.$item->subject;
            $ticket->text                 = $request->text;
            $ticket->category             = $request->category;
            $ticket->answered             = 'yes';
            if ($request->hasFile('attach')) {
                // $request->validate([
                //     'attach' => 'required|mimes:pdf,xlx,csv|max:2048',
                // ]);          
                $ticket->attach = file_store($request->attach, 'source/asset/uploads/ticket/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
            }
            $ticket->save();

            $item->reply+=1;
            $item->update();

            foreach ($sub_items as $sub_item) {
                $sub_item->reply+=1;
                $sub_item->update();
            }

            return redirect()->back()->with('flash_message', 'ارسال پاسخ درخواست با موفقیت انجام شد.'); 

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ارسال پاسخ درخواست بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function destroy($id) {
        if (Auth::user()->hasRole('مدیر ارشد') || Auth::user()->hasRole('مدیر'))  {
            $reagent_id = auth()->user()->id;
        } else {
            $reagent_id = auth()->user()->reagent_id;
        }
        $item = Contact::where('reagent_id',$reagent_id)->findOrFail($id);
        try {
            $item->delete();
            return redirect()->back()->with('flash_message', 'درخواست با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف درخواست بوجود آمده،مجددا تلاش کنید');
        }
    }
}


