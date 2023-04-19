<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Model\Setting;
use App\Model\ServiceCat;
use App\Model\Service;
use App\Model\Photo;
use App\Model\Filep;
use App\Model\TourAlbum;
use App\Model\ServicePluse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AlbumController extends Controller
{
    public function controller_title($type)
    {
        if ($type == 'sum') {
            return ' تصاویر';
        } elseif ('single') {
            return ' تصویر';
        }
    }

    public function __construct()
    {
        $this->middleware(['auth', 'SpecialUser']);
    }

    public function show($id) 
    {
        $tour  = ServicePluse::findOrFail($id);
        $items = TourAlbum::where('file_id',$id)->get();
        return view('admin.content.tourism-album.index', compact('items','tour'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $album = new TourAlbum();
        $album->display     = true;
        $album->model_name  = 'App/ServicePluse';
        $album->file_id     = $request->id;
        if ($request->hasFile('photo')) {
            $album->path    = file_store($request->photo, 'source/asset/uploads/album/' . my_jdate(date('Y/m/d'), 'Y-m-d') . '/photos/', 'photo-');
            $album->save();
        }
        return back();
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $item = TourAlbum::findOrFail($id);
        if ($item->display) {
            $item->display = false;
        } else {
            $item->display = true;
        }
        $item->save();
        return back();
    }

    public function destroy($id)
    {
        $item = TourAlbum::findOrFail($id)->delete();
        return back();
    }

    
}


