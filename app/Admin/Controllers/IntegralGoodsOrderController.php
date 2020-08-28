<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\IntegralGoodsOrder;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class IntegralGoodsOrderController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new IntegralGoodsOrder(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('order_no');
            $grid->column('member_id');
            $grid->column('number');
            $grid->column('integral_number');
            $grid->column('money');
            $grid->column('order_address');
            $grid->column('deliver_data');
            $grid->column('pay_method');
            $grid->column('remark');
            $grid->column('refund_no');
            $grid->column('pay_no');
            $grid->column('paid_at');
            $grid->column('pay_status');
            $grid->column('deliver_status');
            $grid->column('reviewed');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
        
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
        return Show::make($id, new IntegralGoodsOrder(), function (Show $show) {
            $show->field('id');
            $show->field('order_no');
            $show->field('member_id');
            $show->field('number');
            $show->field('integral_number');
            $show->field('money');
            $show->field('order_address');
            $show->field('deliver_data');
            $show->field('pay_method');
            $show->field('remark');
            $show->field('refund_no');
            $show->field('pay_no');
            $show->field('paid_at');
            $show->field('pay_status');
            $show->field('deliver_status');
            $show->field('reviewed');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new IntegralGoodsOrder(), function (Form $form) {
            $form->display('id');
            $form->text('order_no');
            $form->text('member_id');
            $form->text('number');
            $form->text('integral_number');
            $form->text('money');
            $form->text('order_address');
            $form->text('deliver_data');
            $form->text('pay_method');
            $form->text('remark');
            $form->text('refund_no');
            $form->text('pay_no');
            $form->text('paid_at');
            $form->text('pay_status');
            $form->text('deliver_status');
            $form->text('reviewed');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
