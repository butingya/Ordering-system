<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id','shop_id','order_code','provence',
        'city','area','address','tel','name',
        'total','status','created_at'
    ];

    //读取器
    public function getOrderStatusAttribute(){
        $arr = [-1 => "已取消", 0 => "代付款", 1 => "待发货", 2 => "待确认", 3 => "完成"];
        return $arr[$this->status];
    }
    //订单和商铺的关系
    public function shop(){
        return $this->belongsTo(Info::class,"shop_id");
    }
    //订单和订单编号的关系
    public function goods(){
        return $this->hasMany(OrderDetail::class, "order_id");
    }

}
