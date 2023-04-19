<?php 

Route::resource('forms', 'FormController');
Route::resource('job-report', 'JobReportController');
Route::resource('notification', 'NotificationController');
Route::get('/', 'GuestController@index')->name('home-goust');
Route::get('/sign-up', 'GuestController@register')->name('home-guost-register');
Route::get('/pwa', 'GuestController@create')->name('home-guost-pwa');
Route::get('/remember-password/{number}', 'GuestController@remember_password')->name('remember-password');
Route::get('/remember-password/set-password-by-token/{token}', 'GuestController@set_password_by_token')->name('set-password-by-token');
Route::post('/remember-password/update-password-by-token/', 'GuestController@update_password_by_token')->name('update-password-by-token');
Route::post('/store/new-user/', 'NewRegisterController@sign_up')->name('register.new.user');
Route::get('/app', 'HomeController@index')->name('index');
Route::get('/update-roll-call', 'HomeController@updateRollCall')->name('updateRollCall');
Route::get('/services/{cat_id}', 'HomeController@services')->name('services');
Route::get('/service/{id}/{slug}', 'HomeController@service')->name('service');
Route::get('/packages_category', 'HomeController@packages_category')->name('package.category');
Route::get('/packages', 'HomeController@packages')->name('packages');
Route::get('/package/{slug}', 'HomeController@package')->name('package');
Route::get('/user-job/create/{package_id}', 'HomeController@job_create')->name('job_create');
Route::get('/offline/job/create/{package_id}/{created_at}/{description}', 'HomeController@offline_job_create')->name('offline_job_create');
Route::post('/job/stop', 'HomeController@job_stop')->name('job_stop');
Route::get('/reserve/{type}/{slug}', 'HomeController@reserve')->name('reserve');
Route::post('/validation-email', 'HomeController@validation_email')->name('validation.email');
Route::get('/login-package-buy/{slug}/{price_id?}', 'HomeController@login_package_buy')->name('login.package.buy');
Route::get('/package-buy', 'HomeController@package_buy')->name('package.buy');
Route::get('/off_check/{code}/{price}', 'HomeController@off_check')->name('off.check');
//bascket 
Route::get('/basket/view', 'BasketController@index')->name('basket_index');
Route::get('/add_basket/{id}/{type}', 'BasketController@add_basket')->name('add_basket');
Route::get('/level_1', 'BasketController@level_1')->name('basket.list');
Route::post('/level_2', 'BasketController@level_2')->name('basket.pay');
Route::get('/basket_del/{id}/{type}', 'BasketController@del_basket')->name('basket.del');
/*Route::get('/basket_del', 'BasketController@del_basket')->name('basket.del');*/

Route::get('report/user-transaction/{id}', 'TransactionController@index')->name('user-transaction-report');
Route::resource('user-transaction', 'TransactionController');
Route::get('ads/tours/{name}', 'TourAdsController@show')->name('ads-tours-show-guest');
Route::get('ads/tours/{name}/edit', 'TourAdsController@edit')->name('admin-ads-tours-filter');
Route::get('ads/tours/service-destroy/{id}', 'TourAdsController@destroy')->name('admin-ads-tours-service-destroy');
Route::get('ads/tours/filter/{id}', 'TourAdsController@index')->name('ads-tours-index-filter');
Route::resource('user-tours', 'TourAdsController');
Route::resource('sign-up-using-mobile', 'NewRegisterController');
Route::resource('my-user', 'UserController');
Route::resource('user-search', 'SearchController');
Route::resource('user-my-report', 'ReportController');
// Route::post('user/search/services', 'SearchController@search')->name('services-search');

// ticket 
Route::get('user/show/tikects', 'HomeController@tickets')->name('tickets'); 
Route::get('user/show/tikect/{id}', 'HomeController@show_ticket')->name('show-ticket'); 

//register
Route::get('user-register/{code}', 'RegisterController@register')->name('register'); 
Route::get('agent-register', 'RegisterController@agent')->name('agent.register');
Route::get('user-register', 'RegisterController@mobile')->name('mobile');
Route::post('mobile-post', 'RegisterController@mobile_post')->name('mobile.post');
Route::get('verify-code', 'RegisterController@verify')->name('verify');
Route::post('verify-code-post', 'RegisterController@verify_post')->name('verify.post');
Route::get('complete', 'RegisterController@complete')->name('complete');
Route::post('complete-post', 'RegisterController@complete_post')->name('complete.post');
Route::get('complete-agent', 'RegisterController@complete_agent')->name('complete.agent');
Route::post('complete-agent-post', 'RegisterController@complete_agent_post')->name('complete.agent.post');

//reset password
Route::get('user-reset-password', 'PasswordController@reset_password_show')->name('reset.password.show');
Route::post('user-reset-password-post', 'PasswordController@reset_password_post')->name('reset.password.post');
Route::get('verify-reset-password', 'PasswordController@reset_password_verify')->name('reset.password.verify');
Route::post('verify-reset-password-post', 'PasswordController@reset_password_verify_post')->name('reset.password.verify.post');
Route::get('new-password', 'PasswordController@new_password')->name('new.password');
Route::post('new-password-post', 'PasswordController@new_password_post')->name('new.password.post');

// contact us
Route::get('contact-us', 'ContactController@show')->name('contact.show');
// Route::post('contact-us-post', 'ContactController@form_post')->name('contact.post');
Route::post('contact-us-post', 'TicketController@form_post')->name('contact.post');

// guide user
Route::get('about-us', 'AboutController@show')->name('about.show');

// guide user
Route::get('guide-user', 'GuideController@show')->name('guide.show');

// rules
Route::get('rules', 'RuleController@show')->name('rule.show');

// agent
Route::get('agent-rule', 'AgentController@show')->name('agent.rule.show');
Route::post('agent-request', 'AgentController@agent_request')->name('agent.request');

//zarin pal
Route::any('zarinpal-pay/{id}/{total}/{user}/{type}', 'ZarinpalController@pay')->name('zarinpal-pay-user');
Route::any('zarinpal-verify', 'ZarinpalController@verify')->name('verify_user');
//zarin pal new
Route::any('zarinpal-pay-new/{factor_id}/{user_id}', 'ZarinpalNewController@pay')->name('zarinpal.pay.new');
Route::any('zarinpal-verify-new', 'ZarinpalNewController@verify')->name('verify.new');

//refah
Route::any('refah-pay/{id}/{type}', 'RefahController@pay')->name('refah.pay');
Route::any('refah-verify', 'RefahController@verify')->name('refah.verify');


Route::view('questions','user.questions')->name('questions');
// Route::view('services','user.services')->name('services');


