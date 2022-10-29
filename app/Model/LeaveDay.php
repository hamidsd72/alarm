<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LeaveDay extends Model
{
    protected $table = 'leave_days';

    protected $fillable = [
        "reagent_id",
        "employee_id",
        "user_id",
        "count",
        "text",
        "start_at",
        "end_at",
    ];

    public function user()
    {
        return $this->belongsTo('App\User','user_id')->first(['first_name','last_name']);
    }

    public function employee()
    {
        return $this->belongsTo('App\User','employee_id')->first(['first_name','last_name']);
    }

}

