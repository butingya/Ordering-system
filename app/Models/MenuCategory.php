<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuCategory extends Model
{
    protected $fillable = ['name','type_accumulation','shop_id',
                            'description','is_selected'];
    //菜品分类和店铺的关系
    public function info(){
        return $this->belongsTo(Info::class,"shop_id");
    }
    //分类和菜品的关系
    public function menus(){
        return $this->hasMany(Menu::class,"category_id");
    }
}
