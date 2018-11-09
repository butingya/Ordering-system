<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'user_id','goods_id','amount','goods_name',
        'goods_img','goods_price'
    ];

    public function shop(){
        return $this->belongsTo(Info::class,"shop_id");
    }


}
