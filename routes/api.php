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

Route::namespace('Api')->group(function (){

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
    //  签到
    Route::group([
        'prefix' => 'index',
        'middleware' => 'jwt'
    ], function (){
        //  获取用户当月签到列表
        Route::get('getMemberSignList', 'SignController@getMemberSignList');
        //  用户签到
        Route::post('sign', 'SignController@sign');
    });
    /********************** 首页 end **************************/

    /********************** 个人中心 start **************************/
    Route::group([
        'prefix' => 'center',
        'middleware' => 'jwt'
    ],function () {
        Route::get('getMemberInfo', 'MemberCenterController@getMemberInfo');
    });
    /********************** 个人中心 end **************************/
});
