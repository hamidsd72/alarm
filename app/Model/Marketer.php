<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Marketer extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($item) {
           
        });
    }
}
