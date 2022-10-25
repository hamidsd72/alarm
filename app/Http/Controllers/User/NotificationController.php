<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Model\Setting;
use App\Model\Notification;

class NotificationController extends Controller { 
    public function __construct() {
        $this->middleware('auth');
    }
    public function controller_title($type) {
        if ($type == 'sum') {
            return 'پیام ها';
        } elseif ('single') {
            return 'پیام';
        }
    }
    function user_id() {
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            return auth()->user()->id;
        } else {
            return auth()->user()->reagent_id;
        }
    }
    public function controller_paginate() {
        return Setting::select('paginate')->where('user_id', $this->user_id())->first()->paginate;
    }
    public function index() {
        $items = Notification::where('user_id', auth()->user()->id)->orderByDesc('id')->paginate($this->controller_paginate());
        return view('user.notification.index', compact('items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function show($id) {
        $item = Notification::where('user_id', auth()->user()->id)->findOrFail($id);
        $item->status = 'active';
        $item->save();
        return view('user.notification.show', compact('item'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('single')]);
    }
}