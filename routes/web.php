<?php
use Illuminate\Support\Facades\Route;
use App\Model\ProvinceCity;
use Intervention\Image\ImageManagerStatic as Image;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// test register

Auth::routes(['register' => false]);

Route::get('/', function () {
    return redirect()->route('user.index');
});

Route::get('/fakeLog/{id}', function ($id) {
    auth()->loginUsingId($id, true);
    return redirect()->route('user.index');
});

Route::get('city-ajax/{id}', function ($id) {
    $city = ProvinceCity::where('parent_id', $id)->get();
    return $city;
});
Route::get('tests', function () {
   
});




