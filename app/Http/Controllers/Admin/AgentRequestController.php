<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\ProvinceCity;
use App\Model\Photo;
use App\Model\Sms;
use App\Model\Agent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AgentRequestController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return 'لیست درخواست نمایندگی';
        } elseif ('single') {
            return 'نمایندگی';
        }
    }

    public function controller_paginate()
    {
        $settings = Setting::select('paginate')->latest()->firstOrFail();
        return $settings->paginate;
    }

    public function __construct()
    {
        $this->middleware(['auth','isAdmin','SpecialUser']);
    }

    public function index()
    {
        $items = Agent::where('status','pending')->orderBy('id','desc')->paginate($this->controller_paginate());
        return view('admin.user.agent.request.index', compact('items'), ['title1' => 'کاربران', 'title2' => $this->controller_title('sum')]);
    }
    public function show($id)
    {
        if (Auth::user()->hasRole('مدیر'))
        {
            $item = Agent::find($id);
            $seen=1;
            if($item->seen==0)
            {
                $seen=0;
                $item->seen=1;
                $item->update();
            }
        }
        else {
            abort(404);
        }
        return view('admin.user.agent.request.show', compact('item','seen'), ['title1' => 'کاربران', 'title2' => 'مشخصات درخواست دهنده نمایندگی']);
    }
    public function status($type , $id)
    {
        if (Auth::user()->hasRole('مدیر'))
        {
            $item = Agent::find($id);
            if ($type=='canceled'){
                $item->status='canceled';
                $item->update();
                return redirect()->route('admin.agent.request.list')->with('flash_message', 'درخواست نمایندگی رد شد');
                }
            elseif ($type=='active'){
                $states = ProvinceCity::where('parent_id', null)->get();
                return view('admin.user.agent.request.edit', compact('states','item'), ['title1' => 'کاربران', 'title2' => 'افزودن نماینده']);
                }


        }
        else {
            abort(404);
        }
        return view('admin.user.agent.request.show', compact('item','seen'), ['title1' => 'کاربران', 'title2' => 'مشخصات درخواست دهنده نمایندگی']);
    }
    public function active(Request $request,$id)
    {
        $this->validate($request, [
            'first_name' => 'required|max:240',
            'last_name' => 'required|max:240',
            'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric|unique:users',
            'email' => 'required|email|unique:users',
            'abbreviation' => 'required|unique:agents',
            'company_name' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'locate' => 'required',
            'address' => 'required',
            'password' => 'required|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
        ],
            [
                'first_name.required' => 'لطفا نام خود را وارد کنید',
                'first_name.max' => 'نام نباید بیشتر از 240 کاراکتر باشد',
                'last_name.required' => 'لطفا نام خانوادگی خود را وارد کنید',
                'last_name.max' => 'نام خانوادگی نباید بیشتر از 240 کاراکتر باشد',
                'mobile.required' => 'لطفا موبایل خود را وارد کنید',
                'mobile.regex' => 'لطفا موبایل خود را وارد کنید',
                'mobile.digits' => 'لطفا فرمت موبایل را رعایت کنید',
                'mobile.numeric' => 'لطفا موبایل خود را بصورت عدد وارد کنید',
                'mobile.unique' => 'موبایل وارد شده یکبار ثبت نام شده',
                'email.required' => 'لطفا ایمیل خود را وارد کنید',
                'email.email' => 'فرمت ایمیل را رعایت کنید',
                'email.unique' => ' ایمیل وارد شده یکبار ثبت نام شده',
                'abbreviation.required' => 'لطفا کد اختصاری خود را وارد کنید',
                'abbreviation.required' => 'لطفا کد اختصاری خود را وارد کنید',
                'abbreviation.unique' => ' کد اختصاری وارد شده یکبار ثبت نام شده',
                'whatsapp.required' => 'لطفا شماره واتساپ فعال خود را وارد کنید',
                'date_birth.required' => 'لطفا تاریخ تولد خود را وارد کنید',
                'state_id.required' => 'لطفا استان خود را وارد کنید',
                'city_id.required' => 'لطفا شهر خود را وارد کنید',
                'locate.required' => 'لطفا منطقه خود را وارد کنید',
                'address.required' => 'لطفا آدرس خود را وارد کنید',
                'education.required' => 'لطفا مدرک تحصیلی خود را وارد کنید',
                'password.required' => 'لطفا رمز عبور خود را وارد کنید',
                'password.min' => 'رمز عبور نباید کمتر از 6 کاراکتر باشد',
                'password.confirmed' => 'رمز عبور با تکرار آن برابر نیست',
                'photo.image' => 'لطفا یک تصویر انتخاب کنید',
                'photo.mimes' => 'لطفا یک تصویر با پسوندهای (png,jpg,jpeg) انتخاب کنید',
                'photo.max' => 'لطفا حجم تصویر حداکثر 5 مگابایت باشد',
            ]);
        try {
            $item = new User();
            $item->first_name = $request->first_name;
            $item->last_name = $request->last_name;
            $item->mobile = $request->mobile;
            $item->email = $request->email;
            $item->state_id = $request->state_id;
            $item->city_id = $request->city_id;
            $item->locate = $request->locate;
            $item->address = $request->address;
            $item->password = $request->password;
            $item->reagent_id =$request->abbreviation.'_'. time();
            $item->abbreviation_agent =$request->abbreviation;
            $item->mobile_status = 'active';
            $item->email_status = 'active';
            $item->user_status = 'active';
            $item->reagent_code = Auth::user()->reagent_id;
            $item->save();
            $item->assignRole('نماینده');
            if ($request->hasFile('photo')) {
                $photo = new Photo();
                $photo->path = file_store($request->photo, 'source/asset/uploads/user/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');;
                $item->photo()->save($photo);
                img_resize(
                    $photo->path,//address img
                    $photo->path,//address save
                    100,// width: if width==0 -> width=auto
                    100// height: if height==0 -> height=auto
                // end optimaiz
                );
            }
            $agent=Agent::find($id);
            $agent->first_name = $request->first_name;
            $agent->last_name = $request->last_name;
            $agent->mobile = $request->mobile;
            $agent->company_name=$request->company_name;
            $agent->abbreviation=$request->abbreviation;
            $agent->web_site=$request->web_site;
            $agent->status='active';
            $agent->user_id=$item->id;
            $agent->update();
            return redirect()->route('admin.agent.list')->with('flash_message', 'نماینده با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد نماینده بوجود آمده،مجددا تلاش کنید');
        }
    }

}


