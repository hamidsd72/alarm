<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Agent extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $fillable = [
        "id",
        "first_name",
        "last_name",
        "company_name",
        "phone",
        "mobile",
        "text",
        "user_id",
        "status",
        "address",
        "city",
        "locate",
        "long_lat",
    ];

    public function file()
    {
        return $this->morphOne('App\Model\Filep', 'files');
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($item) {
            $item->file()->get()
                ->each(function ($file) {
                    $path = $file->path;
                    File::delete($path);
                    $file->delete();
                });
        });
    }
}
