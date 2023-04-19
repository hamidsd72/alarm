<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
        "id",
        "page_name",
        "section",
        "position",
        "sort",
        "text",
        'title',
        'pic',
        "status",
    ];

}

