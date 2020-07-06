<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\CouponCode;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class CouponCodeController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new CouponCode(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->name;
            $grid->code;
            $grid->type;
            $grid->value;
            $grid->total;
            $grid->used;
            $grid->min_amount;
            $grid->before_time;
            $grid->after_time;
            $grid->enable;
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
        return Show::make($id, new CouponCode(), function (Show $show) {
            $show->id;
            $show->name;
            $show->code;
            $show->type;
            $show->value;
            $show->total;
            $show->used;
            $show->min_amount;
            $show->before_time;
            $show->after_time;
            $show->enable;
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
        return Form::make(new CouponCode(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            $form->text('code');
            $form->radio('type')->options(\App\Models\CouponCode::COUPON_TYPE);
            $form->text('value');
            $form->text('total');
            $form->text('used');
            $form->text('min_amount');
            $form->text('before_time');
            $form->text('after_time');
            $form->text('enable');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
