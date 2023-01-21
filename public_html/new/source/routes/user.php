<?php
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\User;
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

//auth
Route::get('login', 'AuthController@auth')->name('auth')->middleware('guest');
//register post
Route::post('register_1', 'AuthController@register_1')->name('register_1')->middleware('guest');
//active code
Route::get('verify-code', 'AuthController@verify_code')->name('verify.code')->middleware('guest');
Route::get('verify-code-retry', 'AuthController@verify_code_retry')->name('verify.code.retry')->middleware('guest');
//verify code post
Route::post('register_2', 'AuthController@register_2')->name('register_2')->middleware('guest');
//password_resset
Route::get('password-reset-mobile', 'AuthController@password_get_1')->name('password_1')->middleware('guest');
Route::post('password-reset-mobile-post', 'AuthController@password_post_1')->name('password.post_1')->middleware('guest');
Route::get('password-reset-verify-code', 'AuthController@password_get_2')->name('password_2')->middleware('guest');
Route::post('password-reset-verify-code-post', 'AuthController@password_post_2')->name('password.post_2')->middleware('guest');
Route::get('password-reset-verify-code-post-retry', 'AuthController@password_post_retry')->name('password.post_retry')->middleware('guest');
Route::get('password-reset-new-password', 'AuthController@password_get_3')->name('password_3')->middleware('guest');
Route::post('password-reset-new-password-post', 'AuthController@password_post_3')->name('password.post_3')->middleware('guest');

//Route::get('/', 'HomeController@index')->name('user_home');
//Route::get('products/vip/{title}', 'HomeController@vip_home')->name('products-vip-title');
Route::get('/off_check/{off_code}/{total}', function ($off_code,$total) {
    $off=Off::where('code',$off_code)->first();
    if($off)
    {
        $factor=Factor::where('user_id',auth()->user()->id)->where('off_code',$off_code)->where('status','>',0)->get();
        if(count($factor)>0)
        {
            return 'no';
        }
        $total=$total-$off->persent;
        return $total;
    }
    return 0;
});

// products
Route::get('محصول/{slug}/{model?}', 'ProductController@show')->name('product_info');
Route::get('محصولات/{category?}', 'ProductController@index')->name('product_category');
Route::get('برند/محصولات/{slug?}', 'ProductController@brand')->name('product_brand');
Route::get('تخفیفات-دیجی-کلاه', 'ProductController@offers')->name('offers_list');
//    Route::post('product/name', 'ProductController@name_product')->name('name_product');

Route::get('جستجو', 'ProductController@search')->name('search');

// basket

Route::get('سبد-خرید', 'BasketController@basket')->name('basket');

Route::get('add-to-basket/{id}', 'BasketController@Add_to_basket')->name('add-to-basket');
Route::post('basket-update', 'BasketController@update')->name('basket-update');
Route::get('basket-delete/{id}', 'BasketController@del_from_basket')->name('basket-delete');
Route::post('user-basket-confirm', 'BasketController@confirm')->name('user-basket-confirm');
Route::post('user-basket-checkout', 'BasketController@checkout')->name('user-basket-checkout');


//mellat
Route::get('mellat-pay/{id}', 'MellatController@pay')->name('mellat-pay');
Route::any('mellat-verify', 'MellatController@verify')->name('mellat-verify');
//parsian
Route::get('parsian-pay/{id}', 'ParsianController@pay')->name('parsian-pay');
Route::any('parsian-verify', 'ParsianController@verify')->name('parsian-verify');
//zarin pal
Route::any('zarinpal-pay/{id}', 'ZarinpalController@pay')->name('zarinpal-pay');
Route::any('zarinpal-verify', 'ZarinpalController@verify')->name('zarinpal-verify');

// Favorite
Route::get('علاقه-مندی-ها', 'FavoriteController@favorite')->name('favorite');
Route::get('add-to-favorite/{id}/{m_id}', 'FavoriteController@Add_to_favorite')->name('add-to-favorite');
Route::get('del-from-favorite/{id}', 'FavoriteController@del_from_favorite')->name('del-from-favorite');

// login or register
Route::post('register/mobile', 'HomeController@register')->name('register-mobile');
Route::post('register/verify', 'HomeController@verify')->name('register-verify');
Route::post('register/complete', 'HomeController@complete')->name('register-complete');
//    Route::get('login/complete', 'HomeController@login_complete')->name('login-complete');
Route::post('password/reset', 'HomeController@password_reset')->name('password-reset');


// page
Route::get('صفحه/{slug}', 'HomeController@static_show')->name('page');
Route::get('درباره-ما', 'HomeController@about')->name('about');

Route::get('تماس-با-ما', 'HomeController@contact')->name('contact');
Route::post('user-contact-store', 'ContactController@store')->name('user-contact-store');

// comment
Route::post('comment-store/{id}', 'CommentController@store')->name('user-comment-store');
Route::post('question-store/{id}', 'CommentController@question')->name('user-question-store');

//articles
Route::get('مقالات/{slug}', 'ArticleController@article')->name('article');
Route::get('مقالات', 'ArticleController@allArticle')->name('articles');

//city
Route::get('cityAjax/{id?}', 'HomeController@city_ajax')->name('cityAjax');

// sitemap
Route::get('sitemap.xml', 'SitemapController@index');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('front.index');


Route::get('/verify', 'VerifyController@show')->name('verification.show');
Route::post('/verify', 'VerifyController@verify')->name('verification.verify');
//search
Route::get('search', 'HomeController@search')->name('search');
//city ajax
Route::get('city-ajax-new/{id}', 'HomeController@city_ajax')->name('city.ajax');

//advertisement
Route::get('advertisement/{slug?}/{id?}', 'AdvertisementController@index')->name('advertisement');
Route::get('advertisement/show/{advertisement}/{slug?}', 'AdvertisementController@show')->name('advertisement.show');
Route::get('advertisement-filter/{slug}', 'AdvertisementController@filter')->name('advertisement.filter');


//product
Route::get('products-vip/{slug}', 'ProductController@products_vip')->name('products.vip');
Route::get('products/{slug}', 'ProductController@products')->name('products');
Route::get('products-filter/{slug}', 'ProductController@filter')->name('products.filter');
Route::get('product/{slug}/{model_id}', 'ProductController@product')->name('product');
Route::post('productRequest', 'ProductController@productRequest')->name('productRequest');
Route::post('product-comment/{id}', 'ProductController@comment')->name('product.comment');
//favorite
Route::get('favorites', 'FavoriteController@favorites')->name('favorites.list');
Route::get('favorite-store/{id}/{model}', 'FavoriteController@favorite_store')->name('favorites.store');
Route::get('favorite-destroy/{id}', 'FavoriteController@favorite_destroy')->name('favorites.destroy');
//blog
Route::get('blogs', 'BlogController@blogs')->name('blogs');
Route::get('blog/{slug}', 'BlogController@blog')->name('blog');
Route::post('blog-post/{id}', 'BlogController@comment')->name('blog.comment');
//page default
Route::get('page/{slug}', 'HomeController@page')->name('page');
//about us
Route::get('about-us', 'HomeController@about')->name('about.us');
//contact us
Route::get('contact-us', 'HomeController@contact')->name('contact.us');
Route::post('contact-us-post', 'HomeController@contact_post')->name('contact.us.post');
//basket
Route::get('basket-level-1', 'BasketController@level_1')->name('level_1');
Route::get('add-basket/{p_id?}/{m_id?}', 'BasketController@add_basket')->name('add.basket');
Route::get('del-basket/{id}/{size_id?}', 'BasketController@del_basket')->name('del.basket');
Route::get('update-basket/{id}/{num}/{size_id?}', 'BasketController@update_basket')->name('update.basket');
Route::get('basket-level-2', 'BasketController@level_2')->name('level_2');
Route::get('edit-address/{id}', 'BasketController@edit_address')->name('edit-address');
Route::post('update-address/{id}', 'BasketController@update_address')->name('update-address');
Route::post('type_send', 'BasketController@type_send')->name('type.send.basket');
Route::get('basket-level-3/{order_code}', 'BasketController@level_3')->name('level_3');
Route::get('off_checked/{off_code}/{total}', 'BasketController@off_code_check')->name('off.code.check.basket');
Route::get('address-remove/{id}', 'BasketController@address_destroy')->name('address-destroy');
Route::post('end_basket/{order_code}', 'BasketController@end_basket')->name('end.basket');
Route::get('credit-deduction/{order_code}', 'BasketController@credit_deduction')->name('credit-deduction');

//mellat
Route::get('mellat-pay/{id}', 'MellatController@pay')->name('mellat.pay');
Route::any('mellat-verify', 'MellatController@verify')->name('mellat.verify');
//parsian
Route::get('parsian-pay/{id}', 'ParsianController@pay')->name('parsian.pay');
Route::any('parsian-verify', 'ParsianController@verify')->name('parsian.verify');
//zarin pal
Route::any('zarinpal-pay/{id}', 'ZarinpalController@pay')->name('zarinpal.pay');
Route::any('zarinpal-verify', 'ZarinpalController@verify')->name('zarinpal.verify');


//barcode search
Route::get('barcode-post', 'PostController@show')->name('barcode.post');
Route::get('barcode-post-search/{code}', 'PostController@search')->name('barcode.search');

//branch Page
Route::get('branch-page/{id}', 'HomeController@branch_page')->name('branch.page');

//seller
Route::get('seller', 'HomeController@seller')->name('seller.index');
Route::post('seller/sendCode', 'HomeController@sendVerificationCode')->name('seller.sendVerificationCode');
Route::get('seller/verify-code', 'HomeController@verify_code')->name('seller.verify.code')->middleware('guest');
Route::post('seller/register_2', 'HomeController@register_2')->name('seller.register_2')->middleware('guest');
Route::get('seller/addSeller', 'HomeController@addSeller')->name('seller.addSeller')->middleware('guest');
Route::post('seller/addSeller/{user}', 'HomeController@addSellers')->name('seller.addSellers')->middleware('guest');

//verify code post