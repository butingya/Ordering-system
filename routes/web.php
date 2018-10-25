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
    return view('welcome');
});



Route::domain("order.admin.com")->namespace("Admin")->group(function (){
    //商铺申请列表
    Route::any("info/list","InfoController@list")->name("admin.info.list");
    Route::get("info/del{id}","InfoController@del")->name("admin.info.del");
    //店铺审核,禁用
    Route::get("info/check{id}","InfoController@check")->name("admin.info.check");
    Route::get("info/ban{id}","InfoController@ban")->name("admin.info.ban");
    //商铺分类,显示，增删改查
    Route::get("category/index","ShopCategoryController@category")->name("admin.category.index");
    Route::any("category/add","ShopCategoryController@add")->name("admin.category.add");
    Route::any("category/edit{id}","ShopCategoryController@edit")->name("admin.category.edit");
    Route::get("category/del{id}","ShopCategoryController@del")->name("admin.category.del");
    //后台管理员
    Route::get("admin/index","AdminController@index")->name("admin.admin.index");
    Route::any("admin/add","AdminController@add")->name("admin.admin.add");
    Route::any("admin/edit{id}","AdminController@edit")->name("admin.admin.edit");
    Route::get("admin/del{id}","AdminController@del")->name("admin.admin.del");
    //管理员登录,退出
    Route::any("admin/login","AdminController@login")->name("admin.admin.login");
    Route::get("admin/logout","AdminController@logout")->name("admin.admin.logout");
    //商家
    Route::get("user/index","UserController@index")->name("admin.user.index");
    Route::any("user/add","UserController@add")->name("admin.user.add");
    Route::any("user/edit{id}","UserController@edit")->name("admin.user.edit");
    Route::get("user/del{id}","UserController@del")->name("admin.user.del");

});

//商家
Route::domain("order.shop.com")->namespace("Shop")->group(function (){
    //商户平台首页
    Route::get("index/home_page","IndexController@home_page")->name("shop.user.home_page");
    //商家注册
    Route::any("user/reg","UserController@reg")->name("shop.user.reg");
    //商家登录,退出
    Route::any("user/login","UserController@login")->name("shop.user.login");
    Route::any("user/logout","UserController@logout")->name("shop.user.logout");
    //店铺申请
    Route::any("info/index","InfoController@info")->name("shop.info.index");
});