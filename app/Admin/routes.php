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
    $router->resource('member/integrals', 'MemberIntegralController')->only(['index']);
    /******************** 会员管理 end ********************* */


    /******************** 广告管理 start ********************* */
    //  广告列表
    $router->resource('advert/advert-list','AdvertController');
    /******************** 广告管理 end ********************* */


    /******************** 优惠券管理 start ********************* */
    //  优惠券管理
    $router->resource('coupons', 'CouponCodeController');
    /******************** 优惠券管理 end ********************* */


    /******************** 商品管理 start ********************* */
    //  商品分类管理
    $router->resource('category','CategoryController');
    //  商品管理
    $router->resource('products', 'ProductController');
    //  商品服务管理
    $router->resource('products-service','ProductsServiceController');
    //  积分商品管理
    $router->resource('integral-goods', 'IntegralGoodController');
    //  团购商品管理
    $router->resource('group-goods','GroupGoodController');
    /******************** 商品管理 end ********************* */


    /******************** 运费模板管理 start ********************* */
    //  运费模板管理
    $router->resource('freight','ProductTemplateController');
    /******************** 运费模板管理 end ********************* */


    /******************** 订单管理 start ********************* */
    //  订单列表
    $router->resource('order/order-list','OrderController');
    //  积分商城订单列表
    $router->resource('order/integral-goods-order', 'IntegralGoodsOrderController');
    //  拼团订单
    $router->resource('order/group-order','GroupOrderController');
    /******************** 订单管理 end ********************* */


    /******************** 消息管理 start ********************* */
    //  消息管理  资源路由只能给对应的方法起名
    $router->resource('admin-message','AdminMessageController')->name('index','admin-message');
    /******************** 消息管理 end ********************* */


    /******************** 网站设置 start ********************* */
    $router->resource('web-sites','WebsiteController');
    /******************** 网站设置 end ********************* */


    /******************** 常见问题 start ********************* */
    $router->resource('problem','ProblemController');
    /******************** 常见问题 end ********************* */

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
        //  获取广告类型
        $router->get('advert-type', 'AdvertTypeController@getAdvertType');
        //  优惠券多选
        $router->get('coupon-select', 'CouponCodeController@getCouponSelect');
        //  商品服务多选
        $router->get('products-service', 'ProductsServiceController@getProductServiceSelectList');
    });
    /******************** select api接口  end ********************* */

    //  后台上传接口
    $router->any('uploadFile','UploadsController@handle');

});
