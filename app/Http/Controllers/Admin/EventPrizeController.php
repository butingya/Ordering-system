<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use App\Models\EventPrize;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventPrizeController extends BaseController
{
    //显示
    public function index(){
        $prizes = EventPrize::all();
        return view("admin.prize.index",compact('prizes'));
    }

    //添加
    public function add(Request $request){
        //判断提交方式
        if ($request->isMethod("post")) {
            //接收数据，数据入库，显示视图
            $data = $request->post();
            EventPrize::create($data);
            return redirect()->route("admin.prize.index")->with("success", "活动添加成功");
        }
        //显示视图
        $events = Event::all();
        return view("admin.prize.add",compact('events'));
    }

    //修改
    public function edit(Request $request,$id){
        //通过id找对象
        $prize = EventPrize::find($id);

        //是不是post提交
        if ($request->isMethod("post")) {
            $data = $request->post();
            //数据入库
            if ($prize->update($data)) {
                //页面跳转
                return redirect()->route("admin.prize.index")->with("success","奖品修改成功");
            }
        }  else{
            //显示视图
            $events = Event::all();
            return view("admin.prize.edit",compact("prize","events"));
        }
    }

    //删除
    public function del($id){
        //通过id找到他
        $prize = EventPrize::find($id);
        //删除
        if ($prize->delete()) {
            return redirect()->route('admin.prize.index')->with("success","删除成功");
        }
    }
}
