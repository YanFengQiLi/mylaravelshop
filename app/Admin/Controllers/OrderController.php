<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Order;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class OrderController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Order(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->member_id;
            $grid->coupon_code_id;
            $grid->order_no;
            $grid->order_address;
            $grid->total_price;
            $grid->pay_method;
            $grid->pay_no;
            $grid->remark;
            $grid->refund_no;
            $grid->paid_at;
            $grid->closed;
            $grid->reviewed;
            $grid->deliver_data;
            $grid->extra;
            $grid->pay_status;
            $grid->deliver_status;
            $grid->created_at;
            $grid->updated_at->sortable();
        
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
        return Show::make($id, new Order(), function (Show $show) {
            $show->id;
            $show->member_id;
            $show->coupon_code_id;
            $show->order_no;
            $show->order_address;
            $show->total_price;
            $show->pay_method;
            $show->pay_no;
            $show->remark;
            $show->refund_no;
            $show->paid_at;
            $show->closed;
            $show->reviewed;
            $show->deliver_data;
            $show->extra;
            $show->pay_status;
            $show->deliver_status;
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Order(), function (Form $form) {
            $form->display('id');
            $form->text('member_id');
            $form->text('coupon_code_id');
            $form->text('order_no');
            $form->text('order_address');
            $form->text('total_price');
            $form->text('pay_method');
            $form->text('pay_no');
            $form->text('remark');
            $form->text('refund_no');
            $form->text('paid_at');
            $form->text('closed');
            $form->text('reviewed');
            $form->text('deliver_data');
            $form->text('extra');
            $form->text('pay_status');
            $form->text('deliver_status');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
