<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    //
    protected $fillable =["username","password","tel"];

    //用户和地址的关系
    public function address(){
        return $this->hasMany(Address::class,"user_id");
    }
    //用户和购物车订单的关系
    public function cart(){
        return $this->hasMany(Cart::class,"user_id");
    }
}
