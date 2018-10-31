<?php

namespace App\Http\Controllers\Shop;

use App\Models\Menu;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MenuController extends BaseController
{
    //显示所有菜品
      public function index(Request $request){
            $url = $request->query();
          //接收数据
            $categoryId = $request->get("category_id");
            $keyword = $request->get("keyword");
            $maxPrice = $request->get("maxPrice");
            $minPrice = $request->get("minPrice");
          //得到所有并分页
            $query = Menu::where("shop_id",Auth::user()->info->id);
          if ($categoryId!==null) {
              $query->where("category_id",$categoryId);
          }

          if ($keyword!==null) {
              $query->where("goods_name","like","%{$keyword}%");
          }
          if ($maxPrice!=0 && $minPrice!=0){
              $query->where("goods_price",">=","$minPrice");
              $query->where("goods_price","<=","$maxPrice");
          }
          $menus = $query->paginate(3);
          //取得所有数据，显示视图
//            $menus = Menu::all();
            $results = MenuCategory::where("shop_id",Auth::user()->info->id)->get();
            return view("shop.menu.index",compact('menus','results','url'));
      }

    //添加菜品
      public function add(Request $request){
        //判断提交方式
          if ($request->isMethod("post")) {
            //验证
             $data = $this->validate($request, [
                 "goods_name" => "required|unique:menus",
                 "goods_img" => "required|image",
                 "category_id" => "required"
              ]);

            //接收数据，数据入库，显示视图
            $data = $request->post();
            $data['status']=$request->has('status')?'1':'0';
            //判断当前登录的用户id
            $shop_id = Auth::user()->info->id;
            $data['shop_id'] = $shop_id;
            //图片上传
//              dd($data);
//            $data['goods_img']=$request->file("goods_img")->store("images");
            //数据入库
            if (Menu::create($data)) {
                return redirect()->route("shop.menu.index")->with("success","菜品添加成功");
            }
          }else{
            //显示视图
            $results = MenuCategory::all();
            return view("shop.menu.add",compact("results"));
        }
      }

    //数据修改
    public function edit(Request $request,$id){
        //通过id找对象
        $menu = Menu::find($id);
        $pic = $menu['goods_img'];
        //是不是post提交
        if ($request->isMethod("post")) {
          //接收数据
            $data = $request->post();
          //当前登录用户的id
            $shop_id = Auth::user()->info->id;
            $data['shop_id'] = $shop_id;
          //图片入库
            if($request->file("goods_img")!==null){
                $data['goods_img']=$request->file("goods_img")->store("images");
            }else{
                $data['goods_img']=$menu->goods_img;
            }
            //数据入库
            if ($menu->update($data)) {
                \Storage::delete($pic);
                //页面跳转
                return redirect()->route("shop.menu.index");
            }
        }  else{
            //显示视图
            $results = MenuCategory::all();
            return view("shop.menu.edit",compact("menu","results"));
        }
    }
    //删除
    public function del($id){
        //通过id找到他
        $menu = Menu::find($id);
        $pic = $menu['goods_img'];
        //删除
        if ($menu->delete()) {
            \Storage::delete($pic);
            return redirect()->route('shop.menu.index')->with("success","删除成功");
        }
    }


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
