<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class FormPrice extends Model
{
    protected $table = 'formـprices';
   
    protected $fillable = [
        'form_name',
        'amount',
        'off_amount',
        'month',
        'background',
        'type'
    ];

    public function check_type($val) {
        switch ($val){
            case 'package':
                return 'بسته';
                break;
            case 'user':
                return 'کاربر';
                break;
            case 'sms':
                return 'پیامک';
                break;
            default:
                return $val;
                break;
        }
    }

}
 