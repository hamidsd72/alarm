<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        "id",
        "user_id",
        "status",
        "subject",
        "description",
        "atach",
        "created_at",
        "updated_at",
    ];

    public function user()
    {
        return $this->belongsTo('App\User','user_id')->first();
    }
}

