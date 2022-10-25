<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Model\Filep; 
use App\Model\ProvinceCity;
use App\Model\Slider;
use App\Model\ServiceCat;
use App\Model\Photo;
use App\Model\Custom;
use App\Model\About;
use App\Model\Setting;
use App\Model\ServiceBuy;
use App\Model\ServiceFactor;
use App\Model\ServicePlus;
use App\Model\ServicePlusBuy;
use App\Model\ServicePackagePrice;
use Illuminate\Support\Facades\Auth;
use App\Model\ServicePluse;
use App\Model\Testr;
use Illuminate\Support\Facades\Cookie;


class TourismController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return 'تورهای گردشگری';
        } elseif ('single') {
            return 'تور گردشگری';
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
        $tours = ServicePluse::orderByDesc('id')->paginate($this->controller_paginate());
        return view('admin.content.tourism.index', compact('tours'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
        
    }

    public function create()
    {
        return view('admin.content.tourism.create', ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }

    public function store(Request $request)
    {
        $tour = new ServicePluse();
        $tour->title            = $request->title;
        $tour->slug             = $request->slug;
        $tour->status           = $request->status;
        $tour->price            = $request->price;
        $tour->start_tour       = $request->start_tour;
        $tour->move_time        = $request->move_time;
        $tour->location         = $request->location;
        $tour->back_time        = $request->back_time;
        $tour->accessories      = $request->accessories;
        $tour->residence        = $request->residence;
        $tour->car_type         = $request->car_type;
        $tour->capacity         = $request->capacity;
        $tour->options          = $request->options;
        $tour->hard_level       = $request->hard_level;
        $tour->description      = $request->description;
        $tour->save();
        return redirect()->route('admin.ads-tours.edit',$tour->id);
    }

    public function show($id)
    {
        $tour = ServicePluse::findOrFail($id);
        if ($tour->status=='active') {
            $tour->status = 'pending';
        } else {
            $tour->status = 'active';
        }
        $tour->save();
        return redirect()->route('admin.ads-tours.index');
    }

    public function edit($id)
    {
        $tour = ServicePluse::findOrFail($id);
        $photos = '';
        return view('admin.content.tourism.edit', compact('tour', 'photos'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }

    public function update(Request $request, $id)
    {
        $tour = ServicePluse::findOrFail($id);
        $tour->title            = $request->title;
        $tour->slug             = $request->slug;
        $tour->status           = $request->status;
        $tour->price            = $request->price;
        $tour->start_tour       = $request->start_tour;
        $tour->move_time        = $request->move_time;
        $tour->location         = $request->location;
        $tour->back_time        = $request->back_time;
        $tour->accessories      = $request->accessories;
        $tour->residence        = $request->residence;
        $tour->car_type         = $request->car_type;
        $tour->capacity         = $request->capacity;
        $tour->options          = $request->options;
        $tour->hard_level       = $request->hard_level;
        $tour->description      = $request->description;
        $tour->save();
        return redirect()->route('admin.ads-tours.index');
    }

    public function destroy($id)
    {
        $tour = ServicePluse::findOrFail($id)->delete();
        return redirect()->route('admin.ads-tours.index');
    }
}