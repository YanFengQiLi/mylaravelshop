<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SignService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SignController extends Controller
{
    /**
     * 获取用户某年某月的签到列表
     * @param Request $request
     * @param SignService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMemberSignList(Request $request, SignService $service)
    {
        $date = $request->get('sign_date', date('Y-m'));

        $collects = $service->get($date);

        $dateArr = $this->generateDateArray($date);

        $dateColumn = array_column($dateArr, 'sign_date');

        $list = [];

        if ($collects->count() > 0) {
            foreach ($dateColumn as $key => $date) {
                foreach ($collects as $collect){
                    if ($collect->sign_date == $date) {
                        $list[$key] = [
                            'sign_date' => $collect->sign_date,
                            'is_sign' => $collect->is_sign
                        ];
                    } else {
                        $list[$key] = [
                            'sign_date' => $date,
                            'is_sign' => 0
                        ];
                    }
                }
            }
        } else {
            foreach ($dateColumn as $key => $value)
            {
                $list[$key] = [
                    'sign_date' => $value,
                    'is_sign' => 0
                ];
            }
        }

        return api_response(200, $list, '获取成功');
    }


    /**
     * 用户签到
     * @param SignService $service
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function createMemberSign(SignService $service)
    {
        $bool = $service->checkTodaySign();

        if ($bool === false) {
            return api_response(200, [], '今天已经签过到了,明天在来吧');
        }

        $result = $service->sign();

        if ($result === true) {
            return api_response(200, [], '签到成功');
        } else {
            return api_response(201, [], '签到失败');
        }
    }

    /**
     * 根据年月生成日期数组
     * @param $date -年月 yyyy-mm
     * @return mixed
     */
    protected function generateDateArray($date)
    {
        $yesterday = date("Y-m-d", strtotime("-1 day", strtotime($date . '-01')));

        $days = date('t', strtotime($date));

        $key = 'year_month_'. $date;

        $str = Cache::get($key);

        if (is_null($str)) {
            list($data, $i) = array(array(), 1);

            do{
                $date = [
                    'sign_date' => date('Y-m-d', strtotime("+$i day", strtotime($yesterday))),
                ];

                array_push($data, $date);

                $i++;
            }while($i <= $days);

            $str = json_encode($data);

            Cache::store('redis')->put($key, $str);
        }

        return json_decode($str, true);
    }
}
