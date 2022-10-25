<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SendMessage extends Model
{
    protected $table = 'send_messages';

    protected $fillable = [
        "count",
        "reagent_id",
        "created_at",
        "updated_at",
    ];

    public function AdminCheckSendMessage() {
        return $this->belongsTo('App\Model\SendMessage','id')->first(['count']);
    }
    public function UserCheckSendMessage() {
        return $this->belongsTo('App\Model\SendMessage','reagent_id')->first(['count']);
    }
}
