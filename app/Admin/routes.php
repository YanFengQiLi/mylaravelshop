<?php
/*
 * @Author: your name
 * @Date: 2020-06-10 08:39:49
 * @LastEditTime: 2020-06-10 11:01:51
 * @LastEditors: Please set LastEditors
 * @Description: In User Settings Edit
 * @FilePath: \mylaravel\app\Admin\routes.php
 */

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    /******************** 会员管理 start ********************* */
    //  会员管理
    $router->resource('member/users', 'MemberController');
    //  会员积分管理
    $router->resource('member/integrals', 'MemberIntegralController');

    //  优惠券管理
    $router->resource('coupons', 'CouponCodeController');

    //  商品分类管理
    $router->resource('category','CategoryController');
    //  商品管理
    $router->resource('products', 'ProductController');

    /******************** select api接口 ********************* */
    $router->group(['prefix' => 'api'], function ($router){
        //  获取商品分类的顶级分类
        $router->get('grand-category', 'CategoryController@getGrandCategory');
        //  商品分类分页接口
        $router->get('category-paginate/{level}', 'CategoryController@getDeepCategory');
    });

    /******************** 订单管理 start ********************* */
    //  订单列表
    $router->resource('order/order-list','OrderController');
});
