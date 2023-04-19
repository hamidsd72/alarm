<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Job;
use App\Model\Setting;
use App\Model\Service;
use App\Model\ServiceCat;
use App\Model\ServicePackage;
use App\Model\ServiceJoinPackage;
use App\Model\ServicePackagePrice;
use App\Model\Photo;
use App\Model\Filep;
use App\Model\Agent;
use App\Model\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ItemController extends Controller {
    public function controller_title($type) {
        if ($type == 'sum') {
            return 'محتوا صفحات';
        } elseif ('single') {
            return 'محتوا';
        }
    } 
    public function controller_paginate() {
        return Setting::select('paginate')->where('user_id', $this->user_id())->first()->paginate;
    }
    public function __construct() {
        $this->middleware(['auth', 'SpecialUser','Access']);
    }
    function user_id() {
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            return auth()->user()->id;
        } else {
            return auth()->user()->reagent_id;
        }
    }
    public function toEnNumber($input) {
        $replace_pairs = array(
              '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4', '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
              '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4', '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9'
        );
        
        return strtr( $input, $replace_pairs );
    }
    public function index() {
        return view('admin.items.show', ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function show($id) {
        $items  = Item::where('section', $id)->orderBy('position')->paginate($this->controller_paginate());
        return view('admin.items.show', compact('items','id'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function edit($id) {
        $item   = Item::findOrFail($id);
        return view('admin.items.edit', compact('item'), ['title1' => ' ویرایش '.$this->controller_title('single'), 'title2' => ' ویرایش '.$this->controller_title('sum')]);
    }
    public function update(Request $request, $id) {
        $this->validate($request, [
            'section'   => 'required',
            'position'  => 'required',
            'sort'      => 'required',
        ],
            [
                'section.required'  => 'سکشن را وارد کنید',
                'position.required' => 'محل نمایش را وارد کنید',
                'sort.required'     => 'ترتیب را وارد کنید',
            ]);
        
        $item   = Item::findOrFail($id);

        try {
            if ($request->section)  $item->section  = $request->section;
            if ($request->position) $item->position = $request->position;
            if ($request->sort)     $item->sort     = $request->sort;
            if ($request->title)    $item->title    = $request->title;
            if ($request->text)     $item->text     = $request->text;
            if ($request->status)   $item->status   = $request->status;
            if ($request->hasFile('pic')) {
                if ($item->pic != null) File::delete($item->pic);
                $item->pic = file_store($request->pic, 'source/asset/uploads/items/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic-');
            }
            $item->update();
            
            return redirect()->route('admin.items.show',$request->section)->with('flash_message', 'محتوا با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش محتوا بوجود آمده،مجددا تلاش کنید');
        }
    }
}


