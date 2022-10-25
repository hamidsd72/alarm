<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class About extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($item) {
            File::delete($item->pic);
            File::delete($item->pic_home);
            File::delete($item->pic_guide);
            File::delete($item->pic_rule);
        });
    }
}
