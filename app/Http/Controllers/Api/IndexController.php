<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use App\Models\Category;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * @author zhenhong~
     * 获取首页顶部轮播图
     * @param Advert $advert
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIndexBannerList(Advert $advert)
    {
        $data = $advert->getAdvertList();

        return api_response(200, $data, '获取成功');
    }

    /**
     * @author zhenhong~
     * 获取首页商品分类
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIndexGoodsCategoryList(Category $category)
    {
        $data = $category->getCategoryList(['parent_id' => 0]);

        return api_response(200, $data, '获取成功');
    }

    /**
     * @author zhenhong~
     * 获取首页推荐商品分类菜单
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIndexShowGoodsCategoryNav(Category $category)
    {
        $data = $category->getCategoryList(['is_index_show' => 1]);

        return api_response(200, $data, '获取成功');
    }
}
