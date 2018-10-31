<?php

namespace App\Http\Controllers\Api;

use App\Moldels\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Mrgoon\AliSms\AliSms;

class MemberConroller extends Controller
{
    //注册
    public function reg(Request $request){

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

        Redis::setex("tel_" . $tel, 5, $code);
        //发送给手机
          $config = [
              'access_key' =>env("ALIYUNU_ACCESS_ID"),
              'access_secret' =>env("ALIYUNU_ACCESS_KEY"),
              'sig_name' => '个人分享ya',
          ];

        $sms = new AliSms();
          $response = $sms->sendSms($tel, 'SMS_149422556', ['code'=> $code], $config);
//          $sms = New AliSms($tel, 'SMS_149422556', ['code' => $code], $config);
//          dd($response);
          //返回
          $data = [
              "status" => true,
              "message" => "获取短信验证成功".$code
          ];

          return $data;
    }


}
