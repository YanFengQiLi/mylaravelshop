<?php

namespace App\Http\Controllers\Api;

use App\Admin\Repositories\Category as CategoryRepository;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * @author zhenhong~
     * 获取底部 tabBar 分类导航
     * @param CategoryRepository $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTabBarGoodsCategoryList(CategoryRepository $category)
    {
        $list = $category->toTree();

        return api_response(200, $list, '获取成功');
    }
}
