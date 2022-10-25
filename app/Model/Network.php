<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Network extends Model
{
    protected $table = 'networks';

    protected $fillable = [
        "id",
        "name",
        "user_id",
        "status",
        "address",
        "config",
        "sort",
        "created_at",
        "updated_at",
    ];
}
