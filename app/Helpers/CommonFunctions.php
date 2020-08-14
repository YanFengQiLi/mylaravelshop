<?php
if (!function_exists('format_datetime')){
    /**
     * 时间格式化
     * @param  $obj -模型对象
     * @param $date_name - 时间字段名称
     * @return mixed
     */
    function format_datetime($obj, $date_name){
        \Carbon\Carbon::setLocale('zh');

        return  $obj->$date_name->diffForHumans();
    }
}

if (!function_exists('api_response')){
    /**
     * api 返回格式
     * @param $code -状态码
     * @param array $data -数据
     * @param string $message -返回信息
     * @return \Illuminate\Http\JsonResponse
     */
    function api_response($code, $data = [], $message = ''){
        return response()->json([
            'code' => $code,
            'data' => $data ?: [],
            'message' => $message ?: ''
        ]);
    }
}
