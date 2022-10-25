<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Basket extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function factor()
    {
        return $this->belongsTo('App\Model\BasketFactor','factor_id');
    }
    public function service()
    {
        return $this->belongsTo('App\Model\Service','sale_id');
    }
    public function package()
    {
        return $this->belongsTo('App\Model\ServicePackage','sale_id');
    }
}
