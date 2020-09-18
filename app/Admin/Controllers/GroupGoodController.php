<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\GroupGood;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class GroupGoodController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new GroupGood(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('thumb')->image('',100,100);
            $grid->column('on_sale')->switch();
            $grid->column('description')->display('点击查看')->modal('商品详情', function () {
                return $this->description;
            });
            $grid->column('old_price');
            $grid->column('group_price');
            $grid->column('stock');
            $grid->column('sale_number')->sortable();
            $grid->column('group_number');
            $grid->column('open_group_number');
            $grid->column('end_time');
            $grid->column('is_auto')->using([
                0 => '已关闭',
                1 => '已开启'
            ])->label([
                0 => 'danger',
                1 => 'success'
            ]);
            $grid->column('auto_hour')->display(function ($auto_hour){
                return $auto_hour. '小时';
            });
            $grid->column('sort');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->disableDeleteButton();
            $grid->disableRowSelector();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('title');

                $filter->equal('on_sale')->select([
                    0 => '下架',
                    1 => '上架',
                ]);

                $filter->equal('is_auto')->select([
                    0 => '已关闭',
                    1 => '已开启'
                ]);

                $filter->whereBetween('end_time', function ($query){
                    $start = $this->input['start'] ?? null;
                    $end = $this->input['end'] ?? null;

                    if ($start) {
                        $query->where('end_time', '>=', $start.' 00:00:00');
                    }

                    if ($end) {
                        $query->where('end_time', '<=', $end.' 23:59:59');
                    }

                    if ($start && $end) {
                        $query->whereBetween('end_time', [
                            $start.' 00:00:00', $end.' 23:59:59'
                        ]);
                    }
                })->date();
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new GroupGood(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('thumb')->image('','100',100);
            $show->field('images')->image('','100',100);
            $show->field('description')->unescape();
            $show->field('old_price');
            $show->field('group_price');
            $show->field('stock');
            $show->field('sale_number');
            $show->field('on_sale')->using([
                0 => '下架',
                1 => '上架',
            ]);
            $show->field('group_number');
            $show->field('open_group_number');
            $show->field('end_time');
            $show->field('is_auto')->using([
                0 => '已关闭',
                1 => '已开启'
            ]);;
            $show->field('auto_hour');
            $show->field('sort');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     * bootstrap-datepicker 文档
     * https://github.com/pingcheng/bootstrap4-datetimepicker/blob/master/docs/Options.md
     * @return Form
     */
    protected function form()
    {
        return Form::make(new GroupGood(), function (Form $form) {
            $form->text('title')->required();
            $form->image('thumb')->required();
            $form->multipleImage('images')->saveAsJson()->required()->help('按住 Ctrl 键,进行多选');
            $form->editor('description')->required();
            $form->currency('old_price')->width(4);
            $form->currency('group_price')->width(4);
            $form->number('stock')->rules('required|numeric|min:0', [
                'required' => '请填写库存',
                'number' => '库存必须为数字',
                'min' => '库存最小为0',
            ])->min(0)->help('为保证活动正常, 请保证库存充足, 请填写库存数字');
            $form->switch('on_sale');
            $form->number('group_number')->rules('required|numeric|between:2,10', [
                'required' => '请填写库存',
                'number' => '成团人数必须为数字',
                'between' => '成团人数在 2 ~ 10 人之间的数字',
            ])
            ->default(2)->min(2)
            ->help('多少人可拼成团, 从营销考虑, 成团人数设置区间在 2 ~ 10 之间的数字');
            $form->date('end_time')
                ->options(['minDate' => date('Y-m-d')])
                ->help('到该日期后, 拼团活动结束')
                ->saving(function ($end){
                    return $end . ' 23:59:59';
                });
            $form->radio('is_auto')
                ->when(1, function (Form $form) {
                    $form->number('auto_hour')->min(1)->rules('required_if:is_auto,1|between:1,48', [
                        'required_if' => '请设置自动成团时间',
                        'between' => '自动成团时间在 1 ~ 48 小时之间'
                    ])->help('时间设置在 1 ~ 48 小时之间');
                })->options([
                    0 => '关闭',
                    1 => '开启'
                ])->default(1)->help(
                    '<span style="color: red">说明: 开启后, 当有人开团时, 此人开团时间 + 自动成团时间后, 还没有成团则自动成团</span>'
                );

            $form->number('sort')->default(1)->min(1)->help('排序值越大,越靠前');
        });
    }
}
