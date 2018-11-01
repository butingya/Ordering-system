<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    //购物车列表
    public function index(Request $request){
        //当前用户id
        $userId = $request->post('user_id');
//        dd($userId);
        //购物车列表
        $carts = Cart::where('user_id',$userId)->get();
        //声明一个数组
        $goodsList = [];
        //总价
        $totalCost = 0;
        //循环购物车
        foreach ($carts as $k => $v){
            $goods = Menu::where('id',$v->goods_id)->first(['id as goods_id','goods_name', 'goods_img', 'goods_price']);

            $goods->goods_img = env("ALIYUN_OSS_URL").$goods->goods_img;
//            dd($good->img);
            $goods->amount = $v->goods_list;
            //算总价
            $totalCost += $goods->amount * $goods->goods_price;
            $goodsList[] = $goods;
        }
//        dd($goodsList);
        $data =  [
            'goods_list' => $goodsList,
            'totalCost' => $totalCost
        ];

        return $data;

    }

    //添加购物车
    public function add(Request $request){
        //bug 会出现多个值，不是当前的选中的
        Cart::where("user_id", $request->post('user_id'))->delete();
        //接收参数
        $goods = $request->post('goodsList');
        $counts = $request->post('goodsCount');

        foreach ($goods as $k => $good) {
            $data = [
                'user_id' => $request->post('user_id'),
                'goods_id' => $good,
                'goods_list' => $counts[$k]
            ];
            Cart::create($data);
        }
        return [
            'status' => "true",
            'message' => "添加成功"
        ];
    }
}
