<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShopCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopCategoryController extends BaseController
{
    //显示商铺分类
      public function category(){
          //显示全部数据，视图
            $shopcategory = ShopCategory::all();
            return view("admin.category.index",compact("shopcategory"));
      }
    //商铺分类添加
    public function add(Request $request){
          //判断提交方式
            if ($request->isMethod("post")) {
                //接收数据，数据入库，显示视图
                $data = $request->post();
                //验证
                $this->validate($request, [
                    "name" => "required|unique:shop_categories",
                    "img" => "required",
                    "status" => "required"
                ]);
                if (ShopCategory::create($data)) {
                    return redirect()->route("admin.category.index")->with("success","商铺分类添加成功");
                }
            }else{
                //显示视图
                return view("admin.category.add");
            }
    }

    //修改商铺
    public function edit(Request $request,$id){
        //通过id找对象
        $shopcategory = ShopCategory::find($id);
        $pic = $shopcategory['img'];
        //是不是post提交
        if ($request->isMethod("post")) {
            //接收数据
            $data = $request->post();
            //验证
            $this->validate($request, [
                "name" => "required",
                "img" => "required",
                "status" => "required"
            ]);
            //图片判断
//            if($request->file("img")!==null){
//                $data['img']=$request->file("img")->store("images");
//            }else{
//                $data['img']=$shopcategory->img;
//            }
            //数据入库
            if ($shopcategory->update($data)) {
                //页面跳转
                \Storage::delete($pic);
                return redirect()->route("admin.category.index")->with("success","修改成功");
            }
        }  else{
            //显示视图
            return view("admin.category.edit",compact("shopcategory"));
        }
    }
    //删除
    public function del($id){
        //通过id找到他
        $shopcategory = ShopCategory::find($id);
        $pic = $shopcategory['img'];
        //删除
        if ($shopcategory->delete()) {
            \Storage::delete($pic);
            return redirect()->route('admin.category.index')->with("success","删除成功");
        }
    }

    //图片上传
    public function upload(Request $request)
    {
        //处理上传
        //dd($request->file("file"));
        $file=$request->file("file");

        if ($file){
            //上传
            $url=$file->store("menu_cate");
            /// var_dump($url);
            //得到真实地址  加 http的址
//            $url=Storage::url($url);
            $data['url']=$url;
            return $data;
        }
    }

}
