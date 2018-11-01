<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//显示商家接口
Route::get("shop/index","Api\ShopController@index");
//指定商家接口
Route::get("shop/detail","Api\ShopController@detail");
//短信验证
Route::get("member/sms","Api\MemberController@sms");
//用户注册
Route::any("member/reg","Api\MemberController@reg");
//用户登录
Route::any("member/login","Api\MemberController@login");
//修改密码
Route::any("member/setPwd","Api\MemberController@setPwd");
//修改密码
Route::any("member/rest","Api\MemberController@rest");
//用户详情
Route::any("member/detail","Api\MemberController@detail");
//地址列表
Route::any("address/list","Api\AddressController@list");
//添加地址
Route::any("address/add","Api\AddressController@add");
//指定地址
Route::any("address/index","Api\AddressController@index");
//修改地址
Route::any("address/edit","Api\AddressController@edit");
//购物列表
Route::any("cart/index","Api\CartController@index");
//添加购物车
Route::any("cart/add","Api\CartController@add");