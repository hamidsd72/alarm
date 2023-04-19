<?php

namespace App\Http\Controllers\Admin;

use App\Model\FormPrice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormPriceController extends Controller {
    public function controller_title($type) {
        if ($type == 'sum') {
            return 'پکیج ها';
        } elseif ('single') {
            return 'مدیریت پکیج';
        }
    }
    
    public function __construct()
    {
        $this->middleware(['auth','isSuperAdmin', 'SpecialUser']);
    } 

    public function index()
    {
        $items = FormPrice::all();
        return view('admin.form-price.index', compact('items'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }

    public function create()
    {
        return view('admin.form-price.create', ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }

    public function edit($id)
    {
        $item = FormPrice::findOrFail($id);
        return view('admin.form-price.edit', compact('item'), ['title1' => $this->controller_title('single'), 'title2' => $this->controller_title('sum')]);
    }

    public function store(Request $request)
    {
        FormPrice::create($request->all());
        return redirect()->route('admin.form-price.index');
    }

    public function update(Request $request, $id)
    {
        $item = FormPrice::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('admin.form-price.index');
    }

    public function destroy($id)
    {
        FormPrice::findOrFail($id)->delete();
        return back();
    }
    
}
