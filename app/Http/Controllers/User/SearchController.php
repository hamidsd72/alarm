<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Setting;
use App\Model\Service;
use App\Model\ServiceCat;
use App\Model\ServicePackage;

class SearchController extends Controller {
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
    public function store(Request $request) {
        if ( $request->type=='package' ) {
            $items = ServicePackage::where('user_id', auth()->user()->id)->where('status', 'active')->where( 'title' ,  'like' , '%'. $request->search .'%' )->paginate($this->controller_paginate());
            if ($items->count()) {
                return view('user.package.index', compact('items'));
            }
        } else if ($request->type=='service') {
            $category_id = $request->category_id;
            // if(isset($category_id)){
                $items = Service::where('category_id',$category_id)->where( 'title' ,  'like' , '%'. $request->search .'%' )->paginate($this->controller_paginate());
            // }
            // else {
            //     $items = Service::where('category_id','!=',4)->where( 'title' ,  'like' , '%'. $request->search .'%' )->take(20)->get();
            // }
            if ($items) {
                $ServiceCat = ServiceCat::where('type','service')->whereIn('id', $items->pluck('category_id') )->first();
                if ($ServiceCat) {
                    return view('user.services', compact('items','ServiceCat'), ['title1' => 'موارد یافت شده', 'title2' => 'موارد یافت شده']);
                }
            }
        }
        return redirect()->back()->with(['status' => 'danger', "message" => "موردی یافت نشد"]);
    }
}