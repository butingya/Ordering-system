<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    protected $fillable = [
        'shop_name', 'shop_category_id', 'shop_img','on_time',
        'start_send', 'send_cost', 'notice', 'discount', 'fengniao',
        'bao', 'piao', 'zhun','user_id','status','shop_rating',
        'brand'
    ];

    //店铺分类和店铺的关系
    public function shop_categories(){
        return $this->belongsTo(ShopCategory::class,"shop_category_id");
    }
    //店铺和商家的关系
    public function user(){
        return $this->belongsTo(User::class,"user_id");
    }
   //店铺和菜品分类的关系
    public function menu_cate(){
        return $this->hasMany(MenuCategory::class,"shop_id");
    }
    //店铺和菜的关系
    public function menus(){
        return $this->hasMany(Menu::class,"shop_id");
    }
}
