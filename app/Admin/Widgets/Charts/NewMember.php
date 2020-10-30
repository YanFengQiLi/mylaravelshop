<?php


namespace App\Admin\Widgets\Charts;


use App\Models\Member;
use Dcat\Admin\Widgets\ApexCharts\Chart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewMember extends Chart
{
    public function __construct($containerSelector = null, $options = [])
    {
        parent::__construct($containerSelector, $options);

        $this->setUpOptions();
    }


    /**
     * 初始化图表
     * @return array
     */
    public function setUpOptions()
    {
        $this->options([
            'series' => [
                [
                    'type' => 'column',
                    'name' => ''
                ]
            ],
            'chart' => [
                'type' => 'line',
                'toolbar' => [
                    'show' => false,
                ],
                'height' => 595
            ],
            'stroke' => [
                'with' => [0, 4]
            ],
            'dataLabels' => [
                'enabled' => false
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

        $number = (int)$request->get('members', 7);

        switch ($number) {
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

        $between = [date('Y-m-d', $beforeDate), $today];

        if (in_array($number, [7, 30, 90])) {
            $group = "DATE_FORMAT(created_at, '%Y-%m-%d')";

            $select = DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') AS date_time");

            $dateArray = generate_date_array($number, 'day', 'date_time');
        } else {
            $group = "DATE_FORMAT(created_at, '%Y-%m')";

            $select = DB::raw("DATE_FORMAT(created_at, '%Y-%m') AS date_time");

            $dateArray = generate_date_array($number, 'month', 'date_time');
        }

        $members = Member::whereBetween('created_at', $between)
            ->select($select, DB::raw('COUNT(*) AS total_number'))
            ->groupByRaw($group)
            ->get();

        $data = [];

        foreach ($members as $member)
        {
            foreach ($dateArray as $key => $value)
            {
                if ($member['date_time'] == $value['date_time'])
                {
                    $data[$key] = [
                        'date_time' => $member['date_time'],
                        'total_number' => $member['total_number']
                    ];
                } else {
                    $data[$key] = [
                        'date_time' => $value['date_time'],
                        'total_number' => 0
                    ];
                }
            }
        }

        $dataMember = config('app.is_mock') ? mock_random_number_array($number) : array_column($data, 'total_number');

        $this->withData($dataMember);

        $this->withLabels(array_column($data, 'date_time'));
    }

    /**
     * 设置图表数据
     * @param $data
     * @return NewMember
     */
    public function withData($data)
    {
        return $this->option('series.0.data', $data);
    }

    /**
     * 设置图表labels
     * @param $data
     * @return NewMember
     */
    public function withLabels($data)
    {
        return $this->option('labels', $data);
    }
}
