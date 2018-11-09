<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class PerController extends BaseController
{

    //权限列表
    public function index(){
        $pers = Permission::orderBy("id")->paginate(5);
        return view("admin.per.index",compact('pers'));
    }

    //添加权限
    public function add(Request $request){

        //声明一个空数组来装路由名字
        $urls = [];
        //得到所有路由
        $routes = Route::getRoutes();
        //循环
        foreach ($routes as $route){
            if ($route->action["namespace"] == "App\Http\Controllers\Admin") {
                //取别名存入$url
                $urls[] = $route->action['as'];
            }
        }
        //从数据库取出
        $pers = Permission::pluck("name")->toArray();
        //把已经存在的路由去掉
        $urls = array_diff($urls,$pers);

        if ($request->isMethod("post")) {
            //接收数据
            $data = $request->post();
            //验证
            $this->validate($request, [
                "name" => "required|unique:permissions",
                "intro" => "required",
            ]);

            $data['guard_name'] = "admin";
            Permission::create($data);
            //刷新
            return redirect()->refresh();
        }
        return view("admin.per.add",compact("urls"));
    }
    //权限修改
    public function edit(Request $request,$id){
        $per = Permission::find($id);
        if ($request->isMethod("post")) {
            $data = $request->post();
            $this->validate($request, [
                "name" => "required",
                "intro" => "required",
            ]);
            $per->update($data);
            return redirect()->route("admin.per.index")->with("success","修改成功");
        }
        return view("admin.per.edit",compact("per"));
    }
    //删除
    public function del($id){
        //通过id找到他
        $per = Permission::find($id);
        //删除
        if ($per->delete()) {
            return redirect()->route('admin.per.index')->with("success","删除成功");
        }
    }



}
