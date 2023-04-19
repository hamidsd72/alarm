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
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ServicePackageController extends Controller {
    public function controller_title($type) {
        if ($type == 'sum') {
            return 'فعالیت ها';
        } elseif ('single') {
            return 'فعالیت';
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
        $items = ServicePackage::where('reagent_id', $this->user_id())->orderByDesc('created_at')->paginate($this->controller_paginate());
        $users = User::where('reagent_id', $this->user_id() )->get(['id','first_name','last_name']);
        return view('admin.service.package.index', compact('items','users'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function show($id) {
        $items = ServicePackage::where('reagent_id', $this->user_id())->where('user_id', $id)->orderByDesc('created_at')->paginate($this->controller_paginate());
        $users = User::where('reagent_id', $this->user_id() )->get(['id','first_name','last_name']);
        return view('admin.service.package.index', compact('items','users','id'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function create() {
        $items = User::where('reagent_id', $this->user_id())->get(['id','first_name','last_name']);
        $customs = Agent::where('user_id', $this->user_id())->get(['id','first_name','last_name','text']);
        $jobs = Job::where('reagent_id',$this->user_id())->get(['id','title']);
        return view('admin.service.package.create', compact('jobs','items','customs'), ['title1' => ' افزودن '.$this->controller_title('single'), 'title2' => ' افزودن '.$this->controller_title('sum')]);
    }
    public function store(Request $request) {
        $this->validate($request, [
            // 'service.*' => 'required',
            'title' => 'required|max:240',
            // 'slug' => 'required|max:250|unique:service_packages',
            'started_at' => 'required',
            'text' => 'required',
            // //            'limited' => 'required',
            'price' => 'required',
            // 'photo' => 'required|image|mimes:jpeg,jpg,png|max:5120',
            // 'pic_card' => 'required|image|mimes:jpeg,jpg,png|max:5120',
            'file' => 'nullable|max:30720',
            // 'file' => 'nullable|mimes:pdf|max:30720',
            //            'video' => 'nullable|mimes:mp4|max:51200',
        ],
            [
                'started_at.required' => 'لطفا تاریخ انجام کار را وارد کنید',
                'service.required' => 'لطفا خدمت را انتخاب کنید',
                'title.required' => 'لطفا نام پکیج را وارد کنید',
                'title.max' => 'نام پکیج نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
                'text.required' => 'لطفا توضیحات را وارد کنید',
                'limited.required' => 'لطفا محدودیت را مشخص کنید(هر بار برای چند روز)',
                'price.required' => 'لطفا هزینه را وارد کنید',
                'photo.required' => 'لطفا یک تصویر انتخاب کنید',
                'photo.image' => 'لطفا یک تصویر انتخاب کنید',
                'photo.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                'pic_card.required' => 'لطفا یک تصویر کارت انتخاب کنید',
                'pic_card.image' => 'لطفا یک تصویر کارت انتخاب کنید',
                'pic_card.mimes' => 'لطفا یک تصویر کارت با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'pic_card.max' => 'لطفا حجم تصویر کارت حداکثر 5 مگابایت باشد',
                // 'file.mimes' => 'لطفا یک فایل با پسوند (pdf) انتخاب کنید',
                'file.max' => 'لطفا حجم فایل حداکثر 30 مگابایت باشد',
                //                'video.mimes' => 'لطفا یک ویدئو با پسوند (mp4) انتخاب کنید',
                //                'video.max' => 'لطفا حجم ویدئو حداکثر 50 مگابایت باشد',
            ]);
        $home_view = 0;
        $custom = 0;
        $custom_count = 0;
        if ($request->home_view == "show") {
            $pakege = ServicePackage::where("custom", 1)->count();
            $home_view = 1;
        }
        // if ($request->custom == "on") {
        //     $pakege = ServicePackage::where("custom", 1)->count();
        //     if ($pakege > 0) {
        //         return redirect()->back()->withInput()->with('err_message', 'پکیج ویژه قبلا انتخاب شده');
        //     } else {
        //         $custom = 1;
        //         $custom_count = 0;
        //     }
        // }
        $slug = Job::find($request->title)->title.'-'.(ServicePackage::all()->last()->id + 1);

        $user_id = User::where('reagent_id', $this->user_id())->findOrFail($request->user_id);
        try {
            $item = new ServicePackage();
            $item->user_id      = $user_id->id;
            $item->reagent_id   = $this->user_id();
            $item->started_at   = j2g($this->toEnNumber($request->started_at));
            $item->title        = $request->title;
            // $item->slug         = $request->slug;
            $item->slug         = $slug;
            $item->text         = $request->text;
            $item->work_type = $request->work_type;
            $item->sort_by      = $request->sort_by;
            $item->custom_service_count = $custom_count;
            $item->custom       = $request->custom ;
            $item->home_view    = $home_view;
            $item->price        = $request->price;
            $item->location_work = $request->location_work=='on'?'خارج از شهر':'داخل شهر';
            //            $item->limited = $request->limited;
            //            $item->home_text = $request->home_text;
            // if ($request->hasFile('pic_card')) {
            //     $item->pic_card = file_store($request->pic_card, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic_card-');;
            // }
            $item->save();
            // if ($request->hasFile('pic_card')) {
            //     img_resize(
            //         $item->pic_card, //address img
            //         $item->pic_card, //address save
            //         600,// width: if width==0 -> width=auto
            //         0 // height: if height==0 -> height=auto
            //     // end optimaiz
            //     );
            // }
            // if ($request->service) {
            //     foreach ($request->service as $key => $service) {
            //         $join = new ServiceJoinPackage();
            //         $join->service_id = $service;
            //         $join->package_id = $item[$key]->id;
            //         $join->sort_by = $key;
            //         $join->save();
            //     }
            // }
            // if ($request->hasFile('photo')) {
            //     $photo = new Photo();
            //     $photo->path = file_store($request->photo, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
            //     $item->photo()->save($photo);
                /*img_resize(
                    $photo->path, //address img
                    $photo->path, //address save
                    200,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );*/
            // }
            if ($request->hasFile('file')) {
                $file = new Filep();
                $file->path = file_store($request->file, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/files/', 'file-');
                $item->file()->save($file);
            }
                //            if ($request->hasFile('video')) {
                //                $video = new Video();
                //                $video->path = file_store($request->video, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/videos/', 'video-');;
                //                $item->video()->save($video);
                //            }
            return redirect()->route('admin.service.package.list')->with('flash_message', 'فعالیت با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد فعالیت بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function edit($id) {
        $item = ServicePackage::where('reagent_id', $this->user_id())->findOrFail($id);
        // $items = Service::where('category_id','!=',4)->orderBy('title', 'asc')->get();
        $items = User::where('reagent_id', $this->user_id())->get(['id','first_name','last_name']);
        $jobs = Job::where('reagent_id',$this->user_id())->get(['id','title']);
        $customs = Agent::where('user_id', $this->user_id())->get(['id','first_name','last_name','text']);
        $service = [];
        foreach ($item->joins as $i) {
            array_push($service, $i->service_id);
        }
        return view('admin.service.package.edit', compact('jobs','item', 'items', 'service','customs'), ['title1' => ' ویرایش '.$this->controller_title('single'), 'title2' => ' ویرایش '.$this->controller_title('sum')]);
    }
    public function update(Request $request, $id) {
        $this->validate($request, [
            'service.*' => 'required',
            'title' => 'required|max:240',
            // 'slug' => 'required|max:250|unique:service_packages,slug,' . $id,
            'slug' => 'required|max:250',
            'started_at' => 'required',
            'text' => 'required',
            // //            'limited' => 'required',
            'price' => 'required',
            // 'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            // 'pic_card' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            // 'file' => 'nullable|mimes:pdf|max:30720',
            'file' => 'nullable|max:30720',
            //            'video' => 'nullable|mimes:mp4|max:51200',
        ],
            [
                'started_at.required' => 'لطفا تاریخ انجام کار را وارد کنید',
                'service.required' => 'لطفا خدمت را انتخاب کنید',
                'title.required' => 'لطفا نام پکیج را وارد کنید',
                'title.max' => 'نام پکیج نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
                'text.required' => 'لطفا توضیحات را وارد کنید',
                'limited.required' => 'لطفا محدودیت را مشخص کنید(هر بار برای چند روز)',
                'price.required' => 'لطفا هزینه را وارد کنید',
                'photo.image' => 'لطفا یک تصویر انتخاب کنید',
                'photo.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                'pic_card.image' => 'لطفا یک تصویر کارت انتخاب کنید',
                'pic_card.mimes' => 'لطفا یک تصویر کارت با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'pic_card.max' => 'لطفا حجم تصویر کارت حداکثر 5 مگابایت باشد',
                // 'file.mimes' => 'لطفا یک فایل با پسوند (pdf) انتخاب کنید',
                'file.max' => 'لطفا حجم فایل حداکثر 30 مگابایت باشد',
                //                'video.mimes' => 'لطفا یک ویدئو با پسوند (mp4) انتخاب کنید',
                //                'video.max' => 'لطفا حجم ویدئو حداکثر 50 مگابایت باشد',
            ]);
        $home_view = 0;
        $custom = 0;
        $custom_count = 0;
        $item = ServicePackage::where('reagent_id', $this->user_id())->findOrFail($id);
        if ($request->home_view == "show") {
            $home_view = 1;
        }
        // if ($request->custom == "on") {
        //     $pakege = ServicePackage::where("custom", 1)->where('id', '!=', $item->id)->count();
        //     if ($pakege > 0) {
        //         return redirect()->back()->withInput()->with('err_message', 'پکیج ویژه قبلا انتخاب شده');
        //     } else {
        //         $custom = 1;
        //         $custom_count = 0;
        //     }
        // }
        $slug = Job::find($request->title)->title.'-'.$item->id;

        try {
            $item->title = $request->title;
            $item->slug = $slug;
            $item->text = $request->text;
            $item->work_type = $request->work_type;
            $item->sort_by = $request->sort_by;
            $item->started_at = j2g($this->toEnNumber($request->started_at));
            //            $item->home_text = $request->home_text;
            $item->custom_service_count = $custom_count;
            $item->custom = $request->custom ;
            $item->home_view = $home_view;
            $item->limited = $request->limited;
            $item->price = $request->price;
            $item->location_work = $request->location_work=='on'?'خارج از شهر':'داخل شهر';
            // if ($request->hasFile('pic_card')) {
            //     if ($item->pic_card != null) {
            //         $old_path = $item->pic_card;
            //         File::delete($old_path);
            //     }
            //     $item->pic_card = file_store($request->pic_card, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic_card-');;
            // }
            $item->update();
            // if ($request->hasFile('pic_card')) {
            //     img_resize(
            //         $item->pic_card, //address img
            //         $item->pic_card, //address save
            //         600,// width: if width==0 -> width=auto
            //         0 // height: if height==0 -> height=auto
            //     // end optimaiz
            //     );
            // }


            if ($request->service) {


                foreach (ServiceJoinPackage::where('package_id',$item->id)->get() as $joins) {
                    if(!in_array($joins->service_id,$request->service)){
                        $joins->delete();
                    }

                }


                foreach ($request->service as $key => $service) {
                    if(!ServiceJoinPackage::where('service_id',$service)->where('package_id',$item->id)->first()){
                        $join = new ServiceJoinPackage();
                        $join->service_id = $service;
                        $join->package_id = $item[$key]->id;
                        $join->save();
                    }
                }
            }

            if ($request->hasFile('photo')) {
                if ($item->photo) {
                    $old_path = $item->photo->path;
                    File::delete($old_path);
                    $item->photo->delete();
                }
                $photo = new Photo();
                $photo->path = file_store($request->photo, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                $item->photo()->save($photo);
                /*img_resize(
                    $photo->path, //address img
                    $photo->path, //address save
                    200,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );*/
            }
            if ($request->hasFile('file')) {
                if ($item->file) {
                    $old_path = $item->file->path;
                    File::delete($old_path);
                    $item->file->delete();
                }
                $file = new Filep();
                $file->path = file_store($request->file, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/files/', 'file-');;
                $item->file()->save($file);
            }
                //            if ($request->hasFile('video')) {
                //                if ($item->video) {
                //                    $old_path = $item->video->path;
                //                    File::delete($old_path);
                //                    $item->video->delete();
                //                }
                //                $video = new Video();
                //                $video->path = file_store($request->video, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/videos/', 'video-');;
                //                $item->video()->save($video);
                //            }
            return redirect()->route('admin.service.package.list')->with('flash_message', 'فعالیت با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش فعالیت بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function destroy($id) {
        $item = ServicePackage::where('reagent_id', $this->user_id())->findOrFail($id);
        $items = ServiceJoinPackage::where('package_id', $id)->get();
        $prices = ServicePackagePrice::where('package_id', $id)->get();
        try {
            if(count($items)>0) {
                foreach ($items as $item1) {
                    $item1->delete();
                }
            }

            if(count($prices)>0) {
                foreach ($prices as $price) {
                    $price->delete();
                }
            }
            $item->delete();
            return redirect()->back()->with('flash_message', 'فعالیت با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف فعالیت بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function active($id, $type) {
        $item = ServicePackage::where('reagent_id', $this->user_id())->find($id);
        try {
            $item->status = $type;
            $item->update();
            if ($type == 'pending') {
                return redirect()->back()->with('flash_message', 'نمایش پکیج خدمت با موفقیت غیرفعال شد.');
            }
            if ($type == 'active') {
                return redirect()->back()->with('flash_message', 'نمایش پکیج خدمت با موفقیت فعال شد.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در تغییر وضعیت پکیج خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function sort_by_join(Request $request) {
        try {
            foreach ($request->id_join as $key => $id) {
                $srvice_join = ServiceJoinPackage::find($id);
                $srvice_join->sort_by = $request->sort_by[$key];
                $srvice_join->save();
            }
            return redirect()->back()->with('flash_message', 'ترتیب نمایش با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی بوجود آمده لطفا دباره تلاش کنید');
        }
    }
    public function learn_index() {
        $items = ServicePackage::where('reagent_id', auth()->user()->id)->where('type','learning')->orderBy('sort_by', 'ASC')->paginate($this->controller_paginate());
        return view('admin.service.package.learn.index', compact('items'), ['title1' => 'خدمات', 'title2' => 'پکیج آموزشی']);
    }
    public function learn_create() {
        $cats = ServiceCat::where('reagent_id', auth()->user()->id)->where('type','package')->where('id','!=',4)->get();
        $items = Service::where('reagent_id', auth()->user()->id)->where('category_id','=',4)->orderBy('title', 'asc')->get();
        return view('admin.service.package.learn.create', compact('items','cats'), ['title1' => 'خدمات', 'title2' => 'افزودن پکیج آموزشی']);
    }
    public function learn_store(Request $request) {
        $this->validate($request, [
            'service.*' => 'required',
            'title' => 'required|max:240',
            'slug' => 'required|max:250|unique:service_packages',
            'text' => 'required',
            //            'limited' => 'required',
            //            'price' => 'required',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:5120',
            'pic_card' => 'required|image|mimes:jpeg,jpg,png|max:5120',
            'file' => 'nullable|mimes:pdf|max:30720',
            //            'video.*' => 'nullable|mimes:mp4|max:51200',
            //            'video_sale.*' => 'nullable|mimes:mp4|max:51200',
        ],
            [
                'service.required' => 'لطفا خدمت را انتخاب کنید',
                'title.required' => 'لطفا نام پکیج را وارد کنید',
                'title.max' => 'نام پکیج نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
                'text.required' => 'لطفا توضیحات را وارد کنید',
                'limited.required' => 'لطفا محدودیت را مشخص کنید(هر بار برای چند روز)',
                'price.required' => 'لطفا هزینه را وارد کنید',
                'photo.required' => 'لطفا یک تصویر انتخاب کنید',
                'photo.image' => 'لطفا یک تصویر انتخاب کنید',
                'photo.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                'pic_card.required' => 'لطفا یک تصویر کارت انتخاب کنید',
                'pic_card.image' => 'لطفا یک تصویر کارت انتخاب کنید',
                'pic_card.mimes' => 'لطفا یک تصویر کارت با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'pic_card.max' => 'لطفا حجم تصویر کارت حداکثر 5 مگابایت باشد',
                'file.mimes' => 'لطفا یک فایل با پسوند (pdf) انتخاب کنید',
                'file.max' => 'لطفا حجم فایل حداکثر 30 مگابایت باشد',
                //                'video.*.mimes' => 'لطفا یک ویدئو با پسوند (mp4) انتخاب کنید(رایگان)',
                //                'video.*.max' => 'لطفا حجم ویدئو حداکثر 50 مگابایت باشد(رایگان)',
                //                'video_sale.*.mimes' => 'لطفا یک ویدئو با پسوند (mp4) انتخاب کنید(بعد خرید پکیج)',
                //                'video_sale.*.max' => 'لطفا حجم ویدئو حداکثر 50 مگابایت باشد(بعد خرید پکیج)',
            ]);
        $home_view = 0;
        $custom = 0;
        $custom_count = 0;
        if ($request->home_view == "show") {
            $pakege = ServicePackage::where("custom", 1)->count();
            $home_view = 1;
        }
        if ($request->custom == "on") {
            $pakege = ServicePackage::where("custom", 1)->count();
            if ($pakege > 0) {
                return redirect()->back()->withInput()->with('err_message', 'پکیج ویژه قبلا انتخاب شده');
            } else {
                $custom = 1;
                $custom_count = 0;
            }
        }
        try {
            $item = new ServicePackage();
            $item->title = $request->title;
            $item->slug = $request->slug;
            $item->category_id = $request->category_id;
            $item->type = "learning";
            $item->text = $request->text;
            if ($request->sort_by!=null){
                $item->sort_by = $request->sort_by;
            }
            //            $item->home_text = $request->home_text;
            $item->custom_service_count = $custom_count;
            $item->custom = $custom;
            $item->home_view = $home_view;
            //            $item->limited = $request->limited;
            //            $item->price = $request->price;
            if ($request->hasFile('pic_card')) {
                $item->pic_card = file_store($request->pic_card, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic_card-');;
            }
            $item->save();
            if ($request->hasFile('pic_card')) {
                img_resize(
                    $item->pic_card, //address img
                    $item->pic_card, //address save
                    600,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );
            }
            if ($request->service) {
                foreach ($request->service as $key => $service) {
                    $join = new ServiceJoinPackage();
                    $join->service_id = $service;
                    $join->package_id = $item->id;
                    $join->sort_by = $key;
                    $join->save();
                }
            }
            if ($request->hasFile('photo')) {
                $photo = new Photo();
                $photo->path = file_store($request->photo, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                $item->photo()->save($photo);
                img_resize(
                    $photo->path, //address img
                    $photo->path, //address save
                    200,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );
            }
            if ($request->hasFile('inner_pic')) {
                $photo = new Photo();
                $photo->path = file_store($request->inner_pic, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
                $photo->place="inner_page";
                $item->photo()->save($photo);
            }
            if ($request->hasFile('program')) {
                $photo = new Photo();
                $photo->path = file_store($request->program, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
                $photo->place="program";
                $item->photo()->save($photo);
            }

            if ($request->hasFile('file')) {
                $file = new Filep();
                $file->path = file_store($request->file, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/files/', 'file-');;
                $item->file()->save($file);
            }
                //            if ($request->hasFile('video')) {
                //                $video = new Video();
                //                $video->path = file_store($request->video, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/videos/', 'video-');;
                //                $item->video()->save($video);
                //            }
                //            if ($request->hasFile('video_sale')) {
                //                $video_sale = new Video();
                //                $video_sale->path = file_store($request->video_sale, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/videos/', 'video-sale-');;
                //                $video_sale->type='sale';
                //                $item->video()->save($video_sale);
                //            }
            return redirect()->route('admin.service.learn.package.list')->with('flash_message', 'پکیج آموزشی با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد پکیج آموزشی بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function learn_edit($id) {
        $cats = ServiceCat::where('type','package')->where('id','!=',4)->get();
        $item = ServicePackage::find($id);
        //        dd($item->join);
        $items = Service::where('category_id','=',4)->orderBy('title', 'asc')->get();
        $service = [];
        foreach ($item->joins as $i) {
            array_push($service, $i->service_id);
        }
        return view('admin.service.package.learn.edit', compact('item','cats', 'items', 'service'), ['title1' => 'خدمات', 'title2' => 'ویرایش پکیج آموزشی']);
    }
    public function learn_update(Request $request, $id) {
        //        dd($request->all());
        $this->validate($request, [
            'service.*' => 'required',
            'title' => 'required|max:240',
            'slug' => 'required|max:250|unique:service_packages,slug,' . $id,
            'text' => 'required',
            //            'limited' => 'required',
            //            'price' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'pic_card' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'file' => 'nullable|mimes:pdf|max:30720',
            //            'video' => 'nullable|mimes:mp4|max:51200',
            //            'video_sale' => 'nullable|mimes:mp4|max:51200',
        ],
            [
                'service.required' => 'لطفا خدمت را انتخاب کنید',
                'title.required' => 'لطفا نام پکیج را وارد کنید',
                'title.max' => 'نام پکیج نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
                'text.required' => 'لطفا توضیحات را وارد کنید',
                'limited.required' => 'لطفا محدودیت را مشخص کنید(هر بار برای چند روز)',
                'price.required' => 'لطفا هزینه را وارد کنید',
                'photo.image' => 'لطفا یک تصویر انتخاب کنید',
                'photo.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                'pic_card.image' => 'لطفا یک تصویر کارت انتخاب کنید',
                'pic_card.mimes' => 'لطفا یک تصویر کارت با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'pic_card.max' => 'لطفا حجم تصویر کارت حداکثر 5 مگابایت باشد',
                'file.mimes' => 'لطفا یک فایل با پسوند (pdf) انتخاب کنید',
                'file.max' => 'لطفا حجم فایل حداکثر 30 مگابایت باشد',
                //                'video.mimes' => 'لطفا یک ویدئو با پسوند (mp4) انتخاب کنید(رایگان)',
                //                'video.max' => 'لطفا حجم ویدئو حداکثر 50 مگابایت باشد(رایگان)',
                //                'video_sale.mimes' => 'لطفا یک ویدئو با پسوند (mp4) انتخاب کنید(بعد خرید پکیج)',
                //                'video_sale.max' => 'لطفا حجم ویدئو حداکثر 50 مگابایت باشد(بعد خرید پکیج)',
            ]);
        $home_view = 0;
        $custom = 0;
        $custom_count = 0;
        $item = ServicePackage::find($id);
        if ($request->home_view == "show") {
            $home_view = 1;
        }
        if ($request->custom == "on") {
            $pakege = ServicePackage::where("custom", 1)->where('id', '!=', $item->id)->count();
            if ($pakege > 0) {
                return redirect()->back()->withInput()->with('err_message', 'پکیج ویژه قبلا انتخاب شده');
            } else {
                $custom = 1;
                $custom_count = 0;
            }
        }

        try {
            $item->title = $request->title;
            $item->slug = $request->slug;
            $item->category_id = $request->category_id;
            $item->text = $request->text;
            $item->type = "learning";
            $item->sort_by = $request->sort_by;
            //            $item->home_text = $request->home_text;
            $item->custom_service_count = $custom_count;
            $item->custom = $custom;
            $item->home_view = $home_view;
            $item->limited = $request->limited;
            //            $item->price = $request->price;
            if ($request->hasFile('pic_card')) {
                if ($item->pic_card != null) {
                    $old_path = $item->pic_card;
                    File::delete($old_path);
                }
                $item->pic_card = file_store($request->pic_card, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'pic_card-');;
            }
            $item->update();
            if ($request->hasFile('pic_card')) {
                img_resize(
                    $item->pic_card, //address img
                    $item->pic_card, //address save
                    600,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );
            }

            if ($request->service) {
                if (count($item->joins) > 0) {
                    foreach ($item->joins as $joins) {
                        $joins->delete();
                    }
                }
                foreach ($request->service as $key => $service) {
                    $join = new ServiceJoinPackage();
                    $join->service_id = $service;
                    $join->package_id = $item->id;
                    $join->save();
                }
            }

            if ($request->hasFile('photo')) {
                if ($item->photo) {
                    $old_path = $item->photo->path;
                    File::delete($old_path);
                    $item->photo->delete();
                }
                $photo = new Photo();
                $photo->path = file_store($request->photo, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                $item->photo()->save($photo);
                img_resize(
                    $photo->path, //address img
                    $photo->path, //address save
                    200,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );
            }
            if ($request->hasFile('inner_pic')) {
                if ($item->photo_inner_page) {
                    $old_path = $item->photo_inner_page->path;
                    File::delete($old_path);
                    $item->photo_inner_page->delete();
                }
                $photo = new Photo();
                $photo->path = file_store($request->inner_pic, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-inner-');;
                $photo->place="inner_page";
                $item->photo()->save($photo);

            }
            if ($request->hasFile('program')) {
                if ($item->program) {
                    $old_path = $item->program->path;
                    File::delete($old_path);
                    $item->photo_inner_page->delete();
                }
                $photo = new Photo();
                $photo->path = file_store($request->program, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-inner-');;
                $photo->place="program";
                $item->photo()->save($photo);

            }
            if ($request->hasFile('file')) {
                if ($item->file) {
                    $old_path = $item->file->path;
                    File::delete($old_path);
                    $item->file->delete();
                }
                $file = new Filep();
                $file->path = file_store($request->file, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/files/', 'file-');;
                $item->file()->save($file);
            }
                //            if ($request->hasFile('video')) {
                //                if ($item->video) {
                //                    $old_path = $item->video->path;
                //                    File::delete($old_path);
                //                    $item->video->delete();
                //                }
                //                $video = new Video();
                //                $video->path = file_store($request->video, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/videos/', 'video-');;
                //                $item->video()->save($video);
                //            }
                //            if ($request->hasFile('video_sale')) {
                //                if ($item->video_sale) {
                //                    $old_path = $item->video_sale->path;
                //                    File::delete($old_path);
                //                    $item->video_sale->delete();
                //                }
                //                $video_sale = new Video();
                //                $video_sale->path = file_store($request->video_sale, 'source/asset/uploads/service_package/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/videos/', 'video-sale-');;
                //                $video_sale->type='sale';
                //                $item->video()->save($video_sale);
                //            }
            return redirect()->route('admin.service.learn.package.list')->with('flash_message', 'پکیج آموزشی با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش پکیج آموزشی بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function learn_destroy($id) {
        $item = ServicePackage::find($id);
        $items = ServiceJoinPackage::where('package_id', $id)->get();
        $prices = ServicePackagePrice::where('package_id', $id)->get();
        try {
            if(count($items)>0) {
                foreach ($items as $item1) {
                    $item1->delete();
                }
            }

            if(count($prices)>0) {
                foreach ($prices as $price) {
                    $price->delete();
                }
            }
            $item->delete();
            return redirect()->back()->with('flash_message', 'پکیج آموزشی با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف پکیج آموزشی بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function learn_active($id, $type) {
        $item = ServicePackage::find($id);
        try {
            $item->status = $type;
            $item->update();
            if ($type == 'pending') {
                return redirect()->back()->with('flash_message', 'نمایش پکیج آموزشی با موفقیت غیرفعال شد.');
            }
            if ($type == 'active') {
                return redirect()->back()->with('flash_message', 'نمایش پکیج آموزشی با موفقیت فعال شد.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در تغییر وضعیت پکیج آموزشی بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function learn_sort_by_join(Request $request) {
        try {
            foreach ($request->id_join as $key => $id) {
                $srvice_join = ServiceJoinPackage::find($id);
                $srvice_join->sort_by = $request->sort_by[$key];
                $srvice_join->save();
            }
            return redirect()->back()->with('flash_message', 'ترتیب نمایش با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی بوجود آمده لطفا دباره تلاش کنید');
        }
    }
}


