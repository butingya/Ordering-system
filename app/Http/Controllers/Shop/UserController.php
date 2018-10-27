<?php

namespace App\Http\Controllers\Shop;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseController
{
    //商户注册
      public function reg(Request $request){
          //判定post提交方式
          if ($request->isMethod("post")) {
              //接收数据
                $data = $request->post();
              //验证
                $data = $this->validate($request, [
                  "name" => "required|unique:users",
                  "password" => "required",
                  "email" => "required|unique:users"
                ]);
              //密码加密
                $data['password'] = bcrypt($data['password']);
              //入库添加
                User::create($data);
              //跳转
                return redirect()->route("shop.user.login")->with("success","注册成功");
          }else{
              //显示视图
                return view('shop.user.reg');
          }
      }

      //登录
        public function login(Request $request){
          //判断post提交
            if ($request->isMethod("post")) {

                $data = $this->validate($request, [
                    "name" => "required",
                    "password" => "required",
                ]);
              //登录验证
                if (Auth::attempt($data,$request->has("remember"))){
//                    当前用户id
//                      $user = Auth::user();
                      $info = Auth::user()->info;
//                      dd($info);
//                    通过id找店铺
                      if ($info){
                          switch ($info->status){
                              case -1;  //禁用状态
                                 Auth::logout();
                                 return back()->withInput()->with("danger","因你的店铺被禁用,此账号失效");
                                 break;
                              case 0;  //待审核
                                  Auth::logout();
                                  return back()->withInput()->with("danger","因你的店铺还在审核,此账号登录失败,请耐心等待");
                                  break;
                          }
                      }else{
                          //跳转店铺申请
                          return redirect()->intended(route("shop.info.index"))->with("danger","你还没有申请店铺，快来为美食事业助一份力把");
                      }
                    //登录成功
                    return redirect()->intended(route("shop.user.home_page"))->with("success","登录成功");
                }else{
                    //登录失败
                    //session()->flash("danger","账号或密码错误");
                    return redirect()->back()->withInput()->with("danger","账号或密码错误");
                }
            }
            return view("shop.user.login");
        }
      //注销
        public function logout(){
            Auth::guard("web")->logout();
            return redirect()->route("shop.user.login")->with("success","退出成功");
        }

      //修改密码
        public function setPwd(Request $request){
          //当前登录用户
            $user = Auth::guard('web')->user();
          //判断post传值
            if ($request->isMethod("post")) {
                //验证
                $this->validate($request,[
                    "password"=>"required|confirmed",
                    "old_password"=>"required",
                ]);
                $oldPwd = $request->post("old_password");
                //判断旧密码是否正确
                if (Hash::check($oldPwd,$user['password'])) {
                    //设置新密码
                      $user['password'] = Hash::make($request->post("password"));
                      $user->save();
                    return redirect()->route("shop.user.home_page")->with("success","密码修改成功");
                }
                return redirect()->back()->with("danger","你输入的旧密码不对");
            }
            //显示视图
              return view("shop.user.set_pwd",compact("user"));
        }

}
