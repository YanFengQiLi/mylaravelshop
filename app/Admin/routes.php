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
    $router->resource('member/users', 'MemberController');

    //  商品分类管理
    $router->resource('category','CategoryController');

});
