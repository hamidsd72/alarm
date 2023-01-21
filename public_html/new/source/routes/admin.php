<?php

//index
Route::get('/', 'PanelController@index')->name('index');

//Developer
Route::resource('permission', PermissionController::class);
Route::resource('role', RoleController::class);

// Credit
Route::get('/payment/list/{id?}', 'CreditController@index')->name('panel-payment-index');
Route::get('/payment/create/{id}', 'CreditController@create')->name('panel-payment-create');
Route::put('/payment/store/{id}', 'CreditController@store')->name('panel-payment-store');
Route::get('/payment/active/{id}/{type}', 'CreditController@active')->name('panel-payment-active');

Route::post('/payment/wallet', 'CreditController@payment')->name('panel-payment');
Route::get('/payment/wallet/pay/{id}', 'CreditController@pay')->name('panel-payment-pay');
Route::any('/payment/wallet/verify', 'CreditController@verify')->name('panel-payment-verify');

Route::get('/users/wallet', 'CreditController@wallet_show')->name('user-wallet-show');

// users
Route::get('user-create', 'UserController@create')->name('user-create');
Route::put('user-store', 'UserController@store')->name('user-store');
Route::get('user-list', 'UserController@index')->name('user-list');
Route::get('user-show/{id}', 'UserController@show')->name('user-show');
Route::get('user-edit/{id}', 'UserController@edit')->name('user-edit');
Route::get('user-search', 'UserController@search')->name('user-search');
Route::patch('user-update/{id}', 'UserController@update')->name('user-update');
Route::get('export-excel-user', 'UserController@excel')->name('export-excel-user');
Route::get('user/permission/{id}','UserController@permission')->name('user.permission');
Route::post('user/permission/update/{id}', 'UserController@permission_update')->name('user.update.permission');

//post
Route::resource('post', PostController::class);
Route::get('post/search/input', 'PostController@search_input')->name('post.search.input');
Route::post('post/import/excel', 'PostController@import_excel')->name('post.import.excel');

// Transacton
Route::get('transaction-list', 'TransactionController@index')->name('transacton-list');
Route::get('transaction-filter', 'TransactionController@transaction_export')->name('transacton-list-excel');


// Advertisement
Route::get('advertisement-list', 'AdvertisementController@index')->name('advertisement-list');
Route::get('advertisement-create', 'AdvertisementController@create')->name('advertisement-create');
Route::post('advertisement-store', 'AdvertisementController@store')->name('advertisement-store');

Route::patch('{id}/advertisement-active', 'AdvertisementController@active_status')->name('advertisement-active');
Route::get('{id}/advertisement-edit', 'AdvertisementController@edit')->name('advertisement-edit');
Route::patch('{id}/advertisement-update', 'AdvertisementController@update')->name('advertisement-update');
Route::delete('{id}/advertisement-destroy', 'AdvertisementController@destroy')->name('advertisement-destroy');
Route::delete('{id}/{photo}/advertisement-remove-photo', 'AdvertisementController@remove_photo')->name('advertisement-remove-photo');


//Route::get('advertising-list', [App\Http\Controllers\Panel\Advertising::class,'index'])->name('advertising-list');



//product request
Route::get('product-request-list', 'ProductRequestController@r_index')->name('product-request-list');
Route::get('product-request-sms/{id}', 'ProductRequestController@r_index_sms')->name('product-request-sms');
Route::get('product-request-del/{id}', 'ProductRequestController@r_index_del')->name('product-request-del');

// categories
Route::get('category-create', 'CategoryController@create')->name('category-create');
Route::put('category-store', 'CategoryController@store')->name('category-store');
Route::get('category-list', 'CategoryController@index')->name('category-list');
Route::get('category-edit/{id}', 'CategoryController@edit')->name('category-edit');
Route::patch('category-update/{id}', 'CategoryController@update')->name('category-update');
Route::delete('category-destroy/{id}', 'CategoryController@destroy')->name('category-destroy');
Route::post('category-sort', 'CategoryController@sort_item')->name('category-sort');

// brand
Route::get('brand-create', 'BrandController@create')->name('brand-create');
Route::put('brand-store', 'BrandController@store')->name('brand-store');
Route::get('brand-list', 'BrandController@index')->name('brand-list');
Route::get('brand-edit/{id}', 'BrandController@edit')->name('brand-edit');
Route::patch('brand-update/{id}', 'BrandController@update')->name('brand-update');
Route::delete('brand-destroy/{id}', 'BrandController@destroy')->name('brand-destroy');
Route::post('brand-list', 'BrandController@search')->name('brand-search');

// comment
Route::get('comment-answer/{id}', 'CommentController@create')->name('comment-answer');
Route::put('comment-stores', 'CommentController@store')->name('comment-store');
Route::get('comment-list', 'CommentController@index')->name('comment-list');
Route::get('comment-edit/{id}', 'CommentController@edit')->name('comment-edit');
Route::put('comment-update/{id}', 'CommentController@update')->name('comment-update');
Route::delete('comment-destroy/{id}', 'CommentController@destroy')->name('comment-destroy');
Route::get('comment-confirm/{id}', 'CommentController@confirm')->name('comment-confirm');

//Product
Route::get('product-create', 'ProductController@create')->name('product-create');
Route::post('product-store', 'ProductController@store')->name('product-store');
Route::get('product-list', 'ProductController@index')->name('product-list');
Route::get('product-active/{id}', 'ProductController@active')->name('product-active');
Route::get('product-edit/{id}', 'ProductController@edit')->name('product-edit');
Route::patch('product-update/{id}', 'ProductController@update')->name('product-update');
Route::delete('product-destroy/{id}', 'ProductController@destroy')->name('product-destroy');
Route::get('product-search', 'ProductController@search')->name('product-search');

//model
Route::get('model-photo-destroy/{id}', 'ModelController@photo_destroy')->name('model-photo-destroy');
Route::get('model-create/{id}', 'ModelController@create')->name('model-create');
Route::put('model-store/{id}', 'ModelController@store')->name('model-store');
Route::get('model-list/{id}', 'ModelController@index')->name('model-list');
Route::get('model-edit/{id}', 'ModelController@edit')->name('model-edit');
Route::patch('model-update/{id}', 'ModelController@update')->name('model-update');
Route::delete('model-destroy/{id}', 'ModelController@destroy')->name('model-destroy');
Route::post('model-active-default/{id}', 'ModelController@model_default')->name('model-active-default');

//model size
Route::post('model-size-store/{id}', 'ModelSizeController@store')->name('model-size-store');
Route::get('model-size/{id}', 'ModelSizeController@index')->name('model-size');
Route::post('model-size-update/{id}', 'ModelSizeController@update')->name('model-size-update');
Route::get('model-size-destroy/{id}', 'ModelSizeController@destroy')->name('model-size-destroy');

//product vip
Route::get('product-vip-list', 'ProductVipController@index')->name('product-vip-list');
Route::get('product-vip-search', 'ProductVipController@search')->name('product-vip-search');
Route::post('product-vip-update/{id}', 'ProductVipController@update')->name('product-vip-update');
Route::post('slider-vip-update', 'ProductVipController@slider_update')->name('slider-vip-update');

//archive-list
Route::get('inventory-archive/{id}/{type}', 'InventoryController@archive')->name('inventory-archive');
Route::get('inventory-archive-list', 'InventoryController@archive_list')->name('inventory-archive-list');
Route::get('inventory-archive-search', 'InventoryController@archive_search')->name('inventory-archive-search');

// slider
Route::get('slider-create', 'SliderController@create')->name('slider-create');
Route::put('slider-store', 'SliderController@store')->name('slider-store');
Route::get('slider-list', 'SliderController@index')->name('slider-list');
Route::get('slider-edit/{id}', 'SliderController@edit')->name('slider-edit');
Route::patch('slider-update/{id}', 'SliderController@update')->name('slider-update');
Route::delete('slider-destroy/{id}', 'SliderController@destroy')->name('slider-destroy');

// banner
Route::get('banner-create', 'BannerController@create')->name('banner-create');
Route::put('banner-store', 'BannerController@store')->name('banner-store');
Route::get('banner-list', 'BannerController@index')->name('banner-list');
Route::get('banner-edit/{id}', 'BannerController@edit')->name('banner-edit');
Route::patch('banner-update/{id}', 'BannerController@update')->name('banner-update');
Route::delete('banner-destroy/{id}', 'BannerController@destroy')->name('banner-destroy');

// article
Route::get('article-create', 'ArticleController@create')->name('article-create');
Route::put('article-store', 'ArticleController@store')->name('article-store');
Route::get('article-list', 'ArticleController@index')->name('article-list');
Route::get('article-edit/{id}', 'ArticleController@edit')->name('article-edit');
Route::patch('article-update/{id}', 'ArticleController@update')->name('article-update');
Route::delete('article-destroy/{id}', 'ArticleController@destroy')->name('article-destroy');

// article comment
Route::get('article-comment-reply/{id}', 'ArticleCommentController@create')->name('article-comment-reply');
Route::put('article-comment-reply-store/{id}', 'ArticleCommentController@store')->name('article-comment-reply-store');
Route::get('article-comment-list/{id}', 'ArticleCommentController@index')->name('article-comment-list');
Route::get('article-comment-edit/{id}', 'ArticleCommentController@edit')->name('article-comment-edit');
Route::patch('article-comment-update/{id}', 'ArticleCommentController@update')->name('article-comment-update');
Route::delete('article-comment-destroy/{id}', 'ArticleCommentController@destroy')->name('article-comment-destroy');
Route::get('article-comment-status/{id}', 'ArticleCommentController@status')->name('article-comment-status');

// footer
Route::get('footer-create', 'FooterController@create')->name('footer-create');
Route::put('footer-store', 'FooterController@store')->name('footer-store');
Route::get('footer-list', 'FooterController@index')->name('footer-list');
Route::get('footer-edit/{id}', 'FooterController@edit')->name('footer-edit');
Route::patch('footer-update/{id}', 'FooterController@update')->name('footer-update');
Route::delete('footer-destroy/{id}', 'FooterController@destroy')->name('footer-destroy');

//about
Route::get('About', 'AboutController@index')->name('admin-about');
Route::get('About-edit/{id}', 'AboutController@edit')->name('about-edit');
Route::post('About-edit/{id}', 'AboutController@edit1')->name('about-edit1');

//infocontact
Route::get('infocontact', 'InfoContactController@index')->name('admin-infocontact');
Route::get('infocontact-edit/{id}', 'InfoContactController@edit')->name('infocontact-edit');
Route::post('infocontact-edit/{id}', 'InfoContactController@edit1')->name('infocontact-edit1');

// contact
Route::get('contact-list', 'ContactController@index')->name('contact-list');
Route::delete('contact-destroy/{id}', 'ContactController@destroy')->name('contact-destroy');

// upload
Route::get('upload-create', 'UploadController@create')->name('upload-create');
Route::put('upload-store', 'UploadController@store')->name('upload-store');
Route::get('upload-list', 'UploadController@index')->name('upload-list');
Route::delete('upload-destroy/{id}', 'UploadController@destroy')->name('upload-destroy');

// off
Route::get('off-create', 'OffController@create')->name('off-create');
Route::put('off-store', 'OffController@store')->name('off-store');
Route::get('off-list', 'OffController@index')->name('off-list');
Route::delete('off-destroy/{id}', 'OffController@destroy')->name('off-destroy');

// seo
Route::get('meta-create', 'MetaController@create')->name('meta-create');
Route::put('meta-store', 'MetaController@store')->name('meta-store');
Route::get('meta-list', 'MetaController@index')->name('meta-list');
Route::get('meta-edit/{id}', 'MetaController@edit')->name('meta-edit');
Route::patch('meta-update/{id}', 'MetaController@update')->name('meta-update');
Route::delete('meta-destroy/{id}', 'MetaController@destroy')->name('meta-destroy');

// city
Route::post('city-free/{id}', 'CityController@city_free')->name('city-free-update');
Route::get('city-create', 'CityController@create')->name('city-create');
Route::put('city-store', 'CityController@store')->name('city-store');
Route::get('city-list', 'CityController@index')->name('city-list');
Route::get('city-edit/{id}', 'CityController@edit')->name('city-edit');
Route::patch('city-update/{id}', 'CityController@update')->name('city-update');
Route::delete('city-destroy/{id}', 'CityController@destroy')->name('city-destroy');
Route::post('city-sort', 'CityController@sort_item')->name('city-sort');
Route::post('city-search', 'CityController@search')->name('city-search');
Route::post('city-free/{id}', 'CityController@city_free')->name('city-free-update');

// tehran area
Route::get('tehran-area-list', 'TehranAreaController@index')->name('tehran-area-list');
Route::post('tehran-area-update/{id}', 'TehranAreaController@update')->name('tehran-area-update');
Route::post('tehran-area-percent', 'TehranAreaController@percent')->name('tehran-area-percent');
Route::get('tehran-area-percent-return', 'TehranAreaController@percent_return')->name('tehran-area-percent-return');
Route::get('tehran-area-status/{type}', 'TehranAreaController@status')->name('tehran-area-status');

// visitlog
Route::get('visitlogs', 'VisitlogController@index')->name('visitlogs');

// settings
Route::get('/settings', 'SettingController@index')->name('settings-list');
Route::post('/settingsUpdates/{id}', 'SettingController@update')->name('settingsUpdate');

//basket reserve
Route::get('basket-reserve-list', 'BasketReserveController@index')->name('basket-reserve-list');
Route::get('basket-reserve-show/{id}', 'BasketReserveController@show')->name('basket-reserve-show');

//order reserve
Route::get('order-reserve-list', 'BasketReserveController@myindex')->name('order-reserve-list');
Route::get('factor-send-reserve/{order_code}', 'BasketReserveController@send')->name('factor-send-reserve');

// Basket
Route::get('basket-list', 'BasketController@index')->name('basket-list');
Route::get('draftWait-list', 'BasketController@draftWait')->name('draftWait-list');
Route::get('send-list', 'BasketController@sendFactor')->name('send-list');
Route::get('give-list', 'BasketController@giveFactor')->name('give-factor');
Route::get('cancel-list', 'BasketController@cancelFactors')->name('factor-cancel');
Route::get('factor-lists', 'BasketController@allFactor')->name('factor-all');
Route::get('backPay-list', 'BasketController@backPay')->name('factor-backPay');
//basket not
Route::get('unsuccessful-basket-list', 'BasketController@unsuccessful_index')->name('unsuccessful-basket-list');
//basket print
Route::get('factor-print/{order_code}', 'BasketController@factor_print')->name('factor-print');
Route::get('factors_print', 'BasketController@factors_print')->name('factors-print');
Route::get('factor-print-all', 'BasketController@factor_print_all')->name('factor-print-all');
//show Basket
Route::get('factor-show/{order_code}', 'BasketController@factor_show')->name('factor-show');
// Search Basket
Route::get('factor-search-list', 'BasketController@search')->name('factor-all-search');
// Basket Work
Route::get('basket-confirm/{id}', 'BasketController@confirm')->name('basket-confirm');
Route::post('basket-confirm-all', 'BasketController@confirm_all')->name('basket-confirm-all');
Route::get('basket-okay/{id}', 'BasketController@okay')->name('basket-okay');
Route::post('basket-okay-all', 'BasketController@okay_all')->name('basket-okay-all');
Route::get('basket-return/{id}', 'BasketController@basket_return')->name('basket-return');
Route::get('basket-re_run/{id}', 'BasketController@basket_re_run')->name('basket-re_run');
//Basket Export
Route::post('factor-export-list', 'BasketController@export_date')->name('factor-all-export');

//Basket Order
Route::get('order-list', 'OrderController@index')->name('order-list');
Route::get('unsuccessful-order-list', 'OrderController@unsuccessful_index')->name('unsuccessful-order-list');
Route::get('factor-void/{order_code}', 'OrderController@factor_void')->name('factor-void');
Route::get('factor-edit/{order_code}', 'OrderController@factor_edit')->name('factor-edit');
Route::patch('factor-update/{order_code}', 'OrderController@factor_update')->name('factor-update');
Route::get('factor-return-credit-dudection/{order_code}', 'OrderController@factor_return_credit_dudection')->name('return-credit-dudection');

// draft
Route::get('draft-list', 'DraftController@index')->name('draft-list');
Route::get('draft-show/{id}', 'DraftController@draft_show')->name('draft-show');
Route::get('draft-confirm/{id}', 'DraftController@confirm')->name('draft-confirm');
Route::post('draft-confirm-all', 'DraftController@confirm_all')->name('draft-confirm-all');
Route::get('export-excel', 'DraftController@excel')->name('export-excel');

//best
Route::get('bestselling-list', 'InventoryController@bestselling')->name('bestselling-list');

//inventory
Route::get('inventory-list', 'InventoryController@index')->name('inventory-list');
Route::get('inventory-search', 'InventoryController@inventory_search')->name('inventory-search');
Route::post('inventory-update/{id}', 'InventoryController@update')->name('inventory-update');
Route::get('export-inventory-excel-panel', 'InventoryController@excel_export')->name('export-excel-inventory');

//report site
Route::get('report-site', 'InventoryController@report')->name('inventory-report');

//factor old
Route::get('factors-list-old', 'FactorController@index_old')->name('factors-list-old');
Route::get('factors-show-old/{order_code}', 'FactorController@show_old')->name('factors-show-old');
Route::get('factors-list-export-old', 'FactorController@export_old')->name('factors-export-old');

//factor new
Route::get('factors-search-model/{search}/{draft}', 'FactorController@search_model')->name('factors-search');
Route::get('factors-list', 'FactorController@index')->name('factors-list');
Route::get('factors-show/{id}', 'FactorController@show')->name('factors-show');
Route::get('factors-create/{draft}/{id?}', 'FactorController@create')->name('factors-create');
Route::post('factors-store/{id}', 'FactorController@store')->name('factors-store');
Route::get('factors-update-basket/{id}', 'FactorController@update_basket')->name('factors-update-basket');
Route::get('factors-destroy-basket/{id}', 'FactorController@destroy_basket')->name('factors-destroy-basket');
Route::post('factors-store-all/{id}', 'FactorController@store_all')->name('factors-store-all');
Route::get('factors-edit/{id}', 'FactorController@edit')->name('factors-edit');
Route::get('factors-destroy/{id}', 'FactorController@destroy')->name('factors-destroy');
Route::get('factors-active/{id}/{type}', 'FactorController@active')->name('factors-active');
Route::get('factors-mobile-search/{mobile}', 'FactorController@mobile_search')->name('factors-mobile-search');
Route::get('factors-export', 'FactorController@export')->name('factors-export');

//branch page
Route::get('branch-list', 'BranchController@index')->name('branch-list');
Route::get('branch-edit/{id}', 'BranchController@edit')->name('branch-edit');
Route::post('branch-update/{id}', 'BranchController@update')->name('branch-update');
Route::get('branch-active/{id}/{type}', 'BranchController@active')->name('branch-active');

//report sale
Route::get('report-sale', 'PanelController@report_sale')->name('report-sale');

// profile
Route::get('profile-show/{id}', 'ProfileController@show')->name('profile-show');
Route::get('profile-edit/{id}', 'ProfileController@edit')->name('profile-edit');
Route::get('profile-password-change/{id}', 'ProfileController@password')->name('profile-password');
Route::get('profile-info/{id}', 'ProfileController@info')->name('profile-info');
Route::patch('profile-update/{id}', 'ProfileController@update')->name('profile-update');
Route::patch('profile-password-update/{id}', 'ProfileController@password_update')->name('profile-password-update');
Route::patch('profile-info-update/{id}', 'ProfileController@info_update')->name('profile-info-update');


//// vip_pages
//Route::get('vip-pages-create', 'VipPagesController@create')->name('vip-pages-create');
//Route::put('vip-pages-store', 'VipPagesController@store')->name('vip-pages-store');
//Route::get('vip-pages-list', 'VipPagesController@index')->name('vip-pages-list');
//Route::get('vip-pages-edit/{id}', 'VipPagesController@edit')->name('vip-pages-edit');
//Route::patch('vip-pages-update/{id}', 'VipPagesController@update')->name('vip-pages-update');
//Route::delete('vip-pages-destroy/{id}', 'VipPagesController@destroy')->name('vip-pages-destroy');
//
//// slider-page
//Route::get('vip-slider-page-create', 'VipSliderPageController@create')->name('vip-slider-page-create');
//Route::put('vip-slider-page-store', 'VipSliderPageController@store')->name('vip-slider-page-store');
//Route::get('vip-slider-page-list', 'VipSliderPageController@index')->name('vip-slider-page-list');
//Route::get('vip-slider-page-edit/{id}', 'VipSliderPageController@edit')->name('vip-slider-page-edit');
//Route::patch('vip-slider-page-update/{id}', 'VipSliderPageController@update')->name('vip-slider-page-update');
//Route::delete('vip-slider-page-destroy/{id}', 'VipSliderPageController@destroy')->name('vip-slider-page-destroy');
//
//// vip-product-vip-page
//Route::post('vip-product-vip-page-store', 'VipProductPageController@store')->name('vip-product-vip-page-store');
//Route::get('vip-product-vip-page-list', 'VipProductPageController@index')->name('vip-product-vip-page-list');
//Route::delete('vip-product-vip-page-destroy/{id}', 'VipProductPageController@destroy')->name('vip-product-vip-page-destroy');

// payk user
Route::get('payk-user-create', 'PaykUserController@create')->name('payk-user-create');
Route::put('payk-user-store', 'PaykUserController@store')->name('payk-user-store');
Route::get('payk-user-list', 'PaykUserController@index')->name('payk-user-list');
Route::get('payk-user-edit/{id}', 'PaykUserController@edit')->name('payk-user-edit');
Route::patch('payk-user-update/{id}', 'PaykUserController@update')->name('payk-user-update');
Route::delete('payk-user-destroy/{id}', 'PaykUserController@destroy')->name('payk-user-destroy');

// payk factor
Route::post('payk-factor-store', 'PaykFactorController@store')->name('payk-factor-store');
Route::get('payk-factor-list', 'PaykFactorController@index')->name('payk-factor-list');
Route::delete('payk-factor-destroy/{id}', 'PaykFactorController@destroy')->name('payk-factor-destroy');
// payk factor report
Route::get('payk-factor-report', 'PaykFactorController@report_index')->name('payk-factor-report-list');


// customer list
 Route::get('sellers-list/{status}', 'SellerController@index')->name('sellers-list');
 Route::get('seller-show/{id}', 'SellerController@show')->name('seller-show');
 Route::get('seller-edit/{seller}', 'SellerController@edit')->name('seller-edit');
 Route::post('seller-update/{seller}', 'SellerController@update')->name('seller-update');
 Route::delete('seller-delete/{seller}', 'SellerController@destroy')->name('seller-delete');