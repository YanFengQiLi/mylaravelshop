<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author zhenhong~
     * 上传文件
     */
    public function uploadFile(Request $request)
    {
        $file = $request->file('file');

        $disk = \Storage::disk('qiniu');

        $dir = 'my-shop/up';

        $newName = md5(uniqid()).'.'.$file->getClientOriginalExtension();

        $result = $disk->putFileAs($dir, $file, $newName);

        if ($result) {
            $baseUrl = config('filesystems.disks.qiniu.url');

            $path = $baseUrl. $dir . '/' .$newName;

            return api_response(200, $path, '上传成功');
        } else {
            return api_response(201, [], '上传失败');
        }
    }
}
