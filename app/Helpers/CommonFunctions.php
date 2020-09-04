<?php

use Illuminate\Support\Facades\Cache;

if (!function_exists('format_datetime')) {
    /**
     * 时间格式化
     * @param  $obj -模型对象
     * @param $date_name - 时间字段名称
     * @return mixed
     */
    function format_datetime($obj, $date_name)
    {
        \Carbon\Carbon::setLocale('zh');

        return $obj->$date_name->diffForHumans();
    }
}

if (!function_exists('api_response')) {
    /**
     * api 返回格式
     * @param $code -状态码
     * @param array $data -数据
     * @param string $message -返回信息
     * @return \Illuminate\Http\JsonResponse
     */
    function api_response($code, $data = [], $message = '')
    {
        return response()->json([
            'code' => $code,
            'data' => $data ?: [],
            'message' => $message ?: ''
        ]);
    }
}

if (!function_exists('generate_rand_number')) {
    /**
     * 生成给定长度的随机数
     * @param int $length
     * @return false|string
     */
    function generate_rand_number($length = 6): string
    {
        $char = str_repeat('0123456789', 4);

        $arr = explode(',', $char);

        shuffle($arr);

        $char = implode(',', $arr);

        $char = str_shuffle($char);

        return substr($char, 0, $length);
    }
}

if (!function_exists('check_phone')) {
    /**
     * 校验手机号 添加了199 / 166 号码区段
     * @param $phone
     * @return bool
     */
    function check_phone($phone)
    {
        return preg_match("/^((13[0-9])|(14[5,6,7,9])|(15[^4])|(16[5,6])|(17[0-9])|(18[0-9])|(19[1,8,9]))\\d{8}$/", $phone) == 1 ? true : false;
    }
}

if (!function_exists('base_today_generate_date_array')) {
    /**
     * 根据条件生成日期数组
     * @param $number
     * @param string $type
     * @param string $field
     * @param string $date
     * @return mixed
     */
    function base_today_generate_date_array($number, $type = 'day', $field = 'date', $date = '')
    {
        $key = $type . '_' . $number;

        $arr = Cache::get($key, []);

        $format = $type == 'days' ? 'Y-m-d' : 'Y-m';

        $str = $type == 'days' ? "+1 days" : "+1 month";

        if (empty($arr)) {
            $i = $number;

            $time = $date ? strtotime($date) : strtotime($str);

            do{
                $date = [
                    $field => date($format, strtotime("-$i $type", $time))
                ];

                array_push($arr, $date);

                $i--;
            }while($i > 0);

            Cache::store('redis')->put($key, json_encode($arr));
        }

        return json_decode($arr, true);
    }
}
