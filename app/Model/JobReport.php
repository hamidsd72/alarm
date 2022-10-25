<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class JobReport extends Model
{
    protected $table = 'job_report';

    protected $fillable = [
        "id",
        "user_id",
        "status",
        "location",
        "job_id",
        "time",
        'price',
        "description",
        "attach",
        "created_at",
        "updated_at",
    ];

    public function job() {
        return $this->belongsTo('App\Model\ServicePackage','job_id')->first();
    }

    public function job_price() {
        return $this->belongsTo('App\Model\ServicePackage','job_id')->first(['title','price']);
    }
}

