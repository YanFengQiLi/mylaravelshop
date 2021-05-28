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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::namespace('Api')->group(function () {

    /********************** 注册 start **************************/
    Route::post('memberEmailRegister', 'RegisterController@memberEmailRegister');
    Route::post('sendEmailCode', 'RegisterController@sendEmailCode');
    /********************** 注册 end **************************/

    /********************** 登录 start **************************/
    Route::group(['prefix' => 'auth'], function () {
        Route::post('passwordLogin', 'AuthController@passwordLogin');
    });

    /********************** 登录 end **************************/


    /********************** 首页 start **************************/
    //  首页banner轮播
    Route::get('index/getIndexBannerList', 'IndexController@getIndexBannerList');
    //  获取首页商品分类
    Route::get('index/getIndexGoodsCategoryList', 'IndexController@getIndexGoodsCategoryList');
    //  获取首页推荐商品分类菜单
    Route::get('index/getIndexShowGoodsCategoryNav', 'IndexController@getIndexShowGoodsCategoryNav');
    //  获取首页热卖商品
    Route::get('index/getIndexShopHotSales', 'IndexController@getIndexShopHotSales');
    //  签到
    Route::group([
        'prefix' => 'index',
        'middleware' => 'jwt'
    ], function () {
        //  获取用户当月签到列表
        Route::get('getMemberSignList', 'SignController@getMemberSignList');
        //  用户签到
        Route::post('createMemberSign', 'SignController@createMemberSign');
    });
    /********************** 首页 end **************************/

    /********************** 个人中心 start **************************/
    Route::group([
        'prefix' => 'center',
        'middleware' => 'jwt'
    ], function () {
        Route::get('getMemberInfo', 'MemberCenterController@getMemberInfo');
    });
    /********************** 个人中心 end **************************/

    /********************** 分类 start **************************/
    Route::get('cate/getTabBarGoodsCategoryList', 'CategoryController@getTabBarGoodsCategoryList');
    /********************** 分类 end **************************/

    /********************** 商品 start **************************/
    Route::group(['prefix' => 'product'], function () {
        //  商品详情
        Route::get('getProductDetail', 'ProductController@getProductDetail');
        //  添加商品到购物车
        Route::post('addCartProduct', 'ProductController@addCartProduct')->middleware('jwt');
        //  修改购物车商品数量
        Route::put('updateCartProductNumber', 'ProductController@updateCartProductNumber')->middleware('jwt');
    });


    /********************** 商品 end **************************/
});
