<?php
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\User;
use App\Models\ModelSize;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use App\Models\Verify;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Exports\AwardsExport;
use App\Models\Exports\ClubUsersExport;
use App\Models\Exports\ClubBanUsersExport;
use App\Models\Exports\ClubCodesExport;
use App\Models\Sms;
use App\Models\Off;
use App\Models\Factor;
use App\Models\Modale;
use Ipecompany\Smsirlaravel\Smsirlaravel;
use App\Models\Exports\BasketsExport;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

Auth::routes();

//todo remove later
//fast login
Route::get('fast_login/{id}', function ($id) {
    $user = User::findOrFail($id);
    Auth::login($user);
    return redirect()->route('login');
});


Route::get('/tess', function () {
    return $baskets=\App\Models\Basket::where('status',1)->whereHas('modale')->groupBy('model_id')->distinct()->get();
    return auth()->user()->addresses;
    \Artisan::call('config:clear');
    return date('Y-m-d H:i:s');
    return \Carbon\Carbon::now();
    return cat_subsets_ids(['0'=>1]);
    return real_order_code();
    return convert2English('۱۲۳۴۵۶۷۸');
});
Route::get('/pay', function (){
    return \App\Models\Sms::ultraFastSendSms(['VerificationCode' => '12233'], 50127 , '09357960008');
    return \App\Models\Sms::sendUltra('09357960008',['VerificationCode'=>'1234'],50127);
});
Route::get('/test_sms', function (){
    dd(\App\Models\Sms::SendSms('تست ارسال پیامک' ,'09307347918'));
    return \App\Models\Sms::sendUltra('09357960008',['VerificationCode'=>'1234'],50127);
});

Route::get('design', function () {
    return view('products.detail');
});

Route::get('sms_test', function () {

//    $code=1234;
//    $mobile='09027107810';
//    Smsirlaravel::ultraFastSend(['code'=>$code],37878 ,$mobile);
//    dd('ok');

});
Route::get('category', function () {

    return view('products.category');

});

Route::post('logout', function (){
    auth()->logout();
    if (Cookie::has('basket')) {
        Cookie::queue(Cookie::forget('basket'));
    }
    if (Cookie::has('order_code')) {
        Cookie::queue(Cookie::forget('order_code'));
    }
    return redirect('/');
})->name('logout');
//Route::any('logout', function () {
//    Auth::logout();
//    return redirect()->route('front.index');
//});

//Route::post('login', 'Auth\LoginController@login')->name('login');

Route::get('/assignRole', function () {
    $user=User::find(4745);
    $user->assignRole('developer');
});
Route::get('/getRoles', function () {
    $user=User::find(1);
    $user->assignRole('مدیر');
    return $user->getRoleNames();
});
Route::get('/log323232/{id}', function ($id){
    $user=Auth::loginUsingId($id);
    if (auth()->user()->hasRole('مدیر')) {
    return redirect()->route('index');
    }
    return redirect()->route('index');
});
Route::get('/login_karbar/{id}/{admin_id?}', function ($id,$admin_id=null) {
    Auth::loginUsingId($id);
    if($admin_id==null)
    {
        session()->forget('admin_id');
    }
    else
    {
        session(['admin_id' => $admin_id]);
    }
    if (auth()->user()->hasRole('مدیر')) {
    return redirect()->route('index');
    }
    return redirect()->route('index');
})->name('login-list-user');

Route::post('filemanager/upload',function (Request $request ){
    if(isset($_FILES['upload']['name'])) {
        $file=$_FILES['upload']['name'];
        $filetmp=$_FILES['upload']['tmp_name'];
        $file_pas=explode('.',$file);
        $file_n='check_editor_'.time().'_'.$file_pas[0].'.'.end($file_pas);
        $photo=move_uploaded_file($filetmp,'source/assets/editor/upload/'.$file_n);

        $CKEditorFuncNum = $request->input('CKEditorFuncNum');
        $url = url('source/assets/editor/upload/'.$file_n);
        $msg = 'File uploaded successfully';
        $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

        @header('Content-type: text/html; charset=utf-8');
        echo $response;
    }
})->name('filemanager_upload');


Route::get('filemanager',function (Request $request ){
    $paths=glob('source/assets/editor/upload/*');
    $fileNames=array();
    foreach ($paths as $path)
    {
        array_push($fileNames,basename($path));
    }
    $data=array(
        'fileNames'=>$fileNames
    );
    return view('file_manager')->with($data);
})->name('filemanager');


//Route::group(['prefix' => 'panel', 'namespace' => 'Panel', 'middleware' => ['auth', 'isAdmin']], function () {
//
//    Route::get('/del', 'ProductController@deleteAll')->name('asdasd');
//    Route::get('invent', 'PanelController@invent')->name('invent-listt');
//    Route::get('invent-destroy/{invent}', 'PanelController@destroy')->name('invent-destroy');
//
//
//    Route::get('status/{id}', 'PanelController@status')->name('status');
//
//
//    // Club Excels
//    Route::get('club-award-excel', function () {
//        return Excel::download(new AwardsExport, 'factorsFromFirst.xlsx');
//    })->name('club-award-excel');
//    Route::get('club-users-excel', function () {
//        return Excel::download(new ClubUsersExport, 'ClubUsersFromFirst.xlsx');
//    })->name('club-users-excel');
//    Route::get('club-ban-users-excel', function () {
//        return Excel::download(new ClubBanUsersExport, 'ClubBanUsersFromFirst.xlsx');
//    })->name('club-ban-users-excel');
//    Route::get('club-codes-excel', function () {
//        return Excel::download(new ClubCodesExport, 'ClubCodesFromFirst.xlsx');
//    })->name('club-codes-excel');
//    Route::get('club-baskets-excel', function () {
//        return Excel::download(new BasketsExport, 'ClubBasketsFromFirst.xlsx');
//    })->name('club-baskets-excel');
//
//    //type
//    Route::get('type-user', 'Club\TypeController@index')->name('admin-type-list');
//    Route::post('type-user/update', 'Club\TypeController@update')->name('admin-type-update');
//
//
//    // user black
//
//    Route::get('club-black-user', 'Club\UserController@index')->name('admin-user-black');
//
//
//    // user ban
//
//    Route::get('club-ban-user', 'Club\UserController@ban')->name('admin-user-ban');
//
//    Route::get('club-ban-exit/{id}', 'Club\UserController@exitBan')->name('admin-club-ban-exit');
//
//
//    // basket club
//
//    Route::get('/basket/club', 'Club\basketClubController@index')->name('basket-club-page-list');
//
//    Route::get('/basket/club/one/{factor}', 'Club\basketClubController@successone')->name('basket-club-success-one');
//
//    Route::get('/basket/club/two/{factor}', 'Club\basketClubController@successtwo')->name('basket-club-success-two');
//
//    Route::get('/basket/club/three/{factor}', 'Club\basketClubController@successthree')->name('basket-club-success-three');
//
//    Route::get('/basket/club/four/{factor}', 'Club\basketClubController@successfour')->name('basket-club-success-four');
//
//    Route::get('/basket/club/delete/{factor}/{user_id}', 'Club\basketClubController@destroy')->name('basket-club-delete');
//    Route::post('export-excel-basket', 'BasketController@excel')->name('export-excel-basket');
//
//
//    // message
//
//    Route::get('club-message-list', 'Club\MessageController@index')->name('admin-user-message');
//
//    Route::get('club-message-create', 'Club\MessageController@create')->name('admin-club-message-create');
//
//    Route::post('club-message-store', 'Club\MessageController@store')->name('admin-club-message-store');
//
//    Route::post('club-message-edit', 'Club\MessageController@edit')->name('admin-club-message-edit');
//
//    Route::post('club-message-destroy/{id}', 'Club\MessageController@destroy')->name('admin-club-message-destroy');
//
//
//    // user wait
//
//    Route::get('club-wait-list', 'Club\WaitController@index')->name('admin-wait-message');
//
//    Route::get('club-wait-user/{id}', 'Club\WaitController@active')->name('admin-wait-active');
//
//    Route::post('club-wait-delete/{id}', 'Club\WaitController@active')->name('admin-wait-delete');
//
//
//
//
//
//    Route::get('excel/index', function () {
//        $code = \App\Models\ClubCode::orderBy('status', 'desc')->paginate(20);
//        return view('panel.excel.index', compact('code'));
//    })->name('excel-index');
//
//    Route::post('excel/insert', 'HomeController@excel')->name('excel');
//    Route::get('code/search', 'HomeController@serachCode')->name('search-code');
//
//    // index club
//
//    Route::get('/index/club', 'Club\indexController@index')->name('index-club-page-list');
//
//    Route::post('/index/club/update', 'Club\indexController@update')->name('index-club-success-one');
//
//
//    //user
//
//    Route::get('club-black-user-exit/{id}', 'Club\UserController@exits')->name('admin-club-user-exit');
//
//    Route::get('club-black-user-delete/{id}', 'Club\UserController@delete')->name('admin-club-user-delete');
//
//
//    Route::get('site/language', 'LanguageController@index')->name('site.language');
//    Route::get('language-create', 'LanguageController@create')->name('language.create');
//    Route::post('language-store', 'LanguageController@store')->name('language.store');
//    Route::get('language-edit/{id}', 'LanguageController@edit')->name('language.edit');
//    Route::patch('language-update/{id}', 'LanguageController@update')->name('language.update');
//
//    Route::delete('language-delete/{id}', 'LanguageController@destroy')->name('language.destroy');
//    // off
//    Route::get('off-create', 'OffController@create')->name('off-create');
//    Route::put('off-store', 'OffController@store')->name('off-store');
//    Route::get('off-list', 'OffController@index')->name('off-list');
//    Route::delete('off-destroy/{id}', 'OffController@destroy')->name('off-destroy');
//
//    //product vip
//    Route::get('product-vip-list', 'ProductVipController@index')->name('product-vip-list');
//    Route::get('product-vip-search', 'ProductVipController@search')->name('product-vip-search');
//    Route::post('product-vip-update/{id}', 'ProductVipController@update')->name('product-vip-update');
//    Route::post('slider-vip-update', 'ProductVipController@slider_update')->name('slider-vip-update');
//
//    //inventory
////    Route::get('bestselling-list', 'InventoryController@bestselling')->name('bestselling-list');
////    Route::get('inventory-list', 'InventoryController@index')->name('inventory-list');
//
////    Route::get('inventory-create/{id}', 'InventoryController@create')->name('inventory-create');
////    Route::put('inventory-store/{id}', 'InventoryController@store')->name('inventory-store');
////    Route::get('inventory-search', 'InventoryController@search')->name('inventory-search');
////    Route::post('inventory-update/{id}', 'InventoryController@update')->name('inventory-update');
////    Route::post('model-inventory-update/{id}', 'InventoryController@model_update')->name('model-inventory-update');
////
//
//    Route::post('factor-post-import', 'BasketController@postImport')->name('postImport');
//    Route::post('factor-delivery/{id}', 'BasketController@factor_delivery')->name('factor-delivery');
//// Basket
//    Route::get('basket-all', 'BasketController@all')->name('basket-all');
//    Route::get('user-info/{id}', 'BasketController@user_info')->name('user-info');
//    Route::get('export-excel-basket', 'BasketController@excel')->name('export-excel-basket');
//
//    //factor
////    Route::get('factor-list', 'FactorController@index')->name('factor-list');
////    Route::get('factor-create1', 'FactorController@create1')->name('factor-create');
////    Route::post('factor-store', 'FactorController@store')->name('factor-store');
////    Route::post('findProduct/{id}', 'FactorController@find')->name('findProduct');
////    Route::get('factor-list-export', 'FactorController@export')->name('factor-export');
////    Route::get('factor-view/{order_code}', 'FactorController@show')->name('factor-view');
////    Route::get('factors-cancel/{order_code}', 'FactorController@cancel')->name('factors-cancel');
//
//
//    Route::get('export-excel-byYear', 'DraftController@excelByYear')->name('export-excel-byYear');
//    Route::get('export-excel-byMonth', 'DraftController@excelByMonth')->name('export-excel-byMonth');
//    Route::get('export-excel-byDay', 'DraftController@excelByDay')->name('export-excel-byDay');
//
//
//
//
//
//    // work
//    Route::get('work-list', 'WorkController@index')->name('work-list');
//    Route::delete('work-destroy/{id}', 'WorkController@destroy')->name('work-destroy');
//    Route::get('work-show/{id}', 'WorkController@show')->name('work-show');
//
//
//
////    Route::get('no_pay-list', 'BasketController@no_pay')->name('factor-no_pay');
//
//
//
//
//
//
//    // provider
//    Route::get('provider-create', 'ProviderController@create')->name('provider-create');
//    Route::put('provider-store', 'ProviderController@store')->name('provider-store');
//    Route::get('provider-list', 'ProviderController@index')->name('provider-list');
//    Route::get('provider-show/{id}', 'ProviderController@show')->name('provider-show');
//    Route::get('provider-edit/{id}', 'ProviderController@edit')->name('provider-edit');
//    Route::patch('provider-update/{id}', 'ProviderController@update')->name('provider-update');
//
//
//
//    // word
//    Route::get('word-create', 'WordController@create')->name('word-create');
//    Route::put('word-store', 'WordController@store')->name('word-store');
//    Route::get('word-list', 'WordController@index')->name('word-list');
//    Route::delete('word-destroy/{id}', 'WordController@destroy')->name('word-destroy');
//
//
//
//
//
//
//    // type
//    Route::get('type-create', 'TypeController@create')->name('type-create');
//    Route::put('type-store', 'TypeController@store')->name('type-store');
//    Route::get('type-list', 'TypeController@index')->name('type-list');
//    Route::get('type-edit/{id}', 'TypeController@edit')->name('type-edit');
//    Route::patch('type-update/{id}', 'TypeController@update')->name('type-update');
//    Route::delete('type-destroy/{id}', 'TypeController@destroy')->name('type-destroy');
//
//    Route::get('typeAjax/{id}', 'TypeController@typeAjax')->name('typeAjax');
//
//    // contact
//    Route::get('contact-list', 'ContactController@index')->name('contact-list');
//    Route::delete('contact-destroy/{id}', 'ContactController@destroy')->name('contact-destroy');
//
//    // slider
//    Route::get('slider-create', 'SliderController@create')->name('slider-create');
//    Route::put('slider-store', 'SliderController@store')->name('slider-store');
//    Route::get('slider-list', 'SliderController@index')->name('slider-list');
//    Route::get('slider-edit/{id}', 'SliderController@edit')->name('slider-edit');
//    Route::patch('slider-update/{id}', 'SliderController@update')->name('slider-update');
//    Route::delete('slider-destroy/{id}', 'SliderController@destroy')->name('slider-destroy');
//
//
//    // resalat
//    Route::get('resalat-create/{id}', 'ResalatController@create')->name('resalat-create');
//    Route::post('resalat-store/{id}', 'ResalatController@store')->name('resalat-store');
//    Route::get('resalat-list', 'ResalatController@index')->name('resalat-list');
//    Route::delete('resalat-destroy/{id}', 'ResalatController@destroy')->name('resalat-destroy');
//
//    // Ad
//    Route::get('ad-create', 'AdController@create')->name('ad-create');
//    Route::put('ad-store', 'AdController@store')->name('ad-store');
//    Route::get('ad-list', 'AdController@index')->name('ad-list');
//    Route::delete('ad-destroy/{id}', 'AdController@destroy')->name('ad-destroy');
//
//
////    // categories
////    Route::get('category-create', 'CategoryController@create')->name('category-create');
////    Route::put('category-store', 'CategoryController@store')->name('category-store');
////    Route::get('category-list', 'CategoryController@index')->name('category-list');
////    Route::get('category-edit/{id}', 'CategoryController@edit')->name('category-edit');
////    Route::patch('category-update/{id}', 'CategoryController@update')->name('category-update');
////    Route::delete('category-destroy/{id}', 'CategoryController@destroy')->name('category-destroy');
////    Route::post('category-sort', 'CategoryController@sort_item')->name('category-sort');
//
//
//    // city
//    Route::get('city-create', 'CityController@create')->name('city-create');
//    Route::put('city-store', 'CityController@store')->name('city-store');
//    Route::get('city-list', 'CityController@index')->name('city-list');
//    Route::get('city-edit/{id}', 'CityController@edit')->name('city-edit');
//    Route::patch('city-update/{id}', 'CityController@update')->name('city-update');
//    Route::delete('city-destroy/{id}', 'CityController@destroy')->name('city-destroy');
//    Route::post('city-sort', 'CityController@sort_item')->name('city-sort');
//    Route::post('city-search', 'CityController@search')->name('city-search');
//    Route::post('city-free/{id}', 'CityController@city_free')->name('city-free-update');
//
//
//    //Product
//
//
//
//    //worked
//    Route::get('worked-create', 'WorkedController@create')->name('worked-create');
//    Route::put('worked-store', 'WorkedController@store')->name('worked-store');
//    Route::get('worked-list', 'WorkedController@index')->name('worked-list');
//    Route::get('worked-edit/{id}', 'WorkedController@edit')->name('worked-edit');
//    Route::patch('worked-update/{id}', 'WorkedController@update')->name('worked-update');
//    Route::delete('worked-destroy/{id}', 'WorkedController@destroy')->name('worked-destroy');
//
//
//
//    // categories
//    Route::get('gallery-category-create', 'GalleryCategoryController@create')->name('gallery-category-create');
//    Route::put('gallery-category-store', 'GalleryCategoryController@store')->name('gallery-category-store');
//    Route::get('gallery-category-list', 'GalleryCategoryController@index')->name('gallery-category-list');
//    Route::get('gallery-category-edit/{id}', 'GalleryCategoryController@edit')->name('gallery-category-edit');
//    Route::patch('gallery-category-update/{id}', 'GalleryCategoryController@update')->name('gallery-category-update');
//    Route::delete('gallery-category-destroy/{id}', 'GalleryCategoryController@destroy')->name('gallery-category-destroy');
//    Route::post('gallery-category-sort', 'GalleryCategoryController@sort_item')->name('gallery-category-sort');
//
//    //Gallery
//    Route::get('gallery-create', 'GalleryController@create')->name('gallery-create');
//    Route::put('gallery-store', 'GalleryController@store')->name('gallery-store');
//    Route::get('gallery-list', 'GalleryController@index')->name('gallery-list');
//    Route::get('gallery-edit/{id}', 'GalleryController@edit')->name('gallery-edit');
//    Route::patch('gallery-update/{id}', 'GalleryController@update')->name('gallery-update');
//    Route::delete('gallery-destroy/{id}', 'GalleryController@destroy')->name('gallery-destroy');
//
//
//    // video_cat
//    Route::get('video-cat-create', 'VideocatController@create')->name('video-cat-create');
//    Route::put('video-cat-store', 'VideocatController@store')->name('video-cat-store');
//    Route::get('video-cat-list', 'VideocatController@index')->name('video-cat-list');
//    Route::get('video-cat-edit/{id}', 'VideocatController@edit')->name('video-cat-edit');
//    Route::patch('video-cat-update/{id}', 'VideocatController@update')->name('video-cat-update');
//    Route::delete('video-cat-destroy/{id}', 'VideocatController@destroy')->name('video-cat-destroy');
//    Route::post('video-cat-sort', 'VideocatController@sort_item')->name('video-cat-sort');
//
//    //video
//    Route::get('video-create', 'VideoController@create')->name('video-create');
//    Route::put('video-store', 'VideoController@store')->name('video-store');
//    Route::get('video-list', 'VideoController@index')->name('video-list');
//    Route::get('video-edit/{id}', 'VideoController@edit')->name('video-edit');
//    Route::patch('video-update/{id}', 'VideoController@update')->name('video-update');
//    Route::delete('video-destroy/{id}', 'VideoController@destroy')->name('video-destroy');
//
//
//    // attribute
//    Route::get('attribute-create', 'AttributeController@create')->name('attribute-create');
//    Route::put('attribute-store', 'AttributeController@store')->name('attribute-store');
//    Route::get('attribute-list', 'AttributeController@index')->name('attribute-list');
//    Route::get('attribute-edit/{id}', 'AttributeController@edit')->name('attribute-edit');
//    Route::patch('attribute-update/{id}', 'AttributeController@update')->name('attribute-update');
//    Route::delete('attribute-destroy/{id}', 'AttributeController@destroy')->name('attribute-destroy');
//
//    // comparison
//    Route::get('comparison-create', 'ComparisonController@create')->name('comparison-create');
//    Route::put('comparison-store', 'ComparisonController@store')->name('comparison-store');
//    Route::get('comparison-list', 'ComparisonController@index')->name('comparison-list');
//    Route::get('comparison-edit/{id}', 'ComparisonController@edit')->name('comparison-edit');
//    Route::patch('comparison-update/{id}', 'ComparisonController@update')->name('comparison-update');
//    Route::delete('comparison-destroy/{id}', 'ComparisonController@destroy')->name('comparison-destroy');
//
//    //article_category
//    Route::get('article-category-create', 'ArticleCategoryController@create')->name('article-category-create');
//    Route::put('article-category-store', 'ArticleCategoryController@store')->name('article-category-store');
//    Route::get('article-category-list', 'ArticleCategoryController@index')->name('article-category-list');
//    Route::get('article-category-edit/{id}', 'ArticleCategoryController@edit')->name('article-category-edit');
//    Route::patch('article-category-update/{id}', 'ArticleCategoryController@update')->name('article-category-update');
//    Route::delete('article-category-destroy/{id}', 'ArticleCategoryController@destroy')->name('article-category-destroy');
//    Route::post('article-category-sort', 'ArticleCategoryController@sort_item')->name('article-category-sort');
//// News Route
//    Route::get('news-category-create', 'NewsCategoryController@create')->name('news-category-create');
//    Route::put('news-category-store', 'NewsCategoryController@store')->name('news-category-store');
//    Route::get('news-category-list', 'NewsCategoryController@index')->name('news-category-list');
//    Route::get('news-category-edit/{id}', 'NewsCategoryController@edit')->name('news-category-edit');
//    Route::patch('news-category-update/{id}', 'NewsCategoryController@update')->name('news-category-update');
//    Route::delete('news-category-destroy/{id}', 'NewsCategoryController@destroy')->name('news-category-destroy');
//    Route::post('news-category-sort', 'NewsCategoryController@sort_item')->name('news-category-sort');
//    // journal
//    Route::get('journal-create', 'JournalController@create')->name('journal-create');
//    Route::put('journal-store', 'JournalController@store')->name('journal-store');
//    Route::get('journal-list', 'JournalController@index')->name('journal-list');
//    Route::get('journal-edit/{id}', 'JournalController@edit')->name('journal-edit');
//    Route::patch('journal-update/{id}', 'JournalController@update')->name('journal-update');
//    Route::delete('journal-destroy/{id}', 'JournalController@destroy')->name('journal-destroy');
//
//    // news
//    Route::get('news-create', 'NewsController@create')->name('news-create');
//    Route::put('news-store', 'NewsController@store')->name('news-store');
//    Route::get('news-list', 'NewsController@index')->name('news-list');
//    Route::get('news-edit/{id}', 'NewsController@edit')->name('news-edit');
//    Route::patch('news-update/{id}', 'NewsController@update')->name('news-update');
//    Route::delete('news-destroy/{id}', 'NewsController@destroy')->name('news-destroy');
//
//
//    // footer
//    Route::get('footer-create', 'FooterController@create')->name('footer-create');
//    Route::put('footer-store', 'FooterController@store')->name('footer-store');
//    Route::get('footer-list', 'FooterController@index')->name('footer-list');
//    Route::get('footer-edit/{id}', 'FooterController@edit')->name('footer-edit');
//    Route::patch('footer-update/{id}', 'FooterController@update')->name('footer-update');
//    Route::delete('footer-destroy/{id}', 'FooterController@destroy')->name('footer-destroy');
//
//
//    // categories
//    Route::get('footer-category-create', 'FooterCategoryController@create')->name('footer-category-create');
//    Route::put('footer-category-store', 'FooterCategoryController@store')->name('footer-category-store');
//    Route::get('footer-category-list', 'FooterCategoryController@index')->name('footer-category-list');
//    Route::get('footer-category-edit/{id}', 'FooterCategoryController@edit')->name('footer-category-edit');
//    Route::patch('footer-category-update/{id}', 'FooterCategoryController@update')->name('footer-category-update');
//    Route::delete('footer-category-destroy/{id}', 'FooterCategoryController@destroy')->name('footer-category-destroy');
//    Route::post('footer-category-sort', 'FooterCategoryController@sort_item')->name('footer-category-sort');
//
//
//    // projects
//    Route::get('projects-create', 'ProjectsController@create')->name('projects-create');
//    Route::put('projects-store', 'ProjectsController@store')->name('projects-store');
//    Route::get('projects-list', 'ProjectsController@index')->name('projects-list');
//    Route::get('projects-edit/{id}', 'ProjectsController@edit')->name('projects-edit');
//    Route::patch('projects-update/{id}', 'ProjectsController@update')->name('projects-update');
//    Route::delete('projects-destroy/{id}', 'ProjectsController@destroy')->name('projects-destroy');
//    Route::get('projects-photo-delete/{id}', 'ProjectsController@destroyPhoto')->name('projects-photo-delete');
//
//
//    // prize
//    Route::get('prize-create', 'PrizeController@create')->name('prize-create');
//    Route::put('prize-store', 'PrizeController@store')->name('prize-store');
//    Route::get('prize-list', 'PrizeController@index')->name('prize-list');
//    Route::get('prize-edit/{id}', 'PrizeController@edit')->name('prize-edit');
//    Route::patch('prize-update/{id}', 'PrizeController@update')->name('prize-update');
//    Route::delete('prize-destroy/{id}', 'PrizeController@destroy')->name('prize-destroy');
//
//    //mk-ads
//    Route::get('ads-list', 'AdsController@index')->name('ads-list');
//    Route::get('ads-edit/{id}', 'AdsController@edit')->name('ads-edit');
//    Route::patch('ads-update/{id}', 'AdsController@update')->name('ads-update');
//
//
//
//
//
//    // question
//    Route::get('question-list', 'QuestionController@index')->name('question-list');
//    Route::any('question-confirm/{id}', 'QuestionController@confirm')->name('question-confirm');
//    Route::get('question-destroy/{id}', 'QuestionController@destroy')->name('question-destroy');
//
//
//    // viewpoint
//    Route::get('viewpoint-create', 'ViewpointController@create')->name('viewpoint-create');
//    Route::put('viewpoint-store', 'ViewpointController@store')->name('viewpoint-store');
//    Route::get('viewpoint-list', 'ViewpointController@index')->name('viewpoint-list');
//    Route::get('viewpoint-edit/{id}', 'ViewpointController@edit')->name('viewpoint-edit');
//    Route::patch('viewpoint-update/{id}', 'ViewpointController@update')->name('viewpoint-update');
//    Route::delete('viewpoint-destroy/{id}', 'ViewpointController@destroy')->name('viewpoint-destroy');
//
//
//
//    //db_category
//    Route::get('db-category-list', 'DbCategoryController@index')->name('db-category-list');
//
//    // bank
//    Route::get('bank-create', 'BankController@create')->name('bank-create');
//    Route::put('bank-store', 'BankController@store')->name('bank-store');
//    Route::get('bank-list', 'BankController@index')->name('bank-list');
//    Route::get('bank-edit/{id}', 'BankController@edit')->name('bank-edit');
//    Route::patch('bank-update/{id}', 'BankController@update')->name('bank-update');
//    Route::delete('bank-destroy/{id}', 'BankController@destroy')->name('bank-destroy');
//
//    // articleattribute
//    Route::get('article-attribute-create', 'ArticleAttributeController@create')->name('article-attribute-create');
//    Route::put('article-attribute-store', 'ArticleAttributeController@store')->name('article-attribute-store');
//    Route::get('article-attribute-list', 'ArticleAttributeController@index')->name('article-attribute-list');
//    Route::get('article-attribute-edit/{id}', 'ArticleAttributeController@edit')->name('article-attribute-edit');
//    Route::patch('article-attribute-update/{id}', 'ArticleAttributeController@update')->name('article-attribute-update');
//    Route::delete('article-attribute-destroy/{id}', 'ArticleAttributeController@destroy')->name('article-attribute-destroy');
//
//    // visitlog
//    Route::get('visitlogs', 'VisitlogController@index')->name('visitlogs');
//
//    // Design
//    Route::get('design', 'DesignController@index')->name('design');
//
//    // settings
//    Route::get('/settings', 'SettingController@index')->name('settings-list');
//    Route::post('/settingsUpdates/{id}', 'SettingController@update')->name('settingsUpdate');
//
//
//    Route::resource('roles', 'RoleController');
//    Route::resource('permissions', 'PermissionController');
//    Route::resource('posts', 'PostController');
//
//
//});

Route::group(['prefix' => 'dashboard', 'namespace' => 'Panel', 'middleware' => ['auth','verifyRoles']], function () {

    // index
//    Route::get('/', 'PanelController@index')->name('dashboard-index');

    // Credit
//    Route::post('/payment/wallet', 'CreditController@payment')->name('panel-payment');
//    Route::get('/payment/wallet/pay/{id}', 'CreditController@pay')->name('panel-payment-pay');
//    Route::any('/payment/wallet/verify', 'CreditController@verify')->name('panel-payment-verify');



    ;


// Club Excels
//    Route::get('club-award-excel', function () {
//        return Excel::download(new AwardsExport, 'factorsFromFirst.xlsx');
//    })->name('club-award-excel');
//    Route::get('club-users-excel', function () {
//        return Excel::download(new ClubUsersExport, 'ClubUsersFromFirst.xlsx');
//    })->name('club-users-excel');
//    Route::get('club-ban-users-excel', function () {
//        return Excel::download(new ClubBanUsersExport, 'ClubBanUsersFromFirst.xlsx');
//    })->name('club-ban-users-excel');
//    Route::get('club-codes-excel', function () {
//        return Excel::download(new ClubCodesExport, 'ClubCodesFromFirst.xlsx');
//    })->name('club-codes-excel');
//    Route::get('club-baskets-excel', function () {
//        return Excel::download(new BasketsExport, 'ClubBasketsFromFirst.xlsx');
//    })->name('club-baskets-excel');
//
//    //type
//    Route::get('type-user', 'Club\TypeController@index')->name('admin-type-list');
//    Route::post('type-user/update', 'Club\TypeController@update')->name('admin-type-update');
//
//
//    // user black
//
//    Route::get('club-black-user', 'Club\UserController@index')->name('admin-user-black');
//
//
//    // user ban
//
//    Route::get('club-ban-user', 'Club\UserController@ban')->name('admin-user-ban');
//
//    Route::get('club-ban-exit/{id}', 'Club\UserController@exitBan')->name('admin-club-ban-exit');
//
//
//    // basket club
//
//    Route::get('/basket/club', 'Club\basketClubController@index')->name('basket-club-page-list');
//
//    Route::get('/basket/club/one/{factor}', 'Club\basketClubController@successone')->name('basket-club-success-one');
//
//    Route::get('/basket/club/two/{factor}', 'Club\basketClubController@successtwo')->name('basket-club-success-two');
//
//    Route::get('/basket/club/three/{factor}', 'Club\basketClubController@successthree')->name('basket-club-success-three');
//
//    Route::get('/basket/club/four/{factor}', 'Club\basketClubController@successfour')->name('basket-club-success-four');
//
//    Route::get('/basket/club/delete/{factor}/{user_id}', 'Club\basketClubController@destroy')->name('basket-club-delete');
//    Route::post('export-excel-basket', 'BasketController@excel')->name('export-excel-basket');
//
//
//    // message
//
//    Route::get('club-message-list', 'Club\MessageController@index')->name('admin-user-message');
//
//    Route::get('club-message-create', 'Club\MessageController@create')->name('admin-club-message-create');
//
//    Route::post('club-message-store', 'Club\MessageController@store')->name('admin-club-message-store');
//
//    Route::post('club-message-edit', 'Club\MessageController@edit')->name('admin-club-message-edit');
//
//    Route::post('club-message-destroy/{id}', 'Club\MessageController@destroy')->name('admin-club-message-destroy');
//
//
//    // user wait
//
//    Route::get('club-wait-list', 'Club\WaitController@index')->name('admin-wait-message');
//
//    Route::get('club-wait-user/{id}', 'Club\WaitController@active')->name('admin-wait-active');
//
//    Route::post('club-wait-delete/{id}', 'Club\WaitController@active')->name('admin-wait-delete');
//
//
//    // seo
//
//    Route::get('meta-create', 'MetaController@create')->name('meta-create');
//    Route::put('meta-store', 'MetaController@store')->name('meta-store');
//    Route::get('meta-list', 'MetaController@index')->name('meta-list');
//    Route::get('meta-edit/{id}', 'MetaController@edit')->name('meta-edit');
//    Route::patch('meta-update/{id}', 'MetaController@update')->name('meta-update');
//    Route::delete('meta-destroy/{id}', 'MetaController@destroy')->name('meta-destroy');
//    Route::post('meta-sort', 'MetaController@sort_item')->name('meta-sort');
//
//
//    Route::get('excel/index', function () {
//        $code = \App\Models\ClubCode::orderBy('status', 'desc')->paginate(20);
//        return view('panel.excel.index', compact('code'));
//    })->name('excel-index');
//
//    Route::post('excel/insert', 'HomeController@excel')->name('excel');
//    Route::get('code/search', 'HomeController@serachCode')->name('search-code');
//
//    // index club
//
//    Route::get('/index/club', 'Club\indexController@index')->name('index-club-page-list');
//
//    Route::post('/index/club/update', 'Club\indexController@update')->name('index-club-success-one');
//
//
//    //user
//
//    Route::get('club-black-user-exit/{id}', 'Club\UserController@exits')->name('admin-club-user-exit');
//
//    Route::get('club-black-user-delete/{id}', 'Club\UserController@delete')->name('admin-club-user-delete');
//
//
//    Route::get('site/language', 'LanguageController@index')->name('site.language');
//    Route::get('language-create', 'LanguageController@create')->name('language.create');
//    Route::post('language-store', 'LanguageController@store')->name('language.store');
//    Route::get('language-edit/{id}', 'LanguageController@edit')->name('language.edit');
//    Route::patch('language-update/{id}', 'LanguageController@update')->name('language.update');
//
//    Route::delete('language-delete/{id}', 'LanguageController@destroy')->name('language.destroy');
//
//
//
//
//    //inventory
//
//
//    Route::get('inventory-archive/{id}/{type}', 'InventoryController@archive')->name('inventory-archive');
//    Route::get('inventory-archive-list', 'InventoryController@archive_list')->name('inventory-archive-list');
//    Route::get('inventory-create/{id}', 'InventoryController@create')->name('inventory-create');
//    Route::put('inventory-store/{id}', 'InventoryController@store')->name('inventory-store');
//
//
//    Route::post('model-inventory-update/{id}', 'InventoryController@model_update')->name('model-inventory-update');
//    Route::get('export-inventory-excel-panel', 'InventoryController@excel_export')->name('export-excel-inventory');

    //factor
//    Route::get('factor-list', 'FactorController@index')->name('factor-list');
//    Route::get('factor-create1', 'FactorController@create1')->name('factor-create');
//    Route::post('factor-store', 'FactorController@store')->name('factor-store');
//    Route::post('findProduct/{id}', 'FactorController@find')->name('findProduct');
//    Route::get('factor-list-export', 'FactorController@export')->name('factor-export');
//    Route::get('factor-view/{order_code}', 'FactorController@show')->name('factor-view');
//    Route::get('factors-cancel/{order_code}', 'FactorController@cancel')->name('factors-cancel');

    // draft
//    Route::get('draft-list', 'DraftController@index')->name('draft-list');
//    Route::get('draft-show/{id}', 'DraftController@draft_show')->name('draft-show');
//    Route::get('draft-confirm/{id}', 'DraftController@confirm')->name('draft-confirm');
//    Route::post('draft-confirm-all', 'DraftController@confirm_all')->name('draft-confirm-all');
//    Route::get('export-excel', 'DraftController@excel')->name('export-excel');
//    Route::get('export-excel-byYear', 'DraftController@excelByYear')->name('export-excel-byYear');
//    Route::get('export-excel-byMonth', 'DraftController@excelByMonth')->name('export-excel-byMonth');
//    Route::get('export-excel-byDay', 'DraftController@excelByDay')->name('export-excel-byDay');
//
//
//    // profile
//    Route::get('profile-show/{id}', 'ProfileController@show')->name('profile-show');
//    Route::get('profile-edit/{id}', 'ProfileController@edit')->name('profile-edit');
//    Route::get('profile-password-change/{id}', 'ProfileController@password')->name('profile-password');
//    Route::get('profile-info/{id}', 'ProfileController@info')->name('profile-info');
//    Route::patch('profile-update/{id}', 'ProfileController@update')->name('profile-update');
//    Route::patch('profile-password-update/{id}', 'ProfileController@password_update')->name('profile-password-update');
//    Route::patch('profile-info-update/{id}', 'ProfileController@info_update')->name('profile-info-update');
//
//
//    // work
//    Route::get('work-list', 'WorkController@index')->name('work-list');
//    Route::delete('work-destroy/{id}', 'WorkController@destroy')->name('work-destroy');
//    Route::get('work-show/{id}', 'WorkController@show')->name('work-show');
//
//
//    // Basket
//    Route::get('basket-list', 'BasketController@index')->name('basket-list');
//    Route::get('basket-reserv-list', 'BasketController@index_reserv')->name('basket-reserv-list');
//    Route::get('draftWait-list', 'BasketController@draftWait')->name('draftWait-list');
//    Route::get('send-list', 'BasketController@sendFactor')->name('send-list');
//    Route::get('give-list', 'BasketController@giveFactor')->name('give-factor');
//    Route::get('cancel-list', 'BasketController@cancelFactors')->name('factor-cancel');
//    Route::get('factor-lists', 'BasketController@allFactor')->name('factor-all');
//    Route::get('backPay-list', 'BasketController@backPay')->name('factor-backPay');
//    Route::post('factor-post-import', 'BasketController@postImport')->name('postImport');
//    Route::post('factor-delivery/{id}', 'BasketController@factor_delivery')->name('factor-delivery');
//    Route::get('factor-search-list', 'BasketController@search')->name('factor-all-search');
//    Route::post('factor-export-list', 'BasketController@export_date')->name('factor-all-export');
////    Route::get('no_pay-list', 'BasketController@no_pay')->name('factor-no_pay');
//
//
//    // Basket
//    Route::get('basket-confirm/{id}', 'BasketController@confirm')->name('basket-confirm');
//    Route::post('basket-confirm-all', 'BasketController@confirm_all')->name('basket-confirm-all');
//    Route::get('basket-okay/{id}', 'BasketController@okay')->name('basket-okay');
//    Route::post('basket-okay-all', 'BasketController@okay_all')->name('basket-okay-all');
//    Route::get('basket-all', 'BasketController@all')->name('basket-all');
//    Route::delete('basket-destroy/{id}', 'BasketController@destroy')->name('basket-destroy');
//    Route::get('factor-print/{order_code}', 'BasketController@factor_print')->name('factor-print');
//    Route::get('factors_print', 'BasketController@factors_print')->name('factors-print');
//    Route::get('factor-print-all', 'BasketController@factor_print_all')->name('factor-print-all');
//    Route::get('basket-return/{id}', 'BasketController@basket_return')->name('basket-return');
//    Route::get('basket-re_run/{id}', 'BasketController@basket_re_run')->name('basket-re_run');
//    Route::get('user-info/{id}', 'BasketController@user_info')->name('user-info');
//    Route::get('export-excel-basket', 'BasketController@excel')->name('export-excel-basket');
//
//
//    // users
//    Route::get('user-create', 'UserController@create')->name('user-create');
//    Route::put('user-store', 'UserController@store')->name('user-store');
//    Route::get('user-list', 'UserController@index')->name('user-list');
//    Route::get('user-show/{id}', 'UserController@show')->name('user-show');
//    Route::get('user-edit/{id}', 'UserController@edit')->name('user-edit');
//    Route::get('user-search', 'UserController@search')->name('user-search');
//    Route::patch('user-update/{id}', 'UserController@update')->name('user-update');
//    Route::get('export-excel-user', 'UserController@excel')->name('export-excel-user');
//
//    // provider
//    Route::get('provider-create', 'ProviderController@create')->name('provider-create');
//    Route::put('provider-store', 'ProviderController@store')->name('provider-store');
//    Route::get('provider-list', 'ProviderController@index')->name('provider-list');
//    Route::get('provider-show/{id}', 'ProviderController@show')->name('provider-show');
//    Route::get('provider-edit/{id}', 'ProviderController@edit')->name('provider-edit');
//    Route::patch('provider-update/{id}', 'ProviderController@update')->name('provider-update');
//
//    // upload
//    Route::get('upload-create', 'UploadController@create')->name('upload-create');
//    Route::put('upload-store', 'UploadController@store')->name('upload-store');
//    Route::get('upload-list', 'UploadController@index')->name('upload-list');
//    Route::delete('upload-destroy/{id}', 'UploadController@destroy')->name('upload-destroy');
//
//    // word
//    Route::get('word-create', 'WordController@create')->name('word-create');
//    Route::put('word-store', 'WordController@store')->name('word-store');
//    Route::get('word-list', 'WordController@index')->name('word-list');
//    Route::delete('word-destroy/{id}', 'WordController@destroy')->name('word-destroy');
//
//    // brand
//    Route::get('brand-create', 'BrandController@create')->name('brand-create');
//    Route::put('brand-store', 'BrandController@store')->name('brand-store');
//    Route::get('brand-list', 'BrandController@index')->name('brand-list');
//    Route::get('brand-edit/{id}', 'BrandController@edit')->name('brand-edit');
//    Route::patch('brand-update/{id}', 'BrandController@update')->name('brand-update');
//    Route::delete('brand-destroy/{id}', 'BrandController@destroy')->name('brand-destroy');
//    Route::post('brand-list', 'BrandController@search')->name('brand-search');
//
//
//    // banner
//    Route::get('banner-create', 'BannerController@create')->name('banner-create');
//    Route::put('banner-store', 'BannerController@store')->name('banner-store');
//    Route::get('banner-list', 'BannerController@index')->name('banner-list');
//    Route::get('banner-edit/{id}', 'BannerController@edit')->name('banner-edit');
//    Route::patch('banner-update/{id}', 'BannerController@update')->name('banner-update');
//    Route::delete('banner-destroy/{id}', 'BannerController@destroy')->name('banner-destroy');
//    Route::post('banner-list', 'BannerController@search')->name('banner-search');
//
//    // type
//    Route::get('type-create', 'TypeController@create')->name('type-create');
//    Route::put('type-store', 'TypeController@store')->name('type-store');
//    Route::get('type-list', 'TypeController@index')->name('type-list');
//    Route::get('type-edit/{id}', 'TypeController@edit')->name('type-edit');
//    Route::patch('type-update/{id}', 'TypeController@update')->name('type-update');
//    Route::delete('type-destroy/{id}', 'TypeController@destroy')->name('type-destroy');
//
//    Route::get('typeAjax/{id}', 'TypeController@typeAjax')->name('typeAjax');
//
//
//
//
//
//
//    // resalat
//    Route::get('resalat-create/{id}', 'ResalatController@create')->name('resalat-create');
//    Route::post('resalat-store/{id}', 'ResalatController@store')->name('resalat-store');
//    Route::get('resalat-list', 'ResalatController@index')->name('resalat-list');
//    Route::delete('resalat-destroy/{id}', 'ResalatController@destroy')->name('resalat-destroy');
//
//    // Ad
//    Route::get('ad-create', 'AdController@create')->name('ad-create');
//    Route::put('ad-store', 'AdController@store')->name('ad-store');
//    Route::get('ad-list', 'AdController@index')->name('ad-list');
//    Route::delete('ad-destroy/{id}', 'AdController@destroy')->name('ad-destroy');
//
//
//
//
//
//
//
//
//    //Product
//    //Product
//    Route::post('brandAjax', 'ProductController@brandAjax')->name('create_ajax');
//    Route::post('catAjax', 'ProductController@catAjax')->name('create_cat_ajax');
//    Route::post('create_compar', 'ProductController@create_compar')->name('create_compar');
//    Route::get('product-create', 'ProductController@create')->name('product-create');
//    Route::post('product-store', 'ProductController@store')->name('product-store');
//    Route::get('product-list', 'ProductController@index')->name('product-list');
//
//
//    Route::get('product-report-sale', 'ProductController@report')->name('product-report');
//    Route::get('product-edit/{id}', 'ProductController@edit')->name('product-edit');
//    Route::patch('product-update/{id}', 'ProductController@update')->name('product-update');
//    Route::get('product-gallery/{id}', 'ProductController@gallery')->name('p-product-gallery');
//    Route::get('product-gallery', 'ProductController@gallery_sort')->name('p-product-gallery-sort');
//    Route::get('product-model/{id}', 'ProductController@modelProduct')->name('product-model');
//    Route::patch('product-model-store/{id}', 'ProductController@modelStore')->name('model-store');
//    Route::post('product-active-show/{id}', 'ProductController@product_show')->name('product-active-show');
//    Route::post('product-active-vip/{id}', 'ProductController@product_vip')->name('product-active-vip');
//    Route::post('product-active-price_tel/{id}', 'ProductController@product_price_tel')->name('product-active-price_tel');
//    Route::post('product_update_order_point/{id}', 'ProductController@update_order_point')->name('product-update-order-point');
//    Route::post('product-update-invent/{id}', 'ProductController@product_update_invent')->name('product-update-invent');
//    Route::post('product-update-puser/{id}', 'ProductController@product_update_puser')->name('product-update-puser');
//    Route::post('product-update-pvip/{id}', 'ProductController@product_update_pvip')->name('product-update-pvip');
//    Route::post('product-update-time/{id}', 'ProductController@product_update_time')->name('product-update-time');
//    Route::get('product-del-article/{id}', 'ProductController@del_article')->name('product-del-article');
//    Route::get('product-del-video/{id}', 'ProductController@del_video')->name('product-del-video');
//    Route::get('photo-del/{id}', 'ProductController@del_photo')->name('product_del_photo');
//    Route::get('compar-del/{id}', 'ProductController@del_compar')->name('product-del_compar');
//    Route::post('update_all_model/{id}', 'ProductController@update_all_model')->name('update_all_model');
//    Route::get('product-search1', 'ProductController@search1')->name('product-search');
//    Route::delete('product-destroy/{id}', 'ProductController@destroy')->name('product-destroy');
//    Route::get('remove-gallery/{id}', 'ProductController@remove_gallery')->name('remove-gallery');
//    Route::get('product-type-del/{id}', 'ProductController@type_del')->name('product-type-del');
//    Route::get('product-attr-del/{id}', 'ProductController@attr_del')->name('product-attr-del');
//    Route::get('product-comp-del/{id}', 'ProductController@comp_del')->name('product-comp-del');
//    Route::get('export-excel-product', 'ProductController@excel')->name('export-excel-product');
//    Route::post('add_comparss_to', 'ProductController@add_comparss_to')->name('add_comparss_to');
//    //model
//    Route::get('model-photo-destroy/{id}', 'ModelController@photo_destroy')->name('model-photo-destroy');
//    Route::get('model-create/{id}', 'ModelController@create')->name('model-create');
//    Route::put('model-store/{id}', 'ModelController@store')->name('model-store');
//    Route::get('model-list/{id}', 'ModelController@index')->name('model-list');
//    Route::get('model-edit/{id}', 'ModelController@edit')->name('model-edit');
//    Route::patch('model-update/{id}', 'ModelController@update')->name('model-update');
//    Route::delete('model-destroy/{id}', 'ModelController@destroy')->name('model-destroy');
//
//    //model size
//    Route::get('model-size-create/{id}', 'ModelSizeController@create')->name('model-size-create');
//    Route::post('model-size-store/{id}', 'ModelSizeController@store')->name('model-size-store');
//    Route::get('model-size-list/{id}', 'ModelSizeController@index')->name('model-size-list');
//    Route::get('model-size/{id}', 'ModelSizeController@index')->name('model-size');
//    Route::get('model-size-edit/{id}', 'ModelSizeController@edit')->name('model-size-edit');
//    Route::post('model-size-update/{id}', 'ModelSizeController@update')->name('model-size-update');
//    Route::get('model-size-destroy/{id}', 'ModelSizeController@destroy')->name('model-size-destroy');
//
//    Route::post('model-active-default/{id}', 'ModelController@model_default')->name('model-active-default');
//    Route::post('model-update-pstore/{id}', 'ModelController@model_update_pstore')->name('model-update-pstore');
//    Route::post('model-update-invent/{id}', 'ModelController@model_update_invent')->name('model-update-invent');
//    Route::post('model-update-puser/{id}', 'ModelController@model_update_puser')->name('model-update-puser');
//    Route::post('model-update-pvip/{id}', 'ModelController@model_update_pvip')->name('model-update-pvip');
//    Route::post('update_price_tel/{id}', 'ModelController@update_price_tel')->name('update_price_tel');
//
//
//    //worked
//    Route::get('worked-create', 'WorkedController@create')->name('worked-create');
//    Route::put('worked-store', 'WorkedController@store')->name('worked-store');
//    Route::get('worked-list', 'WorkedController@index')->name('worked-list');
//    Route::get('worked-edit/{id}', 'WorkedController@edit')->name('worked-edit');
//    Route::patch('worked-update/{id}', 'WorkedController@update')->name('worked-update');
//    Route::delete('worked-destroy/{id}', 'WorkedController@destroy')->name('worked-destroy');
//
//    //about
//    Route::get('About', 'AboutController@index')->name('admin-about');
//    Route::get('About-create', 'AboutController@create')->name('about-create');
//    Route::post('About-create', 'AboutController@store')->name('about-store');
//    Route::get('About-edit/{id}', 'AboutController@edit')->name('about-edit');
//    Route::post('About-edit/{id}', 'AboutController@edit1')->name('about-edit1');
//    Route::delete('About-destroy/{id}', 'AboutController@destroy')->name('about-destroy');
//    //infocontact
//    Route::get('infocontact', 'InfoContactController@index')->name('admin-infocontact');
//    Route::get('infocontact-create', 'InfoContactController@create')->name('infocontact-create');
//    Route::post('infocontact-create', 'InfoContactController@store')->name('infocontact-store');
//    Route::get('infocontact-edit/{id}', 'InfoContactController@edit')->name('infocontact-edit');
//    Route::post('infocontact-edit/{id}', 'InfoContactController@edit1')->name('infocontact-edit1');
//    Route::delete('infocontact-destroy/{id}', 'InfoContactController@destroy')->name('infocontact-destroy');
//
//    // categories
//    Route::get('gallery-category-create', 'GalleryCategoryController@create')->name('gallery-category-create');
//    Route::put('gallery-category-store', 'GalleryCategoryController@store')->name('gallery-category-store');
//    Route::get('gallery-category-list', 'GalleryCategoryController@index')->name('gallery-category-list');
//    Route::get('gallery-category-edit/{id}', 'GalleryCategoryController@edit')->name('gallery-category-edit');
//    Route::patch('gallery-category-update/{id}', 'GalleryCategoryController@update')->name('gallery-category-update');
//    Route::delete('gallery-category-destroy/{id}', 'GalleryCategoryController@destroy')->name('gallery-category-destroy');
//    Route::post('gallery-category-sort', 'GalleryCategoryController@sort_item')->name('gallery-category-sort');
//
//    //Gallery
//    Route::get('gallery-create', 'GalleryController@create')->name('gallery-create');
//    Route::put('gallery-store', 'GalleryController@store')->name('gallery-store');
//    Route::get('gallery-list', 'GalleryController@index')->name('gallery-list');
//    Route::get('gallery-edit/{id}', 'GalleryController@edit')->name('gallery-edit');
//    Route::patch('gallery-update/{id}', 'GalleryController@update')->name('gallery-update');
//    Route::delete('gallery-destroy/{id}', 'GalleryController@destroy')->name('gallery-destroy');
//
//
//    // video_cat
//    Route::get('video-cat-create', 'VideocatController@create')->name('video-cat-create');
//    Route::put('video-cat-store', 'VideocatController@store')->name('video-cat-store');
//    Route::get('video-cat-list', 'VideocatController@index')->name('video-cat-list');
//    Route::get('video-cat-edit/{id}', 'VideocatController@edit')->name('video-cat-edit');
//    Route::patch('video-cat-update/{id}', 'VideocatController@update')->name('video-cat-update');
//    Route::delete('video-cat-destroy/{id}', 'VideocatController@destroy')->name('video-cat-destroy');
//    Route::post('video-cat-sort', 'VideocatController@sort_item')->name('video-cat-sort');
//
//    //video
//    Route::get('video-create', 'VideoController@create')->name('video-create');
//    Route::put('video-store', 'VideoController@store')->name('video-store');
//    Route::get('video-list', 'VideoController@index')->name('video-list');
//    Route::get('video-edit/{id}', 'VideoController@edit')->name('video-edit');
//    Route::patch('video-update/{id}', 'VideoController@update')->name('video-update');
//    Route::delete('video-destroy/{id}', 'VideoController@destroy')->name('video-destroy');
//
//
//    // attribute
//    Route::get('attribute-create', 'AttributeController@create')->name('attribute-create');
//    Route::put('attribute-store', 'AttributeController@store')->name('attribute-store');
//    Route::get('attribute-list', 'AttributeController@index')->name('attribute-list');
//    Route::get('attribute-edit/{id}', 'AttributeController@edit')->name('attribute-edit');
//    Route::patch('attribute-update/{id}', 'AttributeController@update')->name('attribute-update');
//    Route::delete('attribute-destroy/{id}', 'AttributeController@destroy')->name('attribute-destroy');
//
//    // comparison
//    Route::get('comparison-create', 'ComparisonController@create')->name('comparison-create');
//    Route::put('comparison-store', 'ComparisonController@store')->name('comparison-store');
//    Route::get('comparison-list', 'ComparisonController@index')->name('comparison-list');
//    Route::get('comparison-edit/{id}', 'ComparisonController@edit')->name('comparison-edit');
//    Route::patch('comparison-update/{id}', 'ComparisonController@update')->name('comparison-update');
//    Route::delete('comparison-destroy/{id}', 'ComparisonController@destroy')->name('comparison-destroy');
//
//    //article_category
//    Route::get('article-category-create', 'ArticleCategoryController@create')->name('article-category-create');
//    Route::put('article-category-store', 'ArticleCategoryController@store')->name('article-category-store');
//    Route::get('article-category-list', 'ArticleCategoryController@index')->name('article-category-list');
//    Route::get('article-category-edit/{id}', 'ArticleCategoryController@edit')->name('article-category-edit');
//    Route::patch('article-category-update/{id}', 'ArticleCategoryController@update')->name('article-category-update');
//    Route::delete('article-category-destroy/{id}', 'ArticleCategoryController@destroy')->name('article-category-destroy');
//    Route::post('article-category-sort', 'ArticleCategoryController@sort_item')->name('article-category-sort');
//// News Route
//    Route::get('news-category-create', 'NewsCategoryController@create')->name('news-category-create');
//    Route::put('news-category-store', 'NewsCategoryController@store')->name('news-category-store');
//    Route::get('news-category-list', 'NewsCategoryController@index')->name('news-category-list');
//    Route::get('news-category-edit/{id}', 'NewsCategoryController@edit')->name('news-category-edit');
//    Route::patch('news-category-update/{id}', 'NewsCategoryController@update')->name('news-category-update');
//    Route::delete('news-category-destroy/{id}', 'NewsCategoryController@destroy')->name('news-category-destroy');
//    Route::post('news-category-sort', 'NewsCategoryController@sort_item')->name('news-category-sort');
//    // journal
//    Route::get('journal-create', 'JournalController@create')->name('journal-create');
//    Route::put('journal-store', 'JournalController@store')->name('journal-store');
//    Route::get('journal-list', 'JournalController@index')->name('journal-list');
//    Route::get('journal-edit/{id}', 'JournalController@edit')->name('journal-edit');
//    Route::patch('journal-update/{id}', 'JournalController@update')->name('journal-update');
//    Route::delete('journal-destroy/{id}', 'JournalController@destroy')->name('journal-destroy');
//
//    // news
//    Route::get('news-create', 'NewsController@create')->name('news-create');
//    Route::put('news-store', 'NewsController@store')->name('news-store');
//    Route::get('news-list', 'NewsController@index')->name('news-list');
//    Route::get('news-edit/{id}', 'NewsController@edit')->name('news-edit');
//    Route::patch('news-update/{id}', 'NewsController@update')->name('news-update');
//    Route::delete('news-destroy/{id}', 'NewsController@destroy')->name('news-destroy');
//
//
//
//
//
//    // categories
//    Route::get('footer-category-create', 'FooterCategoryController@create')->name('footer-category-create');
//    Route::put('footer-category-store', 'FooterCategoryController@store')->name('footer-category-store');
//    Route::get('footer-category-list', 'FooterCategoryController@index')->name('footer-category-list');
//    Route::get('footer-category-edit/{id}', 'FooterCategoryController@edit')->name('footer-category-edit');
//    Route::patch('footer-category-update/{id}', 'FooterCategoryController@update')->name('footer-category-update');
//    Route::delete('footer-category-destroy/{id}', 'FooterCategoryController@destroy')->name('footer-category-destroy');
//    Route::post('footer-category-sort', 'FooterCategoryController@sort_item')->name('footer-category-sort');
//
//
//    // projects
//    Route::get('projects-create', 'ProjectsController@create')->name('projects-create');
//    Route::put('projects-store', 'ProjectsController@store')->name('projects-store');
//    Route::get('projects-list', 'ProjectsController@index')->name('projects-list');
//    Route::get('projects-edit/{id}', 'ProjectsController@edit')->name('projects-edit');
//    Route::patch('projects-update/{id}', 'ProjectsController@update')->name('projects-update');
//    Route::delete('projects-destroy/{id}', 'ProjectsController@destroy')->name('projects-destroy');
//    Route::get('projects-photo-delete/{id}', 'ProjectsController@destroyPhoto')->name('projects-photo-delete');
//
//
//    // prize
//    Route::get('prize-create', 'PrizeController@create')->name('prize-create');
//    Route::put('prize-store', 'PrizeController@store')->name('prize-store');
//    Route::get('prize-list', 'PrizeController@index')->name('prize-list');
//    Route::get('prize-edit/{id}', 'PrizeController@edit')->name('prize-edit');
//    Route::patch('prize-update/{id}', 'PrizeController@update')->name('prize-update');
//    Route::delete('prize-destroy/{id}', 'PrizeController@destroy')->name('prize-destroy');
//
//    //mk-ads
//    Route::get('ads-list', 'AdsController@index')->name('ads-list');
//    Route::get('ads-edit/{id}', 'AdsController@edit')->name('ads-edit');
//    Route::patch('ads-update/{id}', 'AdsController@update')->name('ads-update');
//
//
//    // comment
//    Route::get('comment-answer/{id}', 'CommentController@create')->name('comment-answer');
//    Route::put('comment-stores', 'CommentController@store')->name('comment-store');
//    Route::get('comment-list', 'CommentController@index')->name('comment-list');
//    Route::get('comment-edit/{id}', 'CommentController@edit')->name('comment-edit');
//    Route::put('comment-update/{id}', 'CommentController@update')->name('comment-update');
//    Route::delete('comment-destroy/{id}', 'CommentController@destroy')->name('comment-destroy');
//    Route::get('comment-confirm/{id}', 'CommentController@confirm')->name('comment-confirm');
//
//
//    // question
//    Route::get('question-list', 'QuestionController@index')->name('question-list');
//    Route::any('question-confirm/{id}', 'QuestionController@confirm')->name('question-confirm');
//    Route::get('question-destroy/{id}', 'QuestionController@destroy')->name('question-destroy');
//
//
//    // viewpoint
//    Route::get('viewpoint-create', 'ViewpointController@create')->name('viewpoint-create');
//    Route::put('viewpoint-store', 'ViewpointController@store')->name('viewpoint-store');
//    Route::get('viewpoint-list', 'ViewpointController@index')->name('viewpoint-list');
//    Route::get('viewpoint-edit/{id}', 'ViewpointController@edit')->name('viewpoint-edit');
//    Route::patch('viewpoint-update/{id}', 'ViewpointController@update')->name('viewpoint-update');
//    Route::delete('viewpoint-destroy/{id}', 'ViewpointController@destroy')->name('viewpoint-destroy');
//
//    // article
//    Route::get('article-create', 'ArticleController@create')->name('article-create');
//    Route::put('article-store', 'ArticleController@store')->name('article-store');
//    Route::get('article-list', 'ArticleController@index')->name('article-list');
//    Route::get('article-edit/{id}', 'ArticleController@edit')->name('article-edit');
//    Route::patch('article-update/{id}', 'ArticleController@update')->name('article-update');
//    Route::delete('article-destroy/{id}', 'ArticleController@destroy')->name('article-destroy');
//    // article comment
//    Route::get('article-comment-reply/{id}', 'ArticleCommentController@create')->name('article-comment-reply');
//    Route::put('article-comment-reply-store/{id}', 'ArticleCommentController@store')->name('article-comment-reply-store');
//    Route::get('article-comment-list/{id}', 'ArticleCommentController@index')->name('article-comment-list');
//    Route::get('article-comment-edit/{id}', 'ArticleCommentController@edit')->name('article-comment-edit');
//    Route::patch('article-comment-update/{id}', 'ArticleCommentController@update')->name('article-comment-update');
//    Route::delete('article-comment-destroy/{id}', 'ArticleCommentController@destroy')->name('article-comment-destroy');
//    Route::get('article-comment-status/{id}', 'ArticleCommentController@status')->name('article-comment-status');
//
//    //db_category
//    Route::get('db-category-list', 'DbCategoryController@index')->name('db-category-list');
//
//    // bank
//    Route::get('bank-create', 'BankController@create')->name('bank-create');
//    Route::put('bank-store', 'BankController@store')->name('bank-store');
//    Route::get('bank-list', 'BankController@index')->name('bank-list');
//    Route::get('bank-edit/{id}', 'BankController@edit')->name('bank-edit');
//    Route::patch('bank-update/{id}', 'BankController@update')->name('bank-update');
//    Route::delete('bank-destroy/{id}', 'BankController@destroy')->name('bank-destroy');
//
//    // articleattribute
//    Route::get('article-attribute-create', 'ArticleAttributeController@create')->name('article-attribute-create');
//    Route::put('article-attribute-store', 'ArticleAttributeController@store')->name('article-attribute-store');
//    Route::get('article-attribute-list', 'ArticleAttributeController@index')->name('article-attribute-list');
//    Route::get('article-attribute-edit/{id}', 'ArticleAttributeController@edit')->name('article-attribute-edit');
//    Route::patch('article-attribute-update/{id}', 'ArticleAttributeController@update')->name('article-attribute-update');
//    Route::delete('article-attribute-destroy/{id}', 'ArticleAttributeController@destroy')->name('article-attribute-destroy');
//
//
//
//    // Design
//    Route::get('design', 'DesignController@index')->name('design');
//
//
//
//    Route::resource('roles', 'RoleController');
//    Route::resource('permissions', 'PermissionController');
//    Route::resource('posts', 'PostController');
});
