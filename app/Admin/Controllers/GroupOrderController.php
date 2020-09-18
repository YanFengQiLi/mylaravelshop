<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\GroupOrder;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class GroupOrderController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new GroupOrder(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('order_no');
            $grid->column('member_id');
            $grid->column('address');
            $grid->column('buy_number');
            $grid->column('total_price');
            $grid->column('pay_method');
            $grid->column('pay_no');
            $grid->column('remark');
            $grid->column('refund_no');
            $grid->column('closed');
            $grid->column('is_reviewed');
            $grid->column('deliver_data');
            $grid->column('extra');
            $grid->column('pay_status');
            $grid->column('deliver_status');
            $grid->column('paid_at');
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
        return Show::make($id, new GroupOrder(), function (Show $show) {
            $show->field('id');
            $show->field('order_no');
            $show->field('member_id');
            $show->field('address');
            $show->field('buy_number');
            $show->field('total_price');
            $show->field('pay_method');
            $show->field('pay_no');
            $show->field('remark');
            $show->field('refund_no');
            $show->field('closed');
            $show->field('is_reviewed');
            $show->field('deliver_data');
            $show->field('extra');
            $show->field('pay_status');
            $show->field('deliver_status');
            $show->field('paid_at');
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
        return Form::make(new GroupOrder(), function (Form $form) {
            $form->display('id');
            $form->text('order_no');
            $form->text('member_id');
            $form->text('address');
            $form->text('buy_number');
            $form->text('total_price');
            $form->text('pay_method');
            $form->text('pay_no');
            $form->text('remark');
            $form->text('refund_no');
            $form->text('closed');
            $form->text('is_reviewed');
            $form->text('deliver_data');
            $form->text('extra');
            $form->text('pay_status');
            $form->text('deliver_status');
            $form->text('paid_at');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
