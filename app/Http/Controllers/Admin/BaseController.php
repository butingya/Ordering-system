<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class BaseController extends Controller
{
    public function __construct()
    {
        //添加中间件
        $this->middleware("auth:admin",[
            "except"=>["login","reg"]
        ]);
        //判断有没有权限
        $this->middleware(function ($request,\Closure $next){
            //得到当前访问的路由
            $route = Route::currentRouteName();
            //设置一个白名单
            $allow = [
                "admin.admin.login",
                "admin.admin.logout",
                "admin.admin.pwd",
                "admin.admin.home_page"
            ];
            //保证在白名单并且有权限 id===1
            if (!in_array($route,$allow) && !Auth::guard("admin")->user()->can($route) && Auth::guard("admin")->id()!=1) {
                exit(view("admin.back"));
            }
            return $next($request);
        });
    }
}
