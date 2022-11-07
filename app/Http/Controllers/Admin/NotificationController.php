<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\ServiceCat;
use App\Model\Setting;
use App\Model\ServicePackage;
use App\Model\Basket;
use App\Model\Notification;
use App\Model\Sms;

class NotificationController extends Controller { 
    public function __construct() {
        $this->middleware('auth');
    }
    public function controller_title($type) {
        if ($type == 'sum') {
            return 'اعلانات';
        } elseif ('single') {
            return 'اعلان';
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
    public function index() {
        $items = Notification::where('reagent_id', $this->user_id())->orderByDesc('id')->paginate($this->controller_paginate());
        $users = User::where('reagent_id', $this->user_id())->get(['id','first_name','last_name']);
        return view('admin.notification.index', compact('items','users'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function edit($notification) {
        $items = Notification::where('reagent_id', $this->user_id())->where('user_id', $notification)->paginate($this->controller_paginate());
        $users = User::where('reagent_id', $this->user_id())->get(['id','first_name','last_name']);
        return view('admin.notification.index', compact('items','users','notification'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function create() {
        $users      = User::where('reagent_id', $this->user_id())->get(['id','first_name','last_name','mobile']);
        $packages   = ServicePackage::where('status', 'active')->where('reagent_id', $this->user_id())->orderByDesc('sort_by')->get();
        $services   = ServiceCat::where('user_id', $this->user_id())->where('status', 'active')->get();
        return view('admin.notification.create', compact('users','packages','services'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function show($notification) {
        $item = Notification::where('reagent_id', $this->user_id())->findOrFail($notification);
        $fullname = User::findOrFail($item->user_id);
        return view('admin.notification.show', compact('item','fullname'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function update(Request $request, $notification) {
        try {
            $items = Notification::where('reagent_id',$this->user_id())->where('user_id',User::where('mobile',$request->user_mobile)->first()->id)->orderByDesc('id')->paginate($this->controller_paginate());
            $users = auth()->user();
            if ($items->count()) {
                $users = User::whereIn('id', $items->pluck('user_id'))->get(['id','mobile','first_name','last_name']);
                foreach ($users as $user) {
                    $user->mobile = $user->mobile.' '.$user->first_name.' '.$user->last_name;
                }
            }
            return view('admin.notification.edit', compact('items','users'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('err_message','کاربر پیدا نشد , احتمالا شماره اشتباه است');
        }
    }
    public function store(Request $request)  {
        if ($request->type == 'single') {
            $notife = new Notification();
            try {
                $notife->user_id     = User::where('mobile',$request->user_id)->first()->id;
                $notife->subject     = $request->subject;
                $notife->reagent_id  = $this->user_id();
                $notife->description = $request->description;
                if ($request->hasFile('attach')) {
                    $notife->atach = file_store($request->attach, 'source/asset/uploads/notification/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
                }
                $notife->save();
                Sms::SendSms( 'با سلام, شما یک اعلان جدید دارید. سامانه بست آلارم' , $request->user_id);
                return redirect()->route('admin.notification.index');
            } catch (\Throwable $th) {
                return redirect()->back()->withInput()->with('err_message','کاربر پیدا نشد , احتمالا شماره اشتباه است یا وارد نشده');
            }
        } elseif ($request->type == 'role') {
            $reagent_id = $this->user_id();
            $users = User::role($request->role_name)->where('reagent_id', $reagent_id )->get('id');
            if ($users->count()) {
                foreach ($users as $user) {
                    $notife = new Notification();
                    try {
                        $notife->user_id = $user->id;
                        $notife->subject = $request->subject;
                        $notife->reagent_id  = $reagent_id;
                        $notife->description = $request->description;
                        if ($request->hasFile('attach')) {
                            $notife->atach = file_store($request->attach, 'source/asset/uploads/notification/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
                        }
                        $notife->save();
                        Sms::SendSms( 'با سلام, شما یک اعلان جدید دارید. سامانه بست آلارم' , $user->mobile);
                    } catch (\Throwable $th) {
                        
                    }
                }
                return redirect()->route('admin.notification.index');
            } else { return redirect()->back()->withInput()->with('err_message','کاربری پیدا نشد'); }
        } elseif($request->type == 'package') {
            // $bascket = Basket::where('type' , 'package')->where('status' , 'active')->where('sale_id' , ServicePackage::findOrFail($request->package)->id)->pluck('user_id');
            // if ($bascket->count()) {
                // foreach (User::whereIn('id',$bascket)->get() as $user) {
                    $notife = new Notification();
                    try {
                        $user = User::find(ServicePackage::findOrFail($request->package)->user_id);
                        $notife->user_id = $user->id;
                        $notife->subject = $request->subject;
                        $notife->reagent_id  = $this->user_id();
                        $notife->description = $request->description;
                        if ($request->hasFile('attach')) {
                            $notife->atach = file_store($request->attach, 'source/asset/uploads/notification/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
                        }
                        $notife->save();
                        Sms::SendSms( 'با سلام, شما یک اعلان جدید دارید. سامانه بست آلارم' , $user->mobile);
                    } catch (\Throwable $th) {
                        
                    }
                // }
                return redirect()->route('admin.notification.index');
            // } else { return redirect()->back()->withInput()->with('err_message','کاربری پیدا نشد'); }
        } elseif($request->type == 'service') {
            $users = User::where('reagent_id', ServiceCat::findOrFail($request->service)->first()->user_id )->get('id','mobile');
            if ($users->count()) {
                foreach ($users as $user) {
                    $notife = new Notification();
                    try {
                        $notife->user_id = $user->id;
                        $notife->subject = $request->subject;
                        $notife->reagent_id  = $this->user_id();
                        $notife->description = $request->description;
                        if ($request->hasFile('attach')) {
                            $notife->atach = file_store($request->attach, 'source/asset/uploads/notification/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
                        }
                        $notife->save();
                        Sms::SendSms( 'با سلام, شما یک اعلان جدید دارید. سامانه بست آلارم' , $user->mobile);
                    } catch (\Throwable $th) {
                        
                    }
                }
                return redirect()->route('admin.notification.index');
            } else { return redirect()->back()->withInput()->with('err_message','کاربری پیدا نشد'); }
        }
    }
    public function destroy($id)  {
        Notification::where('reagent_id', $this->user_id())->findOrFail($id)->delete(); 
        return redirect()->route('admin.notification.index');
    }
}