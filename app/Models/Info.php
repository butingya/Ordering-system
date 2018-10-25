<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $fillable = [
        'shop_name', 'shop_category_id', 'shop_img','on_time',
        'start_send', 'send_cost', 'notice', 'discount', 'fengniao',
        'bao', 'piao', 'zhun'
    ];

    public function shop_categories(){
        return $this->belongsTo(ShopCategory::class,"shop_category_id");
    }

    public function users(){
        return $this->belongsTo(User::class,"user_id");
    }
}
