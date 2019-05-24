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

//Route::get('/', function () {
//    return view('welcome');
//});

//首页

Route::get('/','IndexController@index');//首页


//个人中心 用户 注册登录
Route::prefix('/user')->group(function(){
    Route::get('register','UserController@register');//注册
    Route::post('registerdo','UserController@registerdo');//注册执行
    Route::post('checkName',"UserController@checkName");//唯一性
    Route::post('code','UserController@code');//注册执行
    Route::post('send','UserController@send');
    Route::get('login','UserController@login');
    Route::post('login','UserController@login');
    Route::post('Email','UserController@Email');
    Route::get('user','UserController@user');//个人中心
    Route::get('out','UserController@out');//退出
});

//商品
Route::prefix('/goods')->group(function(){
   Route::get('goodslist','GoodsController@goodslist');//商品列表
   Route::get('goodsdetail/{goods_id}','GoodsController@goodsdetail');//商品列表
   Route::post('remark','GoodsController@remark');//商品列表
});

//购物车
Route::prefix('/cart')->group(function(){
    Route::post('cartAdd','CartController@cartAdd');//加入购物车
    Route::get('cartlist','CartController@cartlist');//购物车列表
//    Route::post('getSubTotal','CartController@getSubTotal');//获取小计
    Route::post('changeBuyNumber','CartController@changeBuyNumber');//更改购买数量
    Route::post('cartDel','CartController@cartDel');//删除
    Route::post('counTotal','CartController@counTotal');//获取总价
    Route::post('pay','CartController@pay');//订单列表
    Route::get('pay','CartController@pay');//订单列表
});

//订单列表
Route::prefix('/order')->group(function(){
    Route::post('submitPay','OrderController@submitPay');//提交订单
    Route::get('address','OrderController@address');//添加收货地址
    Route::get('shipping','OrderController@shipping');//视图
    Route::post('shippingDo', 'OrderController@shippingDo');//添加执行地址
    Route::post('getArea','OrderController@getArea');//收货地址管理
    Route::get('addressdefault', 'OrderController@addressdefault');//获取市县
    Route::get('success', 'OrderController@success');//获取市县
    Route::get('pcalipay/{order_id?}','OrderController@pcalipay');
    Route::get('returnAlipay','OrderController@returnAlipay');
});
