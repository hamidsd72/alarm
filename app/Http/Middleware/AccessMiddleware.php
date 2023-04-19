<?php

namespace App\Http\Middleware;

use Closure;

class AccessMiddleware
{
    public function handle($request, Closure $next)
    {

        $action     = app('request')->route()->getAction();
        $controller = class_basename($action['controller']);
        $controller = explode('@', $controller)[0];
        $access_per = '';
        if ( in_array(      $controller , ['UserController', 'MarteterController', 'LeaveDayController', 'TaskMasterController', 'VisitLogController', ] ) ) {
            $access_per = 'کاربران';
        } elseif ( in_array($controller , ['ContactController', 'NotificationController', ] ) ) {
            $access_per = 'اعلانات';
        } elseif ( in_array($controller , ['JobController', 'ServicePackageController', 'JobReportController', ] ) ) {
            $access_per = 'فعالیتها';
        } elseif ( in_array($controller , ['JobReportController', 'UserRequestController', 'RollCallController', ] ) ) {
            $access_per = 'حسابداری';
        } elseif ( in_array($controller , ['SliderController', 'AboutController', ] ) ) {
            $access_per = 'محتوا';
        } elseif ( in_array($controller , ['SettingController', 'OffDayController', ] ) ) {
            $access_per = 'تنظیمات';
        }
        
        if (in_array(auth()->user()->getRoleNames()->first(),['مدیر ارشد','مدیر'])) return $next($request);

        $access     = [''];
        $permission = \App\Model\Permission::where('user_id', auth()->user()->reagent_id)->where('name', auth()->user()->getRoleNames()->first() )->first();
        if ( $permission && $permission->access ) $access = explode(",", $permission->access );

        if ( in_array( $access_per ,  $access ) ) return $next($request);
        abort('401');
    }
}
