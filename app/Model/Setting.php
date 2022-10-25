<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Setting extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($item) {
            $path = $item->logo_site;
            $path1 = $item->icon_site;
            File::delete($path);
            File::delete($path1);
        });
    }
}
