<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //整体日销量
    public function day(){
        //$order = Order::where("start",">=",date('Y-m-d H:i:s', time()))->get();
        $data = Order::select(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as date,COUNT(*) as nums,SUM(total) as money"))
              ->groupBy('date')
              ->get();
        return view('admin.order.day', compact('data'));
    }

    //整体月销量
    public function month(Request $request){
        $data = Order::select(DB::raw("DATE_FORMAT(created_at,'%Y-%m') as month,COUNT(*) as nums,SUM(total) as money"))
            ->groupBy('month')
            ->get();
        return view('admin.order.month', compact('data'));
    }

    //整体总销量
    public function total(Request $request){
        $data = Order::select(DB::raw("COUNT(*) as nums,SUM(total) as money"))
              ->get();
        return view('admin.order.total', compact('data'));
    }

    //各商家日销量
    public function shopDay(){
        $data = Order::select(DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as date,COUNT(*) as nums,SUM(total) as money,shop_id"))
            ->groupBy('shop_id','date')
            ->get();
        return view('admin.order.shop_day', compact('data'));
    }

    //各商家月销量
    public function shopMonth(){
        $data = Order::select(DB::raw("DATE_FORMAT(created_at,'%Y-%m') as month,COUNT(*) as nums,SUM(total) as money,shop_id"))
            ->groupBy('shop_id','month')
            ->get();
        return view('admin.order.shop_month', compact('data'));
    }

    //各商家总销量
    public function shopTotal(){
        $data = Order::select(DB::raw("COUNT(*) as nums,SUM(total) as money,shop_id"))
            ->groupBy('shop_id')
            ->get();
        return view('admin.order.shop_total', compact('data'));
    }

    //菜品销量

}
