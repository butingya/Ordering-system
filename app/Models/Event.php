<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title','content','start_time','end_time',
        'prize_time','num','is_prize','id'
    ];

    public function prize(){
        return $this->hasOne(EventPrize::class,"event_id");
    }
}
