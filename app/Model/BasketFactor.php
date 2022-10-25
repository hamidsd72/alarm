<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class BasketFactor extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function baskets()
    {
        return $this->hasMany('App\Model\Basket','factor_id');
    }
    public function verify()
    {
        return $this->hasOne('App\Model\Transaction','factor_id')->where('type','factor');
    }
    public function check_status($val)
    {
        switch ($val){
            case 'active':
                return '<span class="badge bg-success"> نهایی</span>';
                break;
            case 'pending':
                return '<span class="badge bg-info">ثبت اولیه</span>';
                break;
            case 'error':
                return '<span class="badge bg-warning">بازگشت از بانک</span>';
                break;
            case 'cancel':
                return '<span class="badge bg-danger">کنسل شده</span>';
                break;
            default:
                return '';
                break;
        }
    }
}
