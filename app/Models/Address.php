<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'name','tel','provence','city',
        'area','detail_address','user_id',
        'is_selected'
    ];

    //地址和用户的关系
    public function member(){
        return $this->belongsTo(Member::class,"user_id");
    }
}
