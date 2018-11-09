<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id','goods_id','amount'
    ];

    //购物车订单和用户的关系
    public function member(){
        return $this->belongsTo(Member::class,"user_id");
    }
    //购物车订单和商品的关系
    public function menu(){
        return $this->belongsTo(Member::class,"user_id");
    }
}
