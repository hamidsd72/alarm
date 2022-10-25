<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs';

    protected $fillable = [
        "id",
        "reagent_id",
        "title",
        "created_at",
        "updated_at",
    ];

}

