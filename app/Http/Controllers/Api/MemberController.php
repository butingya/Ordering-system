<?php

namespace App\Http\Controllers\Api;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Mrgoon\AliSms\AliSms;

class MemberController extends Controller
{
    //注册
    public function reg(Request $request){
        //接收全部数据
          $data = $request->all();
        //通过手机吧验证码取出来进行对比
          $code = Redis::get("tel_".$data['tel']);
          if ($code != $data['sms']) {
              $data = [
                  "status" => "false",
                  "message" => "验证码不对"
              ];
        }else{
              //密码加密
              $data['password'] = Hash::make($data['password']);
              //数据存入数据库
              if (Member::create($data)) {
                  $data = [
                      "status" => "true",
                      "message" => "注册成功"
                  ];
              }else{
                  $data = [
                      "status" => "false",
                      "message" => "注册失败"
                  ];
          }
        }
        return $data;
    }


    //接收短信
    public function sms(Request $request){
        //接收参数
        $tel = $request->get('tel');
        //随机生成验证码
        $code = mt_rand(1000,9999);
        //把验证码存起来
//          Redis::set("tel_".$tel,$code);
//          Redis::expire("tel_".$tel,60*5);

        Redis::setex("tel_" . $tel, 5*60, $code);
        //发送给手机
        $config = [
            'access_key' =>env("ALIYUNU_ACCESS_ID"),
            'access_secret' =>env("ALIYUNU_ACCESS_KEY"),
            'sign_name' => '个人分享ya',
        ];

        //返回
        $data = [
            "status" => true,
            "message" => "获取短信验证成功".$code
        ];
        return $data;
    }

    //用户登录
    public function login(Request $request){
        //接收用户名和密码
          $name = $request->name;
          $password = $request->password;
        //判断用户名是否存在
        if ($member=Member::where('username',$name)->first()) {
            if (Hash::check($password,$member->password)) {
                $data=[
                    "status"=>'true',
                    "message"=>'登录成功',
                    "user_id"=>$member->id,
                    "username"=>$name,
                ];
            }
        }else{
            $data=[
                "status"=>'false',
                "message"=>'账号或密码错误'
            ];
        }
        return $data;

    }

    //修改密码
    public function setPwd(Request $request){
        $data = $request->all();

        $old = $request->post('oldPassword');
        $new = $request->post('newPassword');
      //密码加密
        $new = Hash::make($new);
        $member = Member::where('id',$data['id'])->first();
      //密码对比
        if (Hash::check($old,$member->password)) {
            Member::where('id',$data['id'])->update(['password'=>$new]);
            $data = [
                "status"=>'true',
                "message"=>'修改成功'
            ];
        }else{
            $data = [
                "status"=>'false',
                "message"=>'修改密码失败'
            ];
        }
        return $data;
    }
    //找回密码
    public function rest(Request $request)
    {
        //接收全部数据
        $data = $request->post();
        //得到验证码
        $code = Redis::get("tel_".$data['tel']);
        //判断验证码是否有错
        if (($code == $data['sms'])) {
            //通过电话查询一条数据
            $member = Member::where('tel', $data['tel'])->first();
            //密码加密
            $data['password'] = Hash::make($data['password']);
            //数据入库
            if ($member->update($data)) {
                $data = [
                    'status' => 'true',
                    'message' => '密码重置成功'
                ];
            } else {
                $data = [
                    'status' => 'false',
                    'message' => '密码重置失败'
                ];
            }
            return $data;
        }

    }


    //用户信息
    public function detail(Request $request){
        return Member::find($request->input('user_id'));
    }

}
