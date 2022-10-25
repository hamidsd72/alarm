<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use App\Model\Setting;
use App\Model\Permission;
use App\Model\ServiceBuy;
use App\Model\ProvinceCity;
use App\Model\Agent;
use App\Model\Meta;
use App\Model\Visit;
use App\Model\Network;
use App\Model\ServiceCat;
use App\Model\Notification;
use App\User;
use Illuminate\Support\Facades\Cookie;
class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot(Request $request)
    {

        $this->url = $request->fullUrl();
        Blade::directive('item', function ($name) {
            return "<?php echo $name ?>";
        });

        Schema::defaultStringLength(191);
        Carbon::setLocale('fa');

        
        view()->composer('layouts.admin', function ($view) {
            $id = auth()->user()->reagent_id;
            if (in_array(auth()->user()->getRoleNames()->first(),['مدیر ارشد','مدیر'])) {
                $id = auth()->user()->id;
            }
            $allUsers = User::where('reagent_id',$id)->get(['id','first_name','last_name']);
            $setting = Setting::where('user_id', $id)->first();
            if (!file_exists($setting->icon_site) ) {
                $setting->icon_site = Setting::first()->icon_site;
            }
            if (!file_exists($setting->logo_site) ) {
                $setting->logo_site = Setting::first()->logo_site;
            }
            $view->with('order', ServiceBuy::where('status','pending')->count());
            $view->with('permission', Permission::where('user_id', $id)->where('name', auth()->user()->getRoleNames()->first() )->first() );
            $view->with('setting', $setting);
            $view->with('agent', User::role('نماینده')->where('user_status','pending')->count());
            $view->with('allUsers', $allUsers);
            $view->with('agent_request', Agent::where('seen',0)->count());
        });
        view()->composer('layouts.user', function ($view) {
            //visit
            $ip = getenv('HTTP_CLIENT_IP') ?:
                getenv('HTTP_X_FORWARDED_FOR') ?:
                    getenv('HTTP_X_FORWARDED') ?:
                        getenv('HTTP_FORWARDED_FOR') ?:
                            getenv('HTTP_FORWARDED') ?:
                                getenv('REMOTE_ADDR');
            $date=date('Y-m-d');
            $visit_old=Visit::whereDate('created_at','=',$date)->where('ip',$ip)->first();
            if($visit_old)
            {
                $visit_old->view+=1;
                $visit_old->update();
            }
            else {
                $visit=new Visit();
                $visit->ip=$ip;
                $visit->view=1;
                $visit->save();
            }
            $id = auth()->user()->reagent_id;
            if (in_array(auth()->user()->getRoleNames()->first(),['مدیر ارشد','مدیر'])) {
                $id = auth()->user()->id;
            }
            $seo = Meta::where('user_id', $id)->where('url', $this->url)->first();
            if (is_null($seo)) {
                $seo = Meta::where('user_id', $id)->where('url', $this->url . '/')->first();
                if (is_null($seo)) {
                    $seo = Meta::where('user_id', $id)->where('url', explode('?', $this->url)[0])->first();
                    if (is_null($seo)) {
                        $seo = Meta::where('user_id', $id)->where('url', explode('?', $this->url)[0] . '/')->first();
                    }
                }
            }
            $setting=Setting::where('user_id', $id)->first();
            if (!is_null($seo)) {
                $titleSeo = $seo->title;
                $keywordsSeo = $seo->key_word;
                $descriptionSeo = $seo->description;
            }
            else {
                $titleSeo = $setting->title;
                $keywordsSeo = $setting->keyword;
                $descriptionSeo = $setting->description;
            }
            
            // $ServiceCat = ServiceCat::where('type', 'service')->orderBy('id', 'ASC')->get();
            $view
                ->with('setting', $setting)
                ->with('titleSeo', $titleSeo)
                ->with('keywordsSeo', $keywordsSeo)
                ->with('descriptionSeo', $descriptionSeo);
                // ->with('ServiceCats', $ServiceCat);
            if (Cookie::get('basket') != null){
                $view->with('BasketCount', count(json_decode(Cookie::get('basket'))));
            }else {
                $view->with('BasketCount', '');
            }
        });
        
        // view()->composer('layouts.auth', function ($view) {
            
        //     if (Setting::where('user_id', auth()->user()->id)->first()) {
        //         $setting = Setting::where('user_id', auth()->user()->id)->first();
        //     } else {
        //         $setting = Setting::where('user_id', auth()->user()->reagent_id)->first();
        //     }

        //     $view->with('setting', $setting);
        // });
        // view()->composer('auth.register', function ($view) {
        //     $view->with('states', ProvinceCity::where('parent_id',null)->get());
        //     $view->with('setting', Setting::find(1));
        // });
        // view()->composer('auth.register.mobile', function ($view) {

        //     if (Setting::where('user_id', auth()->user()->id)->first()) {
        //         $setting = Setting::where('user_id', auth()->user()->id)->first();
        //     } else {
        //         $setting = Setting::where('user_id', auth()->user()->reagent_id)->first();
        //     }
        //     $view->with('states', ProvinceCity::where('parent_id',null)->get());
        //     $view->with('setting', $setting);
        // });
        view()->composer('includes.header', function ($view) {
            $id = 1;
            if (auth()->user()) {
                $id = auth()->user()->reagent_id;
                if (in_array(auth()->user()->getRoleNames()->first(),['مدیر ارشد','مدیر'])) {
                    $id = auth()->user()->id;
                }
            }
            $setting = Setting::where('user_id', $id)->first();
            if (!file_exists($setting->icon_site) ) {
                $setting->icon_site = Setting::first()->icon_site;
            }
            if (!file_exists($setting->logo_site) ) {
                $setting->logo_site = Setting::first()->logo_site;
            }
            // $view->with('ServiceCats', ServiceCat::where('user_id', $id)->where('status', 'active')->where('type', 'service')->orderByDesc('id')->get());
            $view->with('notification', Notification::where('user_id', auth()->user()->id)->where('status', 'pending')->count());
            $view->with('setting', $setting);
            $view->with('network', Network::where('status', 'active')->orderBy('sort')->get());
        });
        view()->composer('includes.head', function ($view) {
            $id = 1;
            if (auth()->user()) {
                $id = auth()->user()->reagent_id;
                if (in_array(auth()->user()->getRoleNames()->first(),['مدیر ارشد','مدیر'])) {
                    $id = auth()->user()->id;
                }
            }
            $setting = Setting::where('user_id', $id)->first();
            if (!file_exists($setting->icon_site) ) {
                $setting->icon_site = Setting::first()->icon_site;
            }
            if (!file_exists($setting->logo_site) ) {
                $setting->logo_site = Setting::first()->logo_site;
            }
            $view->with('setting', $setting);
        });
    }
    
}
