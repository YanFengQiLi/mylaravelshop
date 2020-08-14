<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Advert;
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
}
