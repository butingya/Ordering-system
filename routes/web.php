<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});



Route::domain("order.admin.com")->namespace("Admin")->group(function (){

    //商铺申请列表，删除，修改
    Route::any("info/list","InfoController@list")->name("admin.info.list");
    Route::get("info/del{id}","InfoController@del")->name("admin.info.del");
    Route::any("info/edit{id}","InfoController@edit")->name("admin.info.edit");
    //图片上传
    Route::any("info/upload","InfoController@upload")->name("admin.info.upload");
    //店铺审核,禁用
    Route::get("info/check{id}","InfoController@check")->name("admin.info.check");
    Route::get("info/ban{id}","InfoController@ban")->name("admin.info.ban");
    //给商家添加店铺
    Route::any("info/shop_add/{id}","InfoController@shopAdd")->name("admin.info.shop_add");
    //商铺分类,显示，增删改查
    Route::get("category/index","ShopCategoryController@category")->name("admin.category.index");
    Route::any("category/add","ShopCategoryController@add")->name("admin.category.add");
    Route::any("category/edit{id}","ShopCategoryController@edit")->name("admin.category.edit");
    Route::get("category/del{id}","ShopCategoryController@del")->name("admin.category.del");
    //图片自动上传
    Route::any("category/upload","ShopCategoryController@upload")->name("admin.category.upload");
    //后台管理员
    Route::get("admin/index","AdminController@index")->name("admin.admin.index");
    Route::any("admin/add","AdminController@add")->name("admin.admin.add");
    Route::any("admin/edit{id}","AdminController@edit")->name("admin.admin.edit");
    Route::get("admin/del{id}","AdminController@del")->name("admin.admin.del");
    //管理员登录,退出,密码修改
    Route::any("admin/login","AdminController@login")->name("admin.admin.login");
    Route::get("admin/logout","AdminController@logout")->name("admin.admin.logout");
    Route::any("admin/pwd/{id}","AdminController@editPassword")->name("admin.admin.pwd");
    //给商家重置密码
    Route::any("user/rest/{id}","AdminController@rest")->name("admin.user.rest");

    //商家，给商家添加店铺,图片自动上传
    Route::get("user/index","UserController@index")->name("admin.user.index");
    Route::any("user/add","UserController@add")->name("admin.user.add");
    Route::any("user/edit{id}","UserController@edit")->name("admin.user.edit");
    Route::get("user/del{id}","UserController@del")->name("admin.user.del");
    //活动
    Route::get("activity/index","ActivityController@index")->name("admin.activity.index");
    Route::any("activity/add","ActivityController@add")->name("admin.activity.add");
    Route::any("activity/edit/{id}","ActivityController@edit")->name("admin.activity.edit");
    Route::get("activity/del/{id}","ActivityController@del")->name("admin.activity.del");
});

//商家
Route::domain("order.shop.com")->namespace("Shop")->group(function (){
    //商户平台首页
    Route::get("index/home_page","IndexController@home_page")->name("shop.user.home_page");
    //商家注册
    Route::any("user/reg","UserController@reg")->name("shop.user.reg");
    //商家登录,退出,修改密码
    Route::any("user/login","UserController@login")->name("shop.user.login");
    Route::any("user/logout","UserController@logout")->name("shop.user.logout");
    Route::any("user/pwd","UserController@setPwd")->name("shop.user.pwd");
    //店铺申请
    Route::any("info/index","InfoController@info")->name("shop.info.index");
    //菜品
    Route::get("menu/index","MenuController@index")->name("shop.menu.index");
    Route::any("menu/add","MenuController@add")->name("shop.menu.add");
    Route::any("menu/edit/{id}","MenuController@edit")->name("shop.menu.edit");
    Route::get("menu/del/{id}","MenuController@del")->name("shop.menu.del");
    //图片自动上传
    Route::any("category/upload","MenuController@upload")->name("shop.category.upload");
    //菜品分类
    Route::get("category/index","MenuCategoryController@index")->name("shop.category.index");
    Route::any("category/add","MenuCategoryController@add")->name("shop.category.add");
    Route::any("category/edit/{id}","MenuCategoryController@edit")->name("shop.category.edit");
    Route::get("category/del/{id}","MenuCategoryController@del")->name("shop.category.del");
    //查看
    Route::any("category/look/{id}","MenuCategoryController@look")->name("shop.category.look");
    //查看有效活动
    Route::get("activity/index","ActivityController@index")->name("shop.activity.index");
});