<?php
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
    /******************** 会员管理 end ********************* */

    /******************** 广告管理 start ********************* */
    //  广告类型管理
    $router->resource('advert/advert-type', 'AdvertTypeController');
    //  广告列表
    $router->resource('advert/advert-list','AdvertController');
    /******************** 广告管理 end ********************* */

    //  优惠券管理
    $router->resource('coupons', 'CouponCodeController');
    //  商品分类管理
    $router->resource('category','CategoryController');
    //  商品管理
    $router->resource('products', 'ProductController');
    //  运费模板管理
    $router->resource('freight','ProductTemplateController');

    /******************** select api接口  start ********************* */
    $router->group(['prefix' => 'api'], function ($router){
        //  获取商品分类的顶级分类
        $router->get('grand-category', 'CategoryController@getGrandCategory');
        //  商品分类联动接口
        $router->get('categories', 'CategoryController@getCategory');
        //  获取省市区的顶级分类
        $router->get('province', 'DistrictController@getProvince');
        //  运费模板
        $router->get('product-template', 'ProductTemplateController@getProductTemplate');
    });
    /******************** select api接口  end ********************* */

    /******************** 订单管理 start ********************* */
    //  订单列表
    $router->resource('order/order-list','OrderController');
});
