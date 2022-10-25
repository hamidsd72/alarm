<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Custom extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public function photo()
    {
        return $this->morphOne('App\Model\Photo', 'pictures');
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
        });
    }
}
