<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Model\Sms;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'mobile',
        'password', 
        'mobile_verified',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
    public function photo()
    {
        return $this->morphOne('App\Model\Photo', 'pictures');
    }
    public function file()
    {
        return $this->morphOne('App\Model\Filep', 'files');
    }
    public function setJob()
    {
        return $this->hasMany('App\Model\ServicePackage','user_id');
    }
    public function setting()
    {
        return $this->hasMany('App\Model\Setting','user_id');
    }
    public function about()
    {
        return $this->hasMany('App\Model\About','user_id');
    }
    public function state()
    {
        return $this->belongsTo('App\Model\ProvinceCity','state_id');
    }
    public function city()
    {
        return $this->belongsTo('App\Model\ProvinceCity','city_id');
    }
    public function reagent()
    {
        return $this->hasOne('App\User','reagent_id','reagent_code');
    }
    public function marketer()
    {
        return $this->belongsTo('App\Model\Marketer','id','user_id');
    }
    public function agent()
    {
        return $this->belongsTo('App\Model\Agent','id','user_id');
    }
    public function employees_count()
    {
        return $this->belongsTo('App\User','id','reagent_id')->count();
    }
    public function my_employees()
    {
        return $this->hasMany('App\Model\TaskMaster','master_id');
    }
    
    public function admin_request() {
        return $this->belongsTo('App\Model\Visit','user_id')->where('status','pending')->count();
    }
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($item) {
            $item->photo()->get()
                ->each(function ($photo) {
                    $path = $photo->path;
                    File::delete($path);
                    $photo->delete();
                });
            $item->file()->get()
                ->each(function ($file) {
                    $path = $file->path;
                    File::delete($path);
                    $file->delete();
                });
        });
    }

    public static function is_special_user($user_id) {

        if( Carbon::parse(\App\User::find( $user_id )->special_user)->diffInDays(Carbon::now(), false) > 0 ) {
            return false;
        } else {
            return true;
        }
    }

    public static function send_warning_end_time($user_id) {
        $user = \App\User::find( $user_id );
        if( $user && (Carbon::parse($user->special_user)->diffInDays(Carbon::now(), false) + 6) > 0 && Carbon::parse($user->warning_end_time)->diffInDays(Carbon::now(), false) > 0 ) {
            try {
                $message = '.مشترک گرامی تاریخ سرویس شما رو به پایان است '.' سامانه '.\App\Model\Setting::find(1)->title;
                Sms::SendSms( $message , $user->mobile);
                $user->warning_end_time = Carbon::now()->format('Y-m-d');
                $user->update();
            } catch (\Throwable $th) {
                
            }
        }
    }
}
