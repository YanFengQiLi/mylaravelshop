<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advert;
use App\Models\Category;
use App\Services\ProductService;


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

    /**
     * @author zhenhong~
     * 获取首页热卖商品
     * @param ProductService $productService
     * @return \Illuminate\Http\JsonResponse
     */
    public function getIndexShopHotSales(ProductService $productService)
    {
        $limit = request('per_page',10);

        $list = $productService->getProductHotList($limit);

        return api_response(200, ['list' => $list->items(), 'total' => $list->total(), 'last_page' => $list->lastPage()],'获取成功');
    }
}
