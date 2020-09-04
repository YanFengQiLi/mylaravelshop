<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\MemberIntegral;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;
use App\Models\MemberIntegral as Model;

class MemberIntegralController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new MemberIntegral(['member']), function (Grid $grid) {
            $grid->id->sortable();
            $grid->column('member.email','用户邮箱');
            $grid->column('member.account', '用户手机号');
            $grid->type->using([
                'add' => '↑↑',
                'sub' => '↓↓'
            ])->label([
                'add' => 'green',
                'sub' => 'red'
            ]);
            $grid->source->using(Model::SOURCE)->badge([
                Model::SIGN => 'black',
                Model::ORDER_COMMENT => 'purple',
                Model::ORDER_SPEND => 'red',
                Model::SPEND => 'pink',
            ]);
            $grid->num;
            $grid->created_at->sortable();

            $grid->disableActions();
            $grid->disableRowSelector();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('member.email','会员邮箱');

                $filter->like('member.account', '会员手机号');

                $filter->between('created_at')->datetime();
            });
        });
    }
}
