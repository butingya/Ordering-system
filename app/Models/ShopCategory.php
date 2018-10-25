<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCategory extends Model
{
    protected $fillable = [
        'name','img','status'
    ];

    public function info(){
        return $this->hasOne(Info::class,"shop_category_id");
    }
}
