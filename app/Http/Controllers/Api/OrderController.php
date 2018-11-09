<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Info;
use App\Models\Member;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mrgoon\AliSms\AliSms;

class OrderController extends Controller
{
    //添加订单
    public function add(Request $request){
        //查出收货地址
        $address = Address::find($request->post('address_id'));
        //判断地址是否有误
        if ($address === null) {
            return [
                "status" => "false",
                "message" => "地址不正确"
            ];
        }
        //当前用户id
        $data['user_id'] = $request->post('user_id');
        //通过购物车信息找到shop_id
        $carts = Cart::where("user_id",$request->post('user_id'))->get();
        $shopId = Menu::find($carts[0]->goods_id)->shop_id;
        $data['shop_id'] = $shopId;
        //生成订单号
        $data['order_code'] = date("ymdHis").rand(1000,9999);
        //地址
        $data['provence'] = $address->provence;
        $data['city'] = $address->city;
        $data['area'] = $address->area;
        $data['tel'] = $address->tel;
        $data['name'] = $address->name;
        $data['detail_address'] = $address->detail_address;
        //总价
        $total = 0;
        foreach ($carts as $k => $v){
            $good = Menu::where('id',$v->goods_id)->first();
            //算总价
            $total += $v->amount * $good->goods_price;
        }
//        dd($total);
        $data['total'] = $total;
        //状态,等待支付
        $data['status'] = 0;
        //启动事务
        DB::beginTransaction();
        try {

            //订单入库
            $order = Order::create($data);
//            dd($order->toArray());
            //订单商品
            foreach ($carts as $kk => $cart){
                //得到当前菜品
                $menu = Menu::find($cart->goods_id);
                //判断库存是否充足
                if ($cart->amount>$menu->stock) {
                    //抛出异常
                    throw  new \Exception($menu->goods_name." 库存不足");
                }
                //减去库存
                $menu->stock = $menu->stock-$cart->amount;
                //保存
                $menu->save();
                OrderDetail::insert([
                    'order_id' => $order->id,
                    'goods_id' => $cart->goods_id,
                    'amount' => $cart->amount,
                    'goods_name' => $menu->goods_name,
                    'goods_img' => $menu->goods_img,
                    'goods_price' => $menu->goods_price

                ]);
            }
            //清空购物车
            Cart::where("user_id",$request->post('user_id'))->delete();
            //提交事务
            DB::commit();
        }catch (\Exception $exception){
            //回滚
            DB::rollBack();
            return [
                "status" => "false",
                "message" => $exception->getMessage(),
            ];
        }

        return [
            "status" => "true",
            "message" => "添加成功",
            "order_id" => $order->id
        ];
    }

    //订单详情
    public function detail(Request $request){
        $order = Order::find($request->input('id'));
//        dd($order);
        $data['id'] = $order->id;
        $data['order_code'] = $order->order_code;
        $data['order_birth_time'] = (string)$order->created_at;
        $data['order_status'] = $order->order_status;
        $data['shop_id'] = (string)$order->shop_id;
        $data['shop_name'] = $order->shop->shop_name;
        $data['shop_img'] = $order->shop->shop_img;
        $data['order_price'] = $order->total;
        $data['order_address'] = $order->provence . $order->city . $order->area . $order->detail_address;
        $data['goods_list'] = $order->goods;
//        dd($data);
        return $data;
    }


    //订单列表
    public function list(Request $request){
        $orders = Order::where("user_id",$request->input('user_id'))->get();
        $datas = [];
        foreach ($orders as $order){
            $data['id'] = $order->id;
            $data['order_code'] = $order->order_code;
            $data['order_birth_time'] = (string)$order->created_at;
            $data['order_status'] = $order->order_status;
            $data['shop_id'] = (string)$order->shop_id;
            $data['shop_name'] = $order->shop->shop_name;
            $data['shop_img'] = $order->shop->shop_img;
            $data['order_price'] = $order->total;
            $data['order_address'] = $order->provence . $order->city . $order->area . $order->detail_address;
            $data['goods_list'] = $order->goods;
            $datas[] = $data;
        }
        return $datas;
    }

    //支付
    public function pay(Request $request){
        //得到订单
        $order = Order::find($request->post('id'));

        //得到商家id
        $shopId = $order->shop_id;
        $user = Info::where("id",$shopId)->first()->toArray();
        //获得商家id 5
        $userId = $user['user_id'];
        //商家邮件
        $emails = User::where('id',$userId)->first()->toArray();
        $email = $emails['email'];
        $name = $emails['name'];

        //得到订单号
        $code = $order['order_code'];
        //得到下单者的id
        $memberId = $order['user_id'];
        $phone = Member::where('id',$memberId)->first()->toArray();
        $tel = $phone['tel'];

        $config = [
            'access_key' =>env("ALIYUNU_ACCESS_ID"),
            'access_secret' =>env("ALIYUNU_ACCESS_KEY"),
            'sign_name' => '个人分享ya',
        ];
        $sms=New AliSms();
//        dd($tel);
        $response = $sms->sendSms($tel, "SMS_150576310", ['name'=> $code], $config);

        //得到用户
        $member = Member::find($order->user_id);
        //判断钱不够
        if ($order->total > $member->money) {
            return [
                'status' => 'false',
                'message' => '余额不够'
            ];
        }
        //否则扣钱
        $member->money = $member->money - $order->total;
        $member->save();
        //更改订单状态
        $order->status = 1;
        $order->save();

        $shopName=$name;
        $to = $email;//收件人
        $subject = $shopName.' 审核通知';//邮件标题
        \Illuminate\Support\Facades\Mail::send(
            'emails.order',//视图
            compact("shopName"),//传递给视图的参数
            function ($message) use($to, $subject) {
                $message->to($to)->subject($subject);
            }
        );

        return [
            'status' => 'true',
            "message" => "支付成功"
        ];
    }
}
