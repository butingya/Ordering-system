<?php

namespace App\Http\Controllers\Admin;

use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends BaseController
{
    //查看全部活动
    public function index(Request $request){
        $url = $request->query();
       //接收数据
        $keyword = $request->get("keyword");
        $time = $request->get("time");
       //得到数据
        $query = Activity::orderBy("id");
       //得到当前时间
        $date = date('Y-m-d H:i:s',time());
        //未开始
        if ($time == 1){
            $query->where("start_time",">",$date);
        }
        //进行中
        if ($time == 2){
            $query->where("end_time",">=",$date)->where("start_time","<=",$date);
        }
        //已结束
        if ($time == 3){
            $query->where("end_time","<",$date);
        }
        //搜索标题和内容
        if ($keyword!==null) {
            $query->where("title","like","%{$keyword}%")->where("content","like","%{$keyword}%");
        }
        $activitys = $query->paginate(3);
        return view("admin.activity.index",compact("activitys","url"));
      }

    //活动添加
    public function add(Request $request){
        //判断提交方式
        if ($request->isMethod("post")) {
            //接收数据，数据入库，显示视图
            $data = $request->post();
            if (Activity::create($data)) {
                return redirect()->route("admin.activity.index")->with("success","活动添加成功");
            }
        }else{
            //显示视图
            return view("admin.activity.add");
        }
    }

    //活动修改
    public function edit(Request $request,$id){
        //通过id找对象
        $activity = Activity::find($id);

        $activity->start_time=str_replace(" ","T",$activity->start_time);
        $activity->end_time=str_replace(" ","T",$activity->end_time);
        //是不是post提交
        if ($request->isMethod("post")) {
            $data = $request->post();
            //验证
            $da= $this->validate($request,[
                "title"=>"required",
                "start_time"=>"required",
                "end_time"=>"required",
                "content"=>"required"
            ]);
            $da['start_time']=str_replace("T"," ",$da['start_time']);
            $da['end_time']=str_replace("T"," ",$da['end_time']);
            //数据入库
            if ($activity->update($data)) {
                //页面跳转
                return redirect()->route("admin.activity.index")->with("success","活动修改成功");
            }
        }  else{
            //显示视图
            return view("admin.activity.edit",compact("activity"));
        }
    }






    //删除活动
    public function del($id){
        //通过id找到他
        $activity = Activity::find($id);
        //删除
        if ($activity->delete()) {
            return redirect()->route('admin.activity.index')->with("success","活动删除成功");
        }
    }
}
