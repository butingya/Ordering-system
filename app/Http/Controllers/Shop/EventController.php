<?php

namespace App\Http\Controllers\Shop;

use App\Models\Event;
use App\Models\EventPrize;
use App\Models\EventUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class EventController extends Controller
{
    //显示
    public function index(){
        $events = Event::all();
        return view("shop.event.index",compact("events"));
    }
    
    //报名
    public function sign($id){
        $event = Event::find($id);
        //报名人数
        $num = EventUser::where("event_id",$event->id)->count();
        $user = EventUser::where("user_id",Auth::user()->id)->first();
        //判断
        if ($num > $event->num) {
            return back()->with("success","报名成功");
        }
        //当前用户 id
        $data = [
            "user_id" => Auth::user()->id,
            "event_id" => $id
        ];

        if (isset($user->user_id)) {
            return back()->with("warning","你已报名");
        }
        EventUser::create($data);
        return back()->with("success","报名成功 等待开奖");
    }

    //中奖信息
    public function info($id){
        $prizes = EventPrize::where("event_id",$id)->get();
        return view("shop.event.info",compact("prizes"));
    }

    //活动详情
    public function look($id){
        $events = Event::all();
        return view("shop.event.look",compact("events"));
    }
}
