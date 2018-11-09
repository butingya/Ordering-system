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


Route::get("info/index","InfoController@index")->name("emails.index");


Route::domain("order.admin.com")->namespace("Admin")->group(function (){
    //region 后台首页
    Route::get("admin/home_page","AdminController@homePage")->name("admin.admin.home_page");
    //region 商铺申请列表，删除，修改,图片上传
    Route::any("info/list","InfoController@list")->name("admin.info.list");
    Route::get("info/del{id}","InfoController@del")->name("admin.info.del");
    Route::any("info/edit{id}","InfoController@edit")->name("admin.info.edit");
    Route::any("info/upload","InfoController@upload")->name("admin.info.upload");
    //endregion

    //region 店铺审核,禁用
    Route::get("info/check{id}","InfoController@check")->name("admin.info.check");
    Route::get("info/ban{id}","InfoController@ban")->name("admin.info.ban");
    //endregion

    //region 给商家添加店铺
    Route::any("info/shop_add/{id}","InfoController@shopAdd")->name("admin.info.shop_add");
    //endregion

    //region 商铺分类,显示，增删改查,图片自动上传
    Route::get("category/index","ShopCategoryController@category")->name("admin.category.index");
    Route::any("category/add","ShopCategoryController@add")->name("admin.category.add");
    Route::any("category/edit{id}","ShopCategoryController@edit")->name("admin.category.edit");
    Route::get("category/del{id}","ShopCategoryController@del")->name("admin.category.del");
    Route::any("category/upload","ShopCategoryController@upload")->name("admin.category.upload");
    //endregion

    //region 后台管理员
    Route::get("admin/index","AdminController@index")->name("admin.admin.index");
    Route::any("admin/add","AdminController@add")->name("admin.admin.add");
    Route::any("admin/edit{id}","AdminController@edit")->name("admin.admin.edit");
    Route::get("admin/del{id}","AdminController@del")->name("admin.admin.del");
    //endregion

    //region 管理员登录,退出,密码修改
    Route::any("admin/login","AdminController@login")->name("admin.admin.login");
    Route::get("admin/logout","AdminController@logout")->name("admin.admin.logout");
    Route::any("admin/pwd/{id}","AdminController@editPassword")->name("admin.admin.pwd");
    //endregion

    //region 给商家重置密码
    Route::any("user/rest/{id}","AdminController@rest")->name("admin.user.rest");
    //endregion

    //region 商家，给商家添加店铺,图片自动上传
    Route::get("user/index","UserController@index")->name("admin.user.index");
    Route::any("user/add","UserController@add")->name("admin.user.add");
    Route::any("user/edit{id}","UserController@edit")->name("admin.user.edit");
    Route::get("user/del{id}","UserController@del")->name("admin.user.del");
    //endregion

    //region 活动
    Route::get("activity/index","ActivityController@index")->name("admin.activity.index");
    Route::any("activity/add","ActivityController@add")->name("admin.activity.add");
    Route::any("activity/edit/{id}","ActivityController@edit")->name("admin.activity.edit");
    Route::get("activity/del/{id}","ActivityController@del")->name("admin.activity.del");
    //endregion

    //region 会员管理
    Route::get("member/index","MemberController@index")->name("admin.member.index");
    Route::get("member/look/{id}","MemberController@look")->name("admin.member.look");
    //endregion

    //region 整体订单量
    Route::get("order/day","OrderController@day")->name("admin.order.day");
    Route::get("order/month","OrderController@month")->name("admin.order.month");
    Route::get("order/total","OrderController@total")->name("admin.order.total");
    //endregion

    //region 各商家整体销量
    Route::get("order/shop_day","OrderController@shopDay")->name("admin.order.shop_day");
    Route::get("order/shop_month","OrderController@shopMonth")->name("admin.order.shop_month");
    Route::get("order/shop_total","OrderController@shopTotal")->name("admin.order.shop_total");
    //endregion

    //region 权限
    Route::get("per/index","PerController@index")->name("admin.per.index");
    Route::any("per/add","PerController@add")->name("admin.per.add");
    Route::any("per/edit/{id}","PerController@edit")->name("admin.per.edit");
    Route::any("per/del/{id}","PerController@del")->name("admin.per.del");
    //endregion

    //region 角色
    Route::get("role/index","RoleController@index")->name("admin.role.index");
    Route::any("role/add","RoleController@add")->name("admin.role.add");
    Route::any("role/edit/{id}","RoleController@edit")->name("admin.role.edit");
    //endregion

    //region 菜单导航栏
    Route::get("nav/index","NavController@index")->name("admin.nav.index");
    Route::any("nav/add","NavController@add")->name("admin.nav.add");
    Route::any("nav/edit/{id})","NavController@edit")->name("admin.nav.edit");
    Route::any("nav/del/{id})","NavController@del")->name("admin.nav.del");
    //endregion

    //region 抽奖活动
    Route::get("event/index","EventController@index")->name("admin.event.index");
    Route::any("event/add","EventController@add")->name("admin.event.add");
    Route::any("event/edit/{id}","EventController@edit")->name("admin.event.edit");
    Route::any("event/del/{id}","EventController@del")->name("admin.event.del");
    //endregion

    //region 奖品
    Route::get("prize/index","EventPrizeController@index")->name("admin.prize.index");
    Route::any("prize/add","EventPrizeController@add")->name("admin.prize.add");
    Route::any("prize/edit/{id}","EventPrizeController@edit")->name("admin.prize.edit");
    Route::any("prize/del/{id}","EventPrizeController@del")->name("admin.prize.del");
    Route::any("event/open/{id}","EventController@open")->name("admin.event.open");
    Route::get("prize/info/{id}","EventController@info")->name("admin.event.info");
    //endregion
});

//商家
Route::domain("order.shop.com")->namespace("Shop")->group(function (){
    //商户平台首页
    Route::get("index/home_page","IndexController@home_page")->name("shop.user.home_page");

    //商家注册
    Route::any("user/reg","UserController@reg")->name("shop.user.reg");

    //region 商家登录,退出,修改密码
    Route::any("user/login","UserController@login")->name("shop.user.login");
    Route::any("user/logout","UserController@logout")->name("shop.user.logout");
    Route::any("user/pwd","UserController@setPwd")->name("shop.user.pwd");
    //endregion

    //店铺申请
    Route::any("info/index","InfoController@info")->name("shop.info.index");

    //region 菜品,图片自动上传
    Route::get("menu/index","MenuController@index")->name("shop.menu.index");
    Route::any("menu/add","MenuController@add")->name("shop.menu.add");
    Route::any("menu/edit/{id}","MenuController@edit")->name("shop.menu.edit");
    Route::get("menu/del/{id}","MenuController@del")->name("shop.menu.del");
    Route::any("category/upload","MenuController@upload")->name("shop.category.upload");
    //endregion

    //region 菜品分类
    Route::get("category/index","MenuCategoryController@index")->name("shop.category.index");
    Route::any("category/add","MenuCategoryController@add")->name("shop.category.add");
    Route::any("category/edit/{id}","MenuCategoryController@edit")->name("shop.category.edit");
    Route::get("category/del/{id}","MenuCategoryController@del")->name("shop.category.del");
    //endregion

    //查看
    Route::any("category/look/{id}","MenuCategoryController@look")->name("shop.category.look");
    //查看有效活动
    Route::get("activity/index","ActivityController@index")->name("shop.activity.index");
    //订单管理
    Route::get("order/index","OrderController@index")->name("shop.order.index");
    //查看订单详情
    Route::get("order/look/{id}","OrderController@look")->name("shop.order.look");
    //更改订单状态
    Route::get("order/setStatus/{id}/{status}","OrderController@setStatus")->name("shop.order.setStatus");
    //订单日销量
    Route::get("order/day","OrderController@day")->name("shop.order.day");
    //订单月销量
    Route::get("order/month","OrderController@month")->name("shop.order.month");
    //订单月销量
    Route::get("order/total","OrderController@total")->name("shop.order.total");
    //菜品日销量
    Route::get("order/menu_day","OrderController@menuDay")->name("shop.order.menu_day");
    //菜品月销量
    Route::get("order/menu_month","OrderController@menuMonth")->name("shop.order.menu_month");
    //菜品总销量
    Route::get("order/menu_total","OrderController@menuTotal")->name("shop.order.menu_total");

    //region 抽奖活动
    Route::get("event/index","EventController@index")->name("shop.event.index");
    Route::any("event/sign/{id}","EventController@sign")->name("shop.event.sign");
    Route::get("prize/info/{id}","EventController@info")->name("shop.event.info");
    Route::get("event/look/{id}","EventController@look")->name("shop.event.look");

    //endregion
});