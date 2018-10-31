<?php

namespace App\Http\Controllers\Shop;

use App\Models\Menu;
use App\Models\MenuCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuCategoryController extends BaseController
{
    //菜品分类显示
    public function index()
    {
        $menucategory=MenuCategory::where("shop_id",Auth::user()->info->id)->get();
        //显示全部数数据，显示视图
//        $menucategory = MenuCategory::all();
        return view("shop.menu_cate.index", compact("menucategory"));
    }

    //添加分类
    public function add(Request $request)
    {
        //判断提交方式
        if ($request->isMethod("post")) {
            //接收数据，数据入库，显示视图
            $data = $request->post();
//            dd($data);
            //验证
            $this->validate($request,[
                'name'=>'required',
                'description'=>'required',
                'is_selected'=>'required',
            ]);

            $shop_id = Auth::user()->info->id;
            $data['shop_id'] = $shop_id;

            if ($request->post('is_selected')) {
                MenuCategory::where("is_selected",1)->where('shop_id',$shop_id)->update(['is_selected'=>0]);
            }

            if (MenuCategory::create($data)) {
                return redirect()->route("shop.category.index")->with("success", "分类添加成功");
            }
        } else {
            //显示视图
            return view("shop.menu_cate.add");
        }
    }

    //数据修改
    public function edit(Request $request, $id)
    {
        //通过id找对象
        $menucategory = MenuCategory::find($id);
        //是不是post提交
        if ($request->isMethod("post")) {

            $data = $request->post();

            //验证
            $this->validate($request,[
                'name'=>'required',
                'description'=>'required',
                'is_selected'=>'required',
            ]);

            $shop_id = Auth::user()->info->id;
            $data['shop_id'] = $shop_id;

            if ($request->post('is_selected')) {
                MenuCategory::where("is_selected",1)->where('shop_id',$shop_id)->update(['is_selected'=>0]);
            }
            //数据入库
            if ($menucategory->update($data)) {
                //页面跳转
                return redirect()->route("shop.category.index");
            }
        } else {
            //显示视图
            return view("shop.menu_cate.edit", compact("menucategory"));
        }
    }

    //删除
    public function del($id){
        //通过id找到他
        $menucategory = MenuCategory::find($id);
        //得到当前分类对应的菜
        $shopCount = Menu::where('category_id', $menucategory->id)->count();
        //判断
        if ($shopCount) {
            return back()->with("danger", "当前分类下有菜品，不能删除");
        }
        $menucategory->delete();
        return redirect()->route("shop.category.index")->with('success',"删除成功");
    }
    //查看
    public function look($id){
        $lists = DB::table("menus")->where("category_id",$id)->get();
        return view("shop.menu_cate.look",compact('lists'));
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
