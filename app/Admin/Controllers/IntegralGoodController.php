<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\IntegralGood;
use App\Models\IntegralGood as IntegralGoodModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class IntegralGoodController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new IntegralGood(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('title')->limit(30);
            $grid->column('price');
            $grid->column('on_sale')->switch();
            $grid->column('thumb')->image('', 100, 100);
            $grid->column('type')->using(IntegralGoodModel::TYPE)->badge([
                IntegralGoodModel::DISTINCT_EXCHANGE => 'primary',
                IntegralGoodModel::MONEY_EXCHANGE => 'info'
            ]);
            $grid->column('money');
            $grid->column('number');
            $grid->column('stock');
            $grid->column('is_limit')->using([
                0 => '无限制',
                1 => '限购'
            ])->label([
                0 => 'danger',
                1 => 'success'
            ]);
            $grid->column('limit_number')->display(function () {
                return $this->is_limit ? $this->limit_number : '不限制';
            });
            $grid->column('exchange_number');
            $grid->column('sort')->sortable('desc');
            $grid->column('created_at');
            $grid->column('updated_at');

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('title');
                $filter->equal('on_sale')->select([
                    0 => '下架',
                    1 => '上架'
                ]);
                $filter->equal('type')->select(IntegralGoodModel::TYPE);
                $filter->equal('is_limit')->select([
                    0 => '无限制',
                    1 => '限购'
                ]);
            });

            $grid->disableBatchActions();
            $grid->disableDeleteButton();
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
        return Show::make($id, new IntegralGood(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('price');
            $show->field('on_sale');
            $show->field('thumb')->image('');
            $show->field('pictures')->as(function ($pictures) {
                $pictures = json_decode($pictures, true);
                return implode(',' ,$pictures);
            })->image();
            //  显示富文本信息
            $show->field('description')->unescape();
            $show->field('type')->using(IntegralGoodModel::TYPE);
            $show->field('money');
            $show->field('number');
            $show->field('stock');
            $show->field('is_limit')->using([
                0 => '无限制',
                1 => '限购'
            ]);
            $show->field('limit_number');
            $show->field('exchange_number');
            $show->field('sort');
            $show->field('created_at');
            $show->field('updated_at');

            $show->disableDeleteButton();
            $show->disableEditButton();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new IntegralGood(), function (Form $form) {
            $form->text('title')->required();
            $form->currency('price')->width(4)->required();
            $form->switch('on_sale');
            $form->image('thumb')->help('单张图片')
                ->rules(['required'], ['required' => '请上传图片'])
                ->disableRemove()
                ->url('/uploadFile');
            $form->multipleImage('pictures')->help('按住键盘的 Ctrl 键 ,选择多张图片')
                ->rules(['required'], ['required' => '请上传图片'])
                ->disableRemove()
                ->url('/uploadFile');
            $form->editor('description')->imageUrl('/uploadFile')->required();
            $form->radio('type')
                ->when(IntegralGoodModel::MONEY_EXCHANGE, function (Form $form) {
                    $form->currency('money')->width(4)
                        ->help('最小支付金额为: 0.01 元')
                        ->rules(['required_if:type,1|min:0.01'], [
                            'required_if' => '请填写支付金额',
                            'min' => '支付金额,最小为 0.01 元'
                        ]);
                })
                ->options(IntegralGoodModel::TYPE)->default(0)
                ->help('<span style="color: red">说明: 直接兑换 - 直接使用设置的积分,就可以兑换此商品; 积分换购 - 所需积分 + 所需金额</span>');
            $form->number('number')->width(4)->min(1);
            $form->number('stock')->width(4)->min(1);
            $form->radio('is_limit')
                ->when(1, function (Form $form) {
                    $form->number('limit_number')->width(4)->min(1)->default(1);
                })
                ->options([
                    0 => '无限制',
                    1 => '限购'
                ])->default(1)
                ->help('<span style="color: red">推荐设限 : 一个用户账号, 只能兑换当前商品 X 次, 防止恶意兑换</span>');

            $form->number('sort')->width(4)->min(1)->default(1)->help('排序值,越大商品,越靠前展示');
        });
    }
}
