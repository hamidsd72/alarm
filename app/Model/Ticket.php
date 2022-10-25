<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Ticket extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];
    public function parent()
    {
        return $this->hasOne('App\Model\Ticket', 'parent_id');
    }
    public function children()
    {
        return $this->hasMany('App\Model\Ticket', 'parent_id')->orderBy('id', 'DESC');
    }
    public function user_create()
    {
        return $this->belongsTo('App\User', 'create_user_id');
    }
    public function user_edit()
    {
        return $this->belongsTo('App\User', 'update_user_id');
    }
    public function files()
    {
        return $this->morphMany('App\Model\Filep', 'files');
    }
}