<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;

class Visit extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id')->first(['id','first_name','last_name']);
    }

    public function type($type)
    {
        switch ($type){
            case 'today':
                $date=Carbon::today()->toDateString();
                $all=Visit::whereDate('created_at',$date)->sum('view');
                $person=Visit::whereDate('created_at',$date)->count();
                return ['all'=>$all,'person'=>$person];
                break;
            case 'yesterday':
                $date=Carbon::yesterday()->toDateString();
                $all=Visit::whereDate('created_at',$date)->sum('view');
                $person=Visit::whereDate('created_at',$date)->count();
                return ['all'=>$all,'person'=>$person];
                break;
            case 'this_month':
                $date=Carbon::now();
                $year=$date->format('Y');
                $month=$date->format('m');
                $all=Visit::whereYear('created_at',$year)->whereMonth('created_at',$month)->sum('view');
                $person=Visit::whereYear('created_at',$year)->whereMonth('created_at',$month)->count();
                return ['all'=>$all,'person'=>$person];
                break;
            case 'last_month':
                $date=Carbon::now()->addMonth(-1);
                $year=$date->format('Y');
                $month=$date->format('m');
                $all=Visit::whereYear('created_at',$year)->whereMonth('created_at',$month)->sum('view');
                $person=Visit::whereYear('created_at',$year)->whereMonth('created_at',$month)->count();
                return ['all'=>$all,'person'=>$person];
                break;
            case 'this_year':
                $date=Carbon::now();
                $year=$date->format('Y');
                $all=Visit::whereYear('created_at',$year)->sum('view');
                $person=Visit::whereYear('created_at',$year)->count();
                return ['all'=>$all,'person'=>$person];
                break;
            case 'last_year':
                $date=Carbon::now()->addYear(-1);
                $year=$date->format('Y');
                $all=Visit::whereYear('created_at',$year)->sum('view');
                $person=Visit::whereYear('created_at',$year)->count();
                return ['all'=>$all,'person'=>$person];
                break;
            case 'all':
                $all=Visit::sum('view');
                $person=Visit::count();
                return ['all'=>$all,'person'=>$person];
                break;
            default:
                return 'نامعلوم';
                break;
        }
    }
}
