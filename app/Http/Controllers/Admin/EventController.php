<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\EventPrize;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EventController extends BaseController
{
    //显示
    public function index(Request $request){
        $events = Event::all();
        return view("admin.event.index",compact('events'));
    }

    //添加
    public function add(Request $request){
        //判断提交方式
        if ($request->isMethod("post")) {
            //接收数据，数据入库，显示视图
            $data = $request->post();
            //时间转换
            $data["start_time"] = strtotime($data["start_time"]);
            $data["end_time"] = strtotime($data["end_time"]);
            $data["prize_time"] = strtotime($data["prize_time"]);
            //验证
//            $this->validate($request, [
//                "title" => "required|unique:events",
//                "content" => "required|max:226",
//                "end_time" => "required",
//                "start_time" => "required",
//                "prize_time" => "required",
//                "num" => "required",
//                "is_prize" => "required",
//            ]);
            Event::create($data);
            return redirect()->route("admin.event.index")->with("success", "活动添加成功");
        }
            //显示视图
            return view("admin.event.add");
        }

        //编辑
    public function edit(Request $request,$id){
        //通过id找对象
        $event = Event::find($id);

        //是不是post提交
        if ($request->isMethod("post")) {
            $data = $request->post();
            //时间转换
            $data["start_time"] = strtotime($data["start_time"]);
            $data["end_time"] = strtotime($data["end_time"]);
            $data["prize_time"] = strtotime($data["prize_time"]);

            //数据入库
            if ($event->update($data)) {
                //页面跳转
                return redirect()->route("admin.event.index")->with("success","活动修改成功");
            }
        }  else{
            //显示视图
            return view("admin.event.edit",compact("event"));
        }
    }
    //删除
    public function del($id){
        //通过id找到他
        $event = Event::find($id);
        //删除
        if ($event->delete()) {
            return redirect()->route('admin.event.index')->with("success","活动删除成功");
        }
    }

    //抽奖
    public function open(Request $request,$id){
        //取出已经报名的用户id
        $userId = DB::table('event_users')->where('event_id',$id)->pluck('user_id')->toArray();
        //打乱id
        shuffle($userId);
        //活动奖品，打乱
        $prizes = EventPrize::where("event_id",$id)->get()->shuffle();

        foreach ($prizes as $k=>$prize ){
            $prize->user_id = $userId[$k];

            //获取商家信息
            $user = User::find($prize->user_id);
            $name = $user->name;
            $email = $user->email;
            //发送邮件
            $shopName=$name;
            $to = $email;//收件人
            $subject = $shopName.' 审核通知';//邮件标题
            \Illuminate\Support\Facades\Mail::send(
                'emails.prize',//视图
                compact("shopName"),//传递给视图的参数
                function ($message) use($to, $subject) {
                    $message->to($to)->subject($subject);
                }
            );

            $prize->save();
        }
        //修改活动状态
        $event = Event::find($id);
        $event->is_prize=1;
        $event->save();

        return redirect()->route('admin.event.index')->with('success','已开奖');
    }

    //中奖信息
    public function info($id){
        $prizes = EventPrize::where("event_id",$id)->get();
        return view("admin.event.info",compact("prizes"));
    }
}
