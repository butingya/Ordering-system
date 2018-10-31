<?php

namespace App\Http\Controllers\Api;

use App\Models\Info;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    //商家列表接口
    public function index(){
        $keyword = \request("keyword");
        if ($keyword!=null) {
            $shops = Info::where("status",1)->where("shop_name","like","%{$keyword}%")->get();
        }else{
            //得到所有店铺，状态为1的
            $shops = Info::where("status",1)->get();
        }
//          dump($shops->toArray());
        //追加距离 预计到餐时间
          foreach ($shops as $k => $v){
              //拼接图片地址
                $shops[$k]->shop_img = env("ALIYUN_OSS_URL").$v->shop_img;
              //追加时间和距离
                $shops[$k]->distance = rand(1000,5000);
                $shops[$k]->estimate_time = ceil($shops[$k]['distance']/rand(100,150));
          }
//          dump($shops->taArray());
        return $shops;
    }
    
    //指定商家接口
    public function detail(){
        $id = request()->get('id');
        $shop = Info::find($id);

        //拼接图片路径
          $shop->shop_img = env("ALIYUN_OSS_URL").$shop->shop_img;
          $shop->service_code = 4.6;

        //添加评论
          $shop->evaluate = [
              [
                 "user_id" => 12344,
                 "username" => "w******k",
                 "user_img" => "http=>//www.homework.com/images/slider-pic4.jpeg",
                 "time" => "2017-2-22",
                 "evaluate_code" => 1,
                 "send_time" => 30,
                 "evaluate_details" => "不怎么好吃"],
              ["user_id" => 12344,
                 "username" => "w******k",
                 "user_img" => "http=>//www.homework.com/images/slider-pic4.jpeg",
                 "time" => "2017-2-22",
                 "evaluate_code" => 4.5,
                 "send_time" => 30,
                 "evaluate_details" => "很好吃"]
          ];
        //找出店铺下的分类
          $categorys = MenuCategory::where("shop_id",$id)->get();
        //循环取出分类下的菜品
           foreach ($categorys as $k=>$category){
               $goods = $categorys[$k]->goods_list=$category->menus;

               foreach ($goods as $v=>$good){
                   $goods[$v]->goods_img = env("ALIYUN_OSS_URL").$good->goods_img;
               }
           }
        $shop->commodity=$categorys->toArray();
           return $shop;
    }

}
