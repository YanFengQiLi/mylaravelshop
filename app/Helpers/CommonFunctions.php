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

if (!function_exists('generate_date_array')) {
    /**
     * 根据条件生成日期数组
     * @param $number
     * @param string $type
     * @param string $field
     * @param string $date
     * @return mixed
     */
    function generate_date_array($number, $type = 'day', $field = 'date', $date = '')
    {
        $key = $type . '_' . $number;

        $arr = Cache::get($key, []);

        $format = $type == 'day' ? 'Y-m-d' : 'Y-m';

        $str = $type == 'day' ? "+1 day" : "+1 month";

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

            $arr = json_encode($arr);

            Cache::store('redis')->put($key, $arr);
        }

        return json_decode($arr, true);
    }
}

if (!function_exists('mock_random_number_array')) {
    /**
     * 模拟生成随机数数组
     * @param $len
     * @param int $min
     * @param int $max
     * @return array
     */
   function mock_random_number_array($len, $min = 100, $max = 300){
       $generator = function ($len) use ($min, $max){
           for ($i = 1; $i <= $len; $i++) {
               yield mt_rand($min, $max);
           }
       };

       return collect($generator($len))->toArray();
   }
}

if (!function_exists('check_date_valid')) {
    /**
     * 校验日期合法性
     * @param $data
     * @param string $format
     * @return bool
     */
    function check_date_valid($data, $format = 'Y-m-d'){
        $unixTime = strtotime($data);

        if (!$unixTime) {
            return false;
        }

        if (date($format, $unixTime) == $data) {
            return true;
        }

        return false;
    }
}
