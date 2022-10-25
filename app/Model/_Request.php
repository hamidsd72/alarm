<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';

    protected $fillable = [
        "user_id",
        "employee_id",
        "title",
        "description",
        "reagent_id",
    ];
}
