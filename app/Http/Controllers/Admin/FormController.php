<?php

namespace App\Http\Controllers\Admin;

use App\Model\Setting;
use App\Model\UserForm;
use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class FormController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return ' فرم ها و قرارداد ها';
        } elseif ('single') {
            return ' فرم و قرارداد';
        }
    }
    
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function controller_paginate()
    {
        $settings = Setting::select('paginate')->latest()->firstOrFail();
        return $settings->paginate;
    }

    public function show($id)
    {
        switch ($id) {
            case 1:
                $form_type = 'فورم عریضه';
                break; 
            case 2:
                $form_type = 'فورم حقوقی';
                break;
            case 3:
                $form_type = 'قرارداد عمومی';
                break;
            case 4:
                $form_type = 'قرارداد اختصاصی';
                break;
            case 5:
                $form_type = 'فرم استعدادیابی';
                break;
            case 6:
                $form_type = 'عقد قرارداد';
                break;
            case 7:
                $form_type = 'قرارداد عمومی';
                break;
            case 8:
                $form_type = 'قرارداد عمومی';
                break; 
        }
        $items = UserForm::where('pay_status', 'active')->where('form_type', $form_type)->orderByDesc('id')->paginate($this->controller_paginate());
        if ( $id == 7 ) {
            $items = UserForm::where('pay_status', 'active')->where('form_type', $form_type)->where('form_type', '!=', null)->orderByDesc('id')->paginate($this->controller_paginate());
            $form_type = $form_type.' حقوقی ';
        } elseif ( $id == 8 ) {
            $items = UserForm::where('pay_status', 'active')->where('form_type', $form_type)->where('form_type', null)->orderByDesc('id')->paginate($this->controller_paginate());
            $form_type = $form_type.' ویزا ';
        }
        return view('admin.admin-form.index', compact('items'), ['title1' => $form_type, 'title2' => $form_type]);
    }

    public function edit($id)
    {
        $item = UserForm::findOrFail($id);
        return view('admin.admin-form.show', compact('item'), ['title1' => $item->form_type, 'title2' =>$item->form_type]);
    }

    public function update(Request $request, $id)
    {
        $form = UserForm::findOrFail($id);
        if ($request->first_name) {
            $form->first_name       = $request->first_name ;
        }
        if ($request->last_name) {
            $form->last_name        = $request->last_name ;
        }
        if ($request->child) {
            $form->child            = $request->child ;
        }
        if ($request->code_meli) {
            $form->code_meli        = $request->code_meli ;
        }
        if ($request->address) {
            $form->address          = $request->address ;
        }
        if ($request->ashnaie) {
            $form->ashnaie          = $request->ashnaie ;
        }
        if ($request->moaref) {
            $form->moaref           = $request->moaref ;
        }
        if ($request->sabeghe_vekalat) {
            $form->sabeghe_vekalat  = $request->sabeghe_vekalat ;
        }
        if ($request->description) {
            $form->description      = $request->description ;
        }
        if ($request->birthday) {
            $form->birthday         = $request->birthday ;
        }
        if ($request->education) {
            $form->education        = $request->education ;
        }
        if ($request->visa_type) {
            $form->visa_type        = $request->visa_type ;
        }
        if ($request->whatsapp) {
            $form->whatsapp         = $request->whatsapp ;
        }
        if ($request->job) {
            $form->job              = $request->job ;
        }
        if ($request->bimeh) {
            $form->bimeh            = $request->bimeh ;
        }
        if ($request->en_lang) {
            $form->en_lang          = $request->en_lang ;
        }
        if ($request->en_level) {
            $form->en_level         = $request->en_level ;
        }
        if ($request->gr_lang) {
            $form->gr_lang          = $request->gr_lang ;
        }
        if ($request->gr_level) {
            $form->gr_level         = $request->gr_level ;
        }
        if ($request->count) {
            $form->count            = $request->count ;
        }
        if ($request->nesbat) {
            $form->nesbat           = $request->nesbat ;
        }
        if ($request->reject) {
            $form->reject           = $request->reject ;
        }
        if ($request->monthly_amount) {
            $form->monthly_amount   = $request->monthly_amount ;
        }
        if ($request->all_amount) {
            $form->all_amount       = $request->all_amount ;
        }
        if ($request->form_type ) {
            $form->form_type        = $request->form_type ;
        }
        if ($request->status) {
            $form->status           = $request->status ;
        }
        // $form->user_id          = auth()->user()->id ;
        $form->save();
        return redirect()->route('user.forms.index');
        // $this->validate($request, [
        //     'title' => 'required|max:240',
        //     'description' => 'required',
        //     'attachs.*' => 'nullable|max:10240',
        // ],
        //     [
        //         'title.required' => 'لطفا عنوان را وارد کنید',
        //         'title.max' => 'عنوان  نباید بیشتر از 240 کاراکتر باشد',
        //         'description.required' => 'لطفا توضیحات را وارد کنید',
        //         'attachs.*' => 'لطفا یک تصویر انتخاب کنید',
        //     ]);
        // try {
        //     $item = Ticket::create([
        //         'title' => $request->title,
        //         'description' => $request->description,
        //         'priority' => $request->priority,
        //         'create_user_id' => Auth::user()->id,
        //     ]);
        //     if ($request->hasFile('attachs')) {
        //         foreach ($request->attachs as $key=> $value)
        //         {
        //             $file = new Filep();
        //             $file->path = file_store1($value, 'source/asset/uploads/ticket/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/ticket/', 'ticket-');;
        //             $item->files()->save($file);
        //         }
        //     }
        //     return redirect()->route('admin.ticket.index')->with('flash_message', 'اطلاعات با موفقیت افزوده شد');
        // } catch (\Exception $e) {
        //     return redirect()->back()->withInput()->with('err_message', 'برای افزودن به مشکل خوردیم، مجدد تلاش کنید');
        // }
    }

}
