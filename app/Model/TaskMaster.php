<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TaskMaster extends Model
{
    protected $table = 'task_masters';

    protected $fillable = [
        "reagent_id",
        "master_id",
        "employee_id",
    ];

    public function employee()
    {
        return $this->belongsTo('App\User','employee_id')->first(['first_name','last_name','mobile','email','whatsapp']);
    }

    public function master()
    {
        return $this->belongsTo('App\User','master_id')->first(['first_name','last_name','mobile','email','whatsapp']);
    }

    public function reagent()
    {
        return $this->belongsTo('App\User','reagent_id')->first(['first_name','last_name','mobile','email','whatsapp']);
    }

}
