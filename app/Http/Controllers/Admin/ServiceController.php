<?php

namespace App\Http\Controllers\Admin;

use App\Model\Setting;
use App\Model\ServiceCat;
use App\Model\Service;
use App\Model\Photo;
use App\Model\Filep;
use App\Model\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    public function controller_title($type) {
        if ($type == 'sum') {
            return 'آیتم ها';
        } elseif ('single') {
            return 'آیتم';
        }
    }
    public function controller_paginate() {
        return Setting::select('paginate')->where('user_id', $this->user_id())->first()->paginate;
    }
    public function __construct() {
        $this->middleware('auth');
    }
    function user_id() {
        if ( auth()->user()->hasRole('مدیر ارشد') || auth()->user()->hasRole('مدیر') ) {
            return auth()->user()->id;
        } else {
            return auth()->user()->reagent_id;
        }
    }
    public function index(Request $request)  {
        $category_id = $request->category_id;
        if(isset($category_id)){
            $items = Service::where('user_id',$this->user_id())->where('category_id', $category_id)->orderBy('order')->paginate($this->controller_paginate());
        }else {
            $items = Service::where('user_id',$this->user_id())->paginate($this->controller_paginate());
        }
        $ServiceCats = ServiceCat::where('user_id',$this->user_id())->where('type','service')->get();
        return view('admin.service.index', compact('items','ServiceCats','category_id'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function create($type) {
        $items = ServiceCat::where('user_id',$this->user_id())->where('type','service')->get();
        return view('admin.service.create',compact('items','type'), ['title1' => 'خدمات', 'title2' => 'افزودن خدمت']);
    }
    public function store(Request $request) {
        $this->validate($request, [
            'category_id' => 'required',
            'title' => 'required|max:240',
            'slug' => 'required|max:250|unique:services',
            'text' => 'required',
            // 'price' => 'required',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:5120',
            //            'file' => 'nullable|mimes:pdf|max:30720',
            // 'video_link' => 'required',
        ],
            [
                'category_id.required' => 'لطفا دسته بندی خدمت را انتخاب کنید',
                'title.required' => 'لطفا عنوان خدمت را وارد کنید',
                'title.max' => 'عنوان خدمت  نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
                'text.required' => 'لطفا توضیحات را وارد کنید',
                // 'price.required' => 'لطفا هزینه را وارد کنید',
                'photo.required' => 'لطفا یک تصویر انتخاب کنید',
                'photo.image' => 'لطفا یک تصویر انتخاب کنید',
                'photo.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                //                'file.mimes' => 'لطفا یک فایل با پسوند (pdf) انتخاب کنید',
                //                'file.max' => 'لطفا حجم فایل حداکثر 30 مگابایت باشد',
                // 'video_link.required' => 'لطفا لینک ویدیو را وارد کنید',
            ]);
        if ( Auth::user()->hasRole('مدیر ارشد') || Auth::user()->hasRole('مدیر') ) {
            try {
                $item = new Service();
                $maxValue = Service::max('order') +1;
                $item->category_id = $request->category_id;
                // $item->status = $request->status;
                $item->service_type = $request->service_type;
                // $item->sale_count = $request->sale_count;
                $item->user_id = $this->user_id();
                $item->title = $request->title;
                $item->slug = $request->slug;
                $item->text = $request->text;
                $item->time_start = $request->time_start;
                $item->time_end = $request->time_end;
                $item->time = $request->time;
                $item->video_link = $request->video_link;
                // $item->info_plus = $request->info_plus;
                $item->limited = $request->limited;
                $item->order = $maxValue;
                $item->price = $request->price;
                $item->save();
                if ($request->hasFile('photo')) {
                    $photo = new Photo();
                    $photo->path = file_store($request->photo, 'source/asset/uploads/service/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                    $item->photo()->save($photo);
                }
                    //            if ($request->hasFile('file')) {
                    //                $file = new Filep();
                    //                $file->path = file_store($request->file, 'source/asset/uploads/service/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/files/', 'file-');;
                    //                $item->file()->save($file);
                    //            }
                return redirect()->route('admin.service.list')->with('flash_message', ' خدمت با موفقیت ایجاد شد.');
            } catch (\Exception $e) {
                return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد خدمت بوجود آمده،مجددا تلاش کنید');
            }
        }
        abort(503);
    }
    public function edit($id) {
        $items = ServiceCat::where('user_id',$this->user_id())->where('type','service')->get();
        $item = Service::where('user_id',$this->user_id())->findOrFail($id);
        return view('admin.service.edit', compact('items','item'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function update(Request $request, $id) {
        $this->validate($request, [
            'category_id' => 'required',
            'service_type' => 'required',
            'title' => 'required|max:240',
            'slug' => 'required|max:250|unique:services,slug,'.$id,
            'text' => 'required',
            // 'price' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            //            'file' => 'nullable|mimes:pdf|max:30720',
            // 'video_link' => 'required',
        ],
            [
                'category_id.required' => 'لطفا دسته بندی خدمت را انتخاب کنید',
                'title.required' => 'لطفا عنوان خدمت را وارد کنید',
                'title.max' => 'عنوان خدمت  نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
                'text.required' => 'لطفا توضیحات را وارد کنید',
                // 'price.required' => 'لطفا هزینه را وارد کنید',
                'photo.image' => 'لطفا یک تصویر انتخاب کنید',
                'photo.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                //                'file.mimes' => 'لطفا یک فایل با پسوند (pdf) انتخاب کنید',
                //                'file.max' => 'لطفا حجم فایل حداکثر 30 مگابایت باشد',
                // 'video_link.required' => 'لطفا لینک ویدیو را وارد کنید',

            ]);
        $item = Service::where('user_id',$this->user_id())->findOrFail($id);
        try {
            // $item->status = $request->status;
            // $item->sale_count = $request->sale_count;
            $item->category_id = $request->category_id;
            $item->service_type = $request->service_type;
            $item->title = $request->title;
            $item->slug = $request->slug;
            $item->text = $request->text;
            $item->time_start = $request->time_start;
            $item->time_end = $request->time_end;
            $item->time = $request->time;
            $item->video_link = $request->video_link;
            //            $item->info_plus = $request->info_plus;
            $item->limited = $request->limited;
            $item->price = $request->price;
            $item->update();
            if ($request->hasFile('photo')) {
                if ($item->photo)
                {
                    $old_path = $item->photo->path;
                    File::delete($old_path);
                    $item->photo->delete();
                }
                $photo = new Photo();
                $photo->path = file_store($request->photo, 'source/asset/uploads/service/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                $item->photo()->save($photo);
            }
                //            if ($request->hasFile('file')) {
                //                if ($item->file)
                //                {
                //                    $old_path = $item->file->path;
                //                    File::delete($old_path);
                //                    $item->file->delete();
                //                }
                //                $file = new Filep();
                //                $file->path = file_store($request->file, 'source/asset/uploads/service/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/files/', 'file-');;
                //                $item->file()->save($file);
                //            }
            return redirect()->route('admin.service.list')->with('flash_message', 'خدمت با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function destroy($id) {
        $item = Service::where('user_id',$this->user_id())->findOrFail($id);
        try {
            if(count($item->join)) {
                return redirect()->back()->withInput()->with('err_message', 'خدمت در پکیج تعریف شده و قابل حذف نمی باشد');
            }
            $item->delete();
            return redirect()->back()->with('flash_message', 'خدمت با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function active($id, $type) {
        $item = Service::where('user_id',$this->user_id())->findOrFail($id);
        try {
            $item->status = $type;
            $item->update();
            if ($type == 'pending') {
                return redirect()->back()->with('flash_message', 'نمایش خدمت با موفقیت غیرفعال شد.');
            }
            if ($type == 'active') {
                return redirect()->back()->with('flash_message', 'نمایش خدمت با موفقیت فعال شد.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در تغییر وضعیت خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function learn_index() {
        $items = Service::where('category_id',4)->paginate($this->controller_paginate());
        return view('admin.service.learn.index', compact('items'), ['title1' => 'خدمات', 'title2' => $this->controller_title('sum')]);
    }
    public function learn_create() {
        $items = ServiceCat::where('id','=',4)->get();
        return view('admin.service.learn.create',compact('items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function learn_store(Request $request) {
        $this->validate($request, [
            'category_id' => 'required',
            'title' => 'required|max:240',
            'slug' => 'required|max:250|unique:services',
            'text' => 'required',
            'price' => 'required',
            'photo' => 'required|image|mimes:jpeg,jpg,png|max:5120',
            'file' => 'nullable|mimes:pdf|max:30720',
            'video' => 'nullable|mimes:mp4|max:51200',
        ],
            [
                'category_id.required' => 'لطفا دسته بندی خدمت را انتخاب کنید',
                'title.required' => 'لطفا عنوان خدمت را وارد کنید',
                'title.max' => 'عنوان خدمت  نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
                'text.required' => 'لطفا توضیحات را وارد کنید',
                'price.required' => 'لطفا هزینه را وارد کنید',
                'photo.required' => 'لطفا یک تصویر انتخاب کنید',
                'photo.image' => 'لطفا یک تصویر انتخاب کنید',
                'photo.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                'file.mimes' => 'لطفا یک فایل با پسوند (pdf) انتخاب کنید',
                'file.max' => 'لطفا حجم فایل حداکثر 30 مگابایت باشد',
                'video.mimes' => 'لطفا یک ویدئو با پسوند (mp4) انتخاب کنید',
                'video.max' => 'لطفا حجم ویدئو حداکثر 50 مگابایت باشد',
            ]);
        try {
            $item = new Service();
            $item->category_id = $request->category_id;
            $item->title = $request->title;
            $item->slug = $request->slug;
            $item->text = $request->text;
            $item->time_start = $request->time_start;
            $item->time_end = $request->time_end;
            $item->time = $request->time;
            //            $item->info_plus = $request->info_plus;
            $item->limited = $request->limited;
            $item->price = $request->price;
            $item->save();
            if ($request->hasFile('photo')) {
                $photo = new Photo();
                $photo->path = file_store($request->photo, 'source/asset/uploads/service/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                $item->photo()->save($photo);
                img_resize(
                    $photo->path, //address img
                    $photo->path, //address save
                    500,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );
            }
            if ($request->hasFile('file')) {
                $file = new Filep();
                $file->path = file_store($request->file, 'source/asset/uploads/service/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/files/', 'file-');;
                $item->file()->save($file);
            }
            if ($request->hasFile('video')) {
                $video = new Video();
                $video->path = file_store($request->video, 'source/asset/uploads/service/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/videos/', 'video-');;
                $item->video()->save($video);
            }
            return redirect()->route('admin.service.learn.list')->with('flash_message', ' خدمت با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function learn_edit($id) {
        $items = ServiceCat::where('id','=',4)->get();
        $item = Service::where('user_id',auth()->user()->id)->findOrFial($id);
        return view('admin.service.learn.edit', compact('items','item'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }
    public function learn_update(Request $request, $id) {
        $this->validate($request, [
            'category_id' => 'required',
            'title' => 'required|max:240',
            'slug' => 'required|max:250|unique:services,slug,'.$id,
            'text' => 'required',
            'price' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
            'file' => 'nullable|mimes:pdf|max:30720',
            'video' => 'nullable|mimes:mp4|max:51200',
        ],
            [
                'category_id.required' => 'لطفا دسته بندی خدمت را انتخاب کنید',
                'title.required' => 'لطفا عنوان خدمت را وارد کنید',
                'title.max' => 'عنوان خدمت  نباید بیشتر از 240 کاراکتر باشد',
                'slug.required' => 'لطفا نامک را وارد کنید',
                'slug.max' => 'نامک نباید بیشتر از 250 کاراکتر باشد',
                'slug.unique' => ' نامک وارد شده یکبار ثبت شده',
                'text.required' => 'لطفا توضیحات را وارد کنید',
                'price.required' => 'لطفا هزینه را وارد کنید',
                'photo.image' => 'لطفا یک تصویر انتخاب کنید',
                'photo.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
                'file.mimes' => 'لطفا یک فایل با پسوند (pdf) انتخاب کنید',
                'file.max' => 'لطفا حجم فایل حداکثر 30 مگابایت باشد',
                'video.mimes' => 'لطفا یک ویدئو با پسوند (mp4) انتخاب کنید',
                'video.max' => 'لطفا حجم ویدئو حداکثر 50 مگابایت باشد',
            ]);
        $item = Service::find($id);
        try {
            $item->category_id = $request->category_id;
            $item->title = $request->title;
            $item->slug = $request->slug;
            $item->text = $request->text;
            $item->time_start = $request->time_start;
            $item->time_end = $request->time_end;
            $item->time = $request->time;
            //            $item->info_plus = $request->info_plus;
            $item->limited = $request->limited;
            $item->price = $request->price;
            $item->update();
            if ($request->hasFile('photo')) {
                if ($item->photo)
                {
                    $old_path = $item->photo->path;
                    File::delete($old_path);
                    $item->photo->delete();
                }
                $photo = new Photo();
                $photo->path = file_store($request->photo, 'source/asset/uploads/service/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                $item->photo()->save($photo);
                img_resize(
                    $photo->path, //address img
                    $photo->path, //address save
                    500,// width: if width==0 -> width=auto
                    0 // height: if height==0 -> height=auto
                // end optimaiz
                );
            }
            if ($request->hasFile('file')) {
                if ($item->file)
                {
                    $old_path = $item->file->path;
                    File::delete($old_path);
                    $item->file->delete();
                }
                $file = new Filep();
                $file->path = file_store($request->file, 'source/asset/uploads/service/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/files/', 'file-');;
                $item->file()->save($file);
            }
            if ($request->hasFile('video')) {
                if ($item->video)
                {
                    $old_path = $item->video->path;
                    File::delete($old_path);
                    $item->video->delete();
                }
                $video = new Video();
                $video->path = file_store($request->video, 'source/asset/uploads/service/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/videos/', 'video-');;
                $item->video()->save($video);
            }
            return redirect()->route('admin.service.learn.list')->with('flash_message', 'خدمت با موفقیت ویرایش شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ویرایش خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function learn_destroy($id) {
        $item = Service::find($id);
        try {
            if(count($item->join))
            {
                return redirect()->back()->withInput()->with('err_message', 'خدمت در پکیج تعریف شده و قابل حذف نمی باشد');
            }
            $item->delete();
            return redirect()->back()->with('flash_message', 'خدمت با موفقیت حذف شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در حذف خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function learn_active($id, $type) {
        $item = Service::find($id);
        try {
            $item->status = $type;
            $item->update();
            if ($type == 'pending') {
                return redirect()->back()->with('flash_message', 'نمایش خدمت با موفقیت غیرفعال شد.');
            }
            if ($type == 'active') {
                return redirect()->back()->with('flash_message', 'نمایش خدمت با موفقیت فعال شد.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در تغییر وضعیت خدمت بوجود آمده،مجددا تلاش کنید');
        }
    }
    public function order($from, $to ,Request $request) {
        $itemf = Service::where('id',$from)->first();
        $from_order = $itemf->order;
        $itemf->order = rand(11111111,99999999)+$itemf->id;
        $itemf->save();

        $item = Service::where('id',$to)->first();
        $to_order = $item->order;
        $item->order = $from_order;
        $item->save();

        $item = Service::where('id',$from)->first();
        $item->order = $to_order;
        $item->save();

        return redirect()->back()->withInput();
    }
}


