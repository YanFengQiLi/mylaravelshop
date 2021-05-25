<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductsService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @param ProductService $productService
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author zhenhong~
     * 获取商品详情
     */
    public function getProductDetail(ProductService $productService, Request $request)
    {
        $id = $request->get('id');

        $info = $productService->findProductById($id);

        $service = new ProductsService;

        $info->service_list = $service->getProductServiceByIds($info->service);

        return api_response(200, $info, '获取成功');
    }
}
