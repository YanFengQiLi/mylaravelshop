<?php


namespace App\Admin\Widgets\Charts;


use App\Models\IntegralGoodsOrder;
use App\Models\Order;
use Dcat\Admin\Widgets\ApexCharts\Chart;
use Illuminate\Http\Request;
use App\Services\BaseOrderService;

class GoodsSaleCount extends Chart
{
    //  图表标题,设置为空即可,由BOX组件设置即可
    public $title = '';

    public function __construct($containerSelector = null, $options = [])
    {
        parent::__construct($containerSelector, $options);

        $this->setUpOptions();
    }

    /**
     *  初始化图表
     *  https://apexcharts.com/javascript-chart-demos/bar-charts/custom-datalabels/#
     */
    public function setUpOptions()
    {
        $color = ['red', 'yellow', 'blue'];

        $this->options([
            'color' => $color,
            'chart' => [
                'type' => 'bar',
                'height' =>380,
                'toolbar' => [
                    'show' => false
                ]
            ],
            'plotOptions' => [
                'bar' => [
                    'barHeight' => '100%',
                    'distributed' => true,
                    'horizontal' => true,
                    'dataLabels' => [
                        'position' => 'bottom'
                    ],
                ]
            ],
            'dataLabels' => [
                'enabled' => true,
                'textAnchor' => 'start',
                'style' => [
                    'colors' => ['#FFF']
                ],
                'offsetX' => 0,
                'dropShadow' => [
                    'enable' => true
                ]
            ],
            'stroke' => [
                'width' => 1,
                'colors' => ['#fff']
            ],
            'xaxis' => [
                'categories' => []
            ],
            'yaxis' => [
                'labels' => [
                    'show' => true
                ]
            ],
            'title' => [
                'text' => $this->title,
                'align' => 'center',
                'floating' => true,
            ],
            'subtitle' => [
                'text' => '',
                'align' => 'center'
            ],
            'tooltip' => [
                'theme' => 'dark'
            ]
        ]);
    }

    /**
     * 设置图表数据
     * @param Request $request
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        $today = date('Y-m-d');

        switch ($number = (int) $request->get('option')) {
            case 30:
            case 90:
                $beforeDate = strtotime("-$number day", strtotime($today));
                break;
            case 6:
                $beforeDate = strtotime("-$number month", strtotime($today));
                break;
            case 12:
                $beforeDate = strtotime("-1 year", strtotime($today));
                break;
            default:
                $beforeDate = strtotime("-7 day", strtotime($today));
                break;
        }

        $between = [$beforeDate, $today];

        //  正常商品
        $productsNum = Order::whereBetween('paid_at', $between)
            ->whereNotIn('pay_status', [BaseOrderService::WAIT_PAYING, BaseOrderService::REFUND_SUCCESS])
            ->count() > 0 ?: 279;

        //  TODO 拼团商品
        $groupNum = 100;

        //  积分商品
        $integralNum = IntegralGoodsOrder::whereBetween('paid_at', $between)
            ->whereNotIn('pay_status', [BaseOrderService::WAIT_PAYING, BaseOrderService::REFUND_SUCCESS])
            ->count() > 0 ?: 148;


        $data = config('app.is_mock') ? mock_random_number_array(3,1000, 5000) : [$productsNum, $groupNum, $integralNum];

        $categories = ['正常商品', '拼团商品', '积分商品'];

        $this->withData($data);

        $this->withCategories($categories);

    }


    /**
     * 设置图表数据
     * @param $data
     * @return GoodsSaleCount
     */
    public function withData($data)
    {
        return $this->option('series.0.data', $data);
    }

    /**
     * 设置图表类别显示
     * @param $data
     * @return GoodsSaleCount
     */
    public function withCategories($data)
    {
        return $this->option('xaxis.categories', $data);
    }
}
