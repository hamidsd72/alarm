<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Transaction;
use App\Model\ServiceFactor;
use App\Model\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class TransactionController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return ' لیست تراکنش های موفق';
        } elseif ('single') {
            return ' تراکنش های موفق';
        }
    }

    public function controller_title2($type)
    {
        if ($type == 'sum') {
            return ' لیست تراکنش های نا موفق';
        } elseif ('single') {
            return ' تراکنش های نا موفق';
        }
    }

    public function controller_paginate()
    {
        $settings = Setting::select('paginate')->latest()->firstOrFail();
        return $settings->paginate;
    }

    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function index()
    {
        if (Auth::user()->hasRole('مدیر'))
        {
            $items = Transaction::where('belongs_to_user', auth()->user()->id)->where('status',100)->orderByDesc('id')->paginate($this->controller_paginate());
            $all_price1 = Transaction::where('status',100)->sum('amount');
            $all_count1 = Transaction::where('status',100)->count();
            $all_price0 = Transaction::where('status', '!=', 100)->sum('amount');
            $all_count0 = Transaction::where('status', '!=', 100)->count();
            return view('admin.report.transaction.index', compact('items','all_price1','all_price0','all_count1','all_count0'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
        }
        $items = Transaction::where('user_id', auth()->user()->id)->where('status',100)->orderByDesc('id')->paginate($this->controller_paginate());
        return view('user.transaction.index', compact('items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }

    public function create()
    {
        $items = Transaction::where('belongs_to_user', auth()->user()->id)->where('status', '!=', 100)->orderByDesc('id')->paginate($this->controller_paginate());
        $all_price1 = Transaction::where('status',100)->sum('amount');
        $all_count1 = Transaction::where('status',100)->count();
        $all_price0 = Transaction::where('status', '!=', 100)->sum('amount');
        $all_count0 = Transaction::where('status', '!=', 100)->count();
        return view('admin.report.transaction.index', compact('items','all_price1','all_price0','all_count1','all_count0'), ['title1' => $this->controller_title2('single'), 'title2' => $this->controller_title2('sum')]);
    }

    public function search(Request $request)
    {
        // if(is_null($request->order))
        // {
        //     $items = Transaction::where('type','factor')->orderBy('id','desc');
        // }else{
        //     $items = Transaction::where('type','factor')->orderBy('total',$request->order);
        // }
 
        // if(!is_null($request->mobile))
        // {
        //     $user_id=User::where('mobile','Like','%'.$request->mobile.'%')->select('id')->get()->toArray();
        //     $items=$items->wherein('user_id',$user_id);
        // }
        // if(!is_null($request->code_bank))
        // {
        //     $items=$items->where('transaction_id','LIKE','%'.$request->code_bank.'%');
        // }
        // if(!is_null($request->code_factor))
        // {
        //     $factor_id=ServiceFactor::where('order_code','Like','%'.$request->code_factor.'%')->select('id')->get()->toArray();
        //     $items=$items->wherein('factor_id',$factor_id);
        // }
        // if(!is_null($request->status))
        // {
        //     $items=$items->where('status',intval($request->status));
        // }
        // $all_count = $items=$items->count();
        // $all_price = $items=$items->sum('total');
        // $all_count1 = $items=$items->where('status',1)->count();
        // $all_price1 = $items=$items->where('status',1)->sum('total');
        // $all_count0 = $items=$items->where('status',0)->count();
        // $all_price0 = $items=$items->where('status',0)->sum('total');
        // $items=$items->paginate($this->controller_paginate());
        // return view('admin.report.transaction.index',compact('items','all_price','all_price1','all_price0','all_count','all_count1','all_count0'), ['title1' => 'گزارشات', 'title2' => 'جستجو گزارشات']);
        if (Auth::user()->hasRole('مدیر'))
        {
            if ($request->status) {
                $items = Transaction::where('status', 100)->orderByDesc('id');
            } else {
                $items = Transaction::where('status', '!=', 100)->orderByDesc('id');
            }
            $all_price1 = Transaction::where('status',100)->sum('amount');
            $all_count1 = Transaction::where('status',100)->count();
            $all_price0 = Transaction::where('status', '!=', 100)->sum('amount');
            $all_count0 = Transaction::where('status', '!=', 100)->count();
            if ($request->mobile) {
                try {
                    $items = $items->where('user_id', User::where('mobile', $request->mobile)->first()->id);
                } catch (\Throwable $th) {
                    return redirect()->back()->withInput()->with('err_message','شماره یافت نشد');
                }
            }
            if ($request->code_bank) {
                $items = $items->where('confirmtransactionnumber', $request->code_bank);
            }
            $items = $items->paginate($this->controller_paginate());
            return view('admin.report.transaction.index', compact('items','all_price1','all_price0','all_count1','all_count0'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
        }
        return abort(503);
    }

}


