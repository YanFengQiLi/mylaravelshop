<?php

namespace App\Admin\Controllers;

use App\Admin\Widgets\Charts\GoodsSaleCount;
use App\Admin\Widgets\Charts\NewMember;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Dropdown;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->header('数据面板')
            ->description('主页')
            ->body(function (Row $row) {
                $row->column(6, function (Column $column) {
                    $column->row($this->getMemberGrowth());

                    $column->row(
                        $this->generateChartAndDropdownWidget(GoodsSaleCount::class, 'goods-sale', '商品总销量一览图', 'goods')
                    );
                });

                $row->column(6, function (Column $column) {
                    $column->row(function (Row $row) {
                        $row->column(
                            12, $this->generateChartAndDropdownWidget(NewMember::class, 'new-member', '新增用户变化趋势图', 'members')
                        );
                    });
                });

                $row->column(6, function (Column $column) {
                });
            });
    }

    /**
     * 新用户增长看板
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getMemberGrowth()
    {
        $member = new Member();

        $count = [
            'day' => $member->countNewMember('day'),
            'month' => $member->countNewMember('month'),
            'year' => $member->countNewMember('year'),
        ];

        if (config('app.is_mock')) {
            list($day, $month, $year) = mock_random_number_array(3, 100, 500);

            $count = [
                'day' => $day,
                'month' => $month,
                'year' => $year
            ];
        }

        return view('dashboard.member-growth', compact('count'));
    }

    /**
     * 构建图表和下拉菜单组件
     * @param $chart
     * @param $boxId
     * @param $title
     * @param $option
     * @return Box
     */
    public function generateChartAndDropdownWidget($chart, $boxId, $title, $option)
    {
        $options = [
            '7' => '最近7天',
            '30' => '最近30天',
            '90' => '最近90天',
            '6' => '最近半年',
            '12' => '最近1年'
        ];

        $clickClass = $boxId;

        $clickClassName = '.' . $boxId;

        $dropdown = Dropdown::make($options)
            ->button(current($options))
            ->click()
            ->map(function ($item, $index) use ($option, $clickClass) {
                return "<a class={$clickClass} data-{$option}='{$index}'>{$item}</a>";
            });

        $bar = $chart::make()
            ->fetching('$("#my-box").loading()') // 设置loading效果
            ->fetched('$("#my-box").loading(false)') // 移除loading效果
            ->click($clickClassName); // 设置图表点击菜单则重新发起请求，且被点击的目标元素上的 data-xxx 属性会被作为post数据发送到后端API

        return Box::make($title, $bar)
            ->id($boxId) // 设置盒子的ID
            ->tool($dropdown); // 设置下拉菜单按钮
    }
}
