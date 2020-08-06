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
