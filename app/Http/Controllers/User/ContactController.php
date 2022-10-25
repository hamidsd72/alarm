<?php

namespace App\Http\Controllers\User;

use App\Model\About;
use App\Model\Network;
use App\Model\Setting;
use App\Http\Controllers\Controller;

class ContactController extends Controller {
    function user_id() {
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            return auth()->user()->id;
        } else {
            return auth()->user()->reagent_id;
        }
    }
    public function show() {
        $about = About::where('user_id', $this->user_id())->first();
        $network = Network::where('user_id', $this->user_id())->where('status', 'active')->orderBy('sort')->get();
        $setting = Setting::where('user_id', $this->user_id())->first('title');
        return view('user.contact.show',compact('about','network','setting'));
    }
}
