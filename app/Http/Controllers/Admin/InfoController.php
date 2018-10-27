<?php

namespace App\Http\Controllers\Admin;

use App\Models\Info;
use App\Models\ShopCategory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InfoController extends BaseController
{
    //显示店铺申请列表
      public function list(){
          //显示所有数据和视图
            $info = Info::all();
          //显示商家全部信息
            return view('admin.info.list',compact("info"));
      }

    //店铺审核
      public function check($id){
          $info = Info::find($id);
          $info->status= 1;
          $info->save();
          return back()->with("success","审核通过");
      }

    //店铺禁用
      public function ban($id){
          $info = Info::find($id);
          $info->status= -1;
          $info->save();
          return back()->with("success","禁用成功");
      }

   //删除店铺列表
//     public function del($id){
//        //通过id找到他
//        $info = Info::find($id);
//        $pic = $info['shop_img'];
//        //删除
//        if ($info->delete()) {
//            @unlink($pic);
//            return redirect()->route('admin.info.list')->with("success","删除成功");
//        }
//     }

    public function del($id){
        DB::transaction(function () use ($id) {
            //删除店铺
            $info = Info::where("user_id", $id)->delete();
            //删除用户
            $user = User::find($id)->delete();
        });
        return redirect()->route("admin.info.list")->with("success","删除成功");
    }
}
