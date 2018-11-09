<?php

namespace App\Http\Controllers\Shop;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends BaseController
{
    //显示订单
    public function index(Request $request){
        $status = $request->get('status');
        $orders = Order::where("shop_id",Auth::user()->info->id);
        if ($status !== null) {
            $orders->where("status",$status);
        }
        $orders = $orders->get();
        return view("shop.order.index",compact('orders'));
    }

    //查看订单
    public function look($id){
        $orders = Order::find($id);
        DB::table('orders')->where('id',$id);
        return view("shop.order.look",compact('orders'));
    }

    //订单状态
    public function setStatus($id,$status){
        $result= Order::where("id",$id)->where("shop_id",Auth::user()->info->id)->update(['status'=>$status]);
        if ($result){
            return redirect()->route('shop.order.index')->with("success","更改状态成功");
        }
    }

    //订单日销量
    public function day(Request $request){
        $start = $request->get('start');
        $end = $request->get('end');
        $order = order::where('created_at',">=",date('Y-m-d H:i:s', time()))->get();
//dd($start);
        $shopId = Auth::user()->info->id;
        $data = Order::where("shop_id",$shopId)
              ->select(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as date,COUNT(*) as nums,SUM(total) as money"))
              ->groupBy('date');
//              ->get();

        if ($start !== null) {
            $data->where("created_at", ">=", $start);
        }
        if ($end !== null) {
            $data->where("created_at", "<=", $end);
        }
        $data = $data->get();
        return view('shop.order.day', compact('data'));
    }

    //订单月销量
    public function month(Request $request){
        $shopId = Auth::user()->info->id;
        $data = Order::where("shop_id",$shopId)
            ->select(DB::raw("DATE_FORMAT(created_at,'%Y-%m') as month,COUNT(*) as nums,SUM(total) as money"))
            ->groupBy('month')
            ->get();
        return view('shop.order.month', compact('data'));
    }

    //订单总计
    public function total(){
        $shopId = Auth::user()->info->id;
        $data = Order::where("shop_id",$shopId)
            ->select(DB::raw("COUNT(*) as nums,SUM(total) as money"))
            ->get();
        return view('shop.order.total', compact('data'));
    }

    //菜品日销量
    public function menuDay(Request $request){
        //找到当前店铺所有的订单ID
//        $ids = Order::where("shop_id",Auth::user()->info->id)->pluck("id");
//        $data= OrderDetail::select(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as date,SUM(amount) as nums,SUM(amount * goods_price) as money"))
//             ->whereIn("order_id",$ids)
//             ->groupBy('date')
//             ->get();
//        return view('shop.order.menu_day', compact('data'));


        //月份
        $ids=  Order::where("shop_id",Auth::user()->info->id)->pluck("id");
        $month= OrderDetail::select(DB::raw("DATE_FORMAT(created_at,'%Y-%m') as date,SUM(amount) as nums,SUM(amount * goods_price) as money"))
            ->whereIn("order_id",$ids)
            ->groupBy('date')
            ->get();
        $data = OrderDetail::OrderBy("id")->paginate(7);

        //判断传过来的值
//        dd($month);
        return view("shop.order.menu_day",compact("data","month"));
    }

    //菜品月销量
    public function menuMonth(){
        //找到当前店铺所有的订单ID
        $ids = Order::where("shop_id",Auth::user()->info->id)->pluck("id");
        $data= OrderDetail::select(DB::raw("DATE_FORMAT(created_at,'%Y-%m') as month,SUM(amount) as nums,SUM(amount * goods_price) as money"))
            ->whereIn("order_id",$ids)
            ->groupBy('month')
            ->get();
        return view('shop.order.menu_month', compact('data'));
    }

    //菜品总销量
    public function menuTotal(){
        //找到当前店铺所有的订单ID
        $ids = Order::where("shop_id",Auth::user()->info->id)->pluck("id");
        $data= OrderDetail::select(DB::raw("SUM(amount) as nums,SUM(amount * goods_price) as money"))
            ->whereIn("order_id",$ids)
            ->get();
        return view('shop.order.menu_total', compact('data'));
    }
}
