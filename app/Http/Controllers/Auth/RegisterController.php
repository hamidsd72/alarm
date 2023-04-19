<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Model\Sms;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'f_name' => ['required', 'string', 'max:255'],
            'l_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable','string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'numeric','unique:users',],
            'whatsapp' => ['required', 'numeric'],
            'state_id' => ['required', 'numeric'],
            'city_id' => ['required', 'numeric'],
            'locate' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'date_birth' => ['required', 'string', 'max:255'],
            'education' => ['required', 'string', 'max:255'],

            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    public function create()
    {
        return 'صفحه ثبت نام';
    }

    public function store(Request $request) {
        $this->validate($request, [
            'company_name' => 'max:240',
            'first_name' => 'required|max:240',
            'last_name' => 'required|max:240',
            'mobile' => 'required|regex:/(09)[0-9]{9}/|digits:11|numeric|unique:users',
            'email' => 'required|email|unique:users',
            // 'whatsapp' => 'required',
            'reagent_code' => 'integer',
            // 'date_birth' => 'required',
            // 'state_id' => 'required',
            // 'city_id' => 'required',
            // 'locate' => 'required',
            // 'address' => 'required',
            // 'education' => 'required',
            'password' => 'required|min:6|confirmed',
            'photo' => 'nullable|image|mimes:jpeg,jpg,png|max:5120',
        ],
        [
            'first_name.required' => 'لطفا نام خود را وارد کنید',
            'first_name.max' => 'نام نباید بیشتر از 240 کاراکتر باشد',
            'company_name.max' => 'نام شرکت نباید بیشتر از 240 کاراکتر باشد',
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
            'whatsapp.required' => 'لطفا شماره واتساپ فعال خود را وارد کنید',
            'reagent_code.integer' => 'مبلغ حقوق ساعتی را به عدد وارد کنید',
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
            $item->company_name = $request->company_name;
            $item->first_name   = $request->first_name;
            $item->last_name    = $request->last_name;
            $item->mobile       = $request->mobile;
            $item->email        = $request->email;
            $item->whatsapp     = $request->whatsapp;
            $item->date_birth   = num_to_en($request->date_birth);
            $item->state_id     = $request->state_id;
            $item->city_id      = $request->city_id;
            $item->locate       = $request->locate;
            $item->address      = $request->address;
            $item->education    = $request->education;
            $item->password     = $request->password;
            $item->reagent_code = $request->reagent_code;
            $item->employee_id  = $request->employee_id;
            $item->join_date    = $request->join_date;
            $item->reagent_id   = $this->user_id();
            $item->special_user = \Carbon\Carbon::now()->addWeek();
            $item->save();

            $item->assignRole('مدیر');

            $setting = new Setting();
            $setting->user_id       = $item->id;
            $setting->title         = $item->company_name;
            $setting->keyword       = 'هنوز وارد نشده';
            $setting->description   = 'هنوز وارد نشده';
            $setting->paginate      = 10;
            $setting->support_call  = $item->mobile;
            $setting->save();

            $about = new About();
            $about->user_id         = $item->id;
            $about->title_home      = ' درباره '.$item->company_name;
            $about->text_home       = ' توضیحات درباره '.$item->company_name;
            $about->save();
            
            if ($request->hasFile('photo')) {
                $photo = new Photo();
                $photo->path = file_store($request->photo, 'source/asset/uploads/user/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
                $item->photo()->save($photo);
                // img_resize(
                //     $photo->path,//address img
                //     $photo->path,//address save
                //     100,// width: if width==0 -> width=auto
                //     100// height: if height==0 -> height=auto
                // // end optimaiz
                // );
            }
            return redirect()->route('admin.user.list')->with('flash_message', 'کاربر با موفقیت ایجاد شد.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('err_message', 'مشکلی در ایجاد کاربر بوجود آمده،مجددا تلاش کنید');
        }
    }

}
