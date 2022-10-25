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
        "date",
        "description",
        "reagent_id",
    ];

    public function user() {
        return $this->belongsTo('App\User','user_id')->first();
    }
    public function user_employee() {
        return $this->belongsTo('App\User','employee_id')->first();
    }
}
