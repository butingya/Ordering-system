<?php

namespace App\Http\Controllers\Admin;

use App\Models\Nav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class NavController extends BaseController
{
    //显示
    public function index(){
        //显示全部数据
//        $dd =Nav::where("pid",0)->get();
//        dd($dd->toArray());
        $navs = Nav::all();
        return view("admin.nav.index",compact('navs'));
    }

    //添加
    public function add(Request $request){
        //判定提交方式
        if ($request->isMethod("post")) {
            //接收全部数据
            $data = $request->post();
            //数据入库
            $nav = Nav::create($data);
            return redirect()->route("admin.nav.index")->with("success","添加成功");
        }
        //得到所有路由
        $routes = Route::getRoutes();
        //一个空数组
        $urls = [];
        //循环取出路由
        foreach ($routes as $route){
            if ($route->action["namespace"] == "App\Http\Controllers\Admin") {
                //取别名存入$url
                $urls[] = $route->action['as'];
            }
        }
        //从数据库取出
        $url = Nav::pluck("url")->toArray();
        //把已经存在的路由去掉
        $urls = array_diff($urls,$url);

        $navs = Nav::where('pid',0)->orderBy('sort')->get();
        //显示视图
        return view("admin.nav.add",compact('navs','urls'));
    }

    //修改
    public function edit(Request $request,$id){
        //得到id
        $nav = Nav::find($id);
        //判断提交方式
        if ($request->isMethod("post")) {
            //接收全部数据
            $data = $request->post();
            //数据入库
            $nav->update($data);
            return redirect()->route("admin.nav.index")->with("success","修改成功");
        }
        //得到所有路由
        $routes = Route::getRoutes();
        //一个空数组
        $urls = [];
        //循环取出路由
        foreach ($routes as $route){
            if ($route->action["namespace"] == "App\Http\Controllers\Admin") {
                //取别名存入$url
                $urls[] = $route->action['as'];
            }
        }
        //从数据库取出
        $url = Nav::pluck("url")->toArray();
        //把已经存在的路由去掉
        $urls = array_diff($urls,$url);

        $nas = Nav::where('pid',0)->orderBy('sort')->get();

        //显示视图
        return view("admin.nav.edit",compact('nav','urls','nas'));
    }

    //删除
    public function del($id){
        //通过id找到他
        $nav = Nav::find($id);
        //删除
        if ($nav->delete()) {
            return redirect()->route('admin.nav.index')->with("success","删除成功");
        }
    }





}
