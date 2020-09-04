<?php
namespace App\Admin\Controllers;

use App\Admin\Metrics\Examples;
use App\Admin\Widgets\Charts\GoodsSaleCount;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Widgets\Card;
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
                        Card::make('', GoodsSaleCount::make())
                        ->tool($this->generateDropdownWidget())
                    );
                });

                $row->column(6, function (Column $column) {
                    $column->row(function (Row $row) {
                        $row->column(6, new Examples\NewUsers());
                        $row->column(6, new Examples\NewDevices());
                    });

                    $column->row(new Examples\Sessions());
                    $column->row(new Examples\ProductOrders());
                });
            });
    }

    /**
     * 新用户增长看板
     * @param Member $member
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getMemberGrowth()
    {
        $member = new Member();

        $count = [
            'day' => $member->countNewMember(),
            'month' => $member->countNewMember('month'),
            'year' => $member->countNewMember('year'),
        ];

        return view('dashboard.member-growth', compact('count'));
    }

    /**
     * 构建下拉菜单
     * @return Dropdown
     */
    public function generateDropdownWidget()
    {
        $options = [
            '7' => '最近7天',
            '30' => '最近30天',
            '90' => '最近90天',
            '6' => '最近半年',
            '12' => '最近1年'
        ];

        return Dropdown::make($options)
        ->button(current($options))
        ->click()
        ->map(function ($item, $index) {
            return "<a class='switch-bar' data-option='{$index}'>{$item}</a>";
        });
    }
}
