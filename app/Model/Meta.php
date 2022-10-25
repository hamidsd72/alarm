<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class Meta extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public static function status($type)
    {
        switch ($type){
            case 'pending':
                return '<span class="badge bg-danger">غیر فعال</span>';
                break;
            case 'active':
                return '<span class="badge bg-success">فعال</span>';
                break;
            default:
                return '';
                break;
        }
    }
}
