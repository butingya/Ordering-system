<?php

namespace App\Http\Controllers\Shop;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends BaseController
{
    //显示有效活动
    public function index(){
        $activitys=Activity::where("end_time",">=",date('Y-m-d H:i:s', time()))->get();
        return view("shop.activity.index",compact("activitys"));
     }
}
