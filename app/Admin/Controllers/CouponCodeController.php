<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\CouponCode;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use App\Models\CouponCode as CouponCodeModel;

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
     * @return Form
     * @author zhenhong~
     *
     * Form 表单
     *
     */
    protected function form()
    {
        try {
            return Form::make(new CouponCode(), function (Form $form) {
                $form->display('id');
                $form->text('name')->required();
                $form->text('code')->placeholder('不填时,系统则会自动生成')->rules(function ($form) {
                    //  如果 id 不为空代表是编辑操作
                    if ($id = $form->model()->id) {
                        //  此处使用 laravel 自带唯一性验证来做, unique:table(表名),column(字段名),except(记录ID),idColumn(主键名称)
                        return 'nullable|unique:coupon_codes,code,' . $id . ',id';
                    } else {
                        return 'nullable|unique:coupon_codes';
                    }
                })->saving(function (Form $form) {
                    if (!$form->model()->code) {
                        return CouponCodeModel::findAndGenerateCouponCode();
                    }
                });
                $form->radio('type')->options(CouponCodeModel::COUPON_TYPE)->rules('required', [
                    'required' => '请选择券类型'
                ]);
                $form->text('value')->rules(function ($form) {
                    if ($form->model()->type === CouponCodeModel::TYPE_RATE) {
                        //  折扣类型为百比例: 必须是 1 ~ 99
                        return 'required|numeric|between:1,99';
                    } else {
                        //  折扣类型为固定金额: >= 0.01 即可
                        return 'required|numeric|min:0.01';
                    }
                }, [
                    'required' => '请填写折扣',
                    'numeric' => '折扣必须为数字',
                    'between' => '比例券,折扣范围只能在1 ~ 99的数字',
                    'min' => '固定金额券,折扣最小为 0.01 元'
                ]);
                $form->number('total')->rules('required|numeric|min:0', [
                    'required' => '请填写券总量',
                    'numeric' => '券总量必须为数字',
                    'min' => '券总量最小为0',
                ]);
                $form->text('min_amount')->rules('required|numeric|min:0', [
                    'required' => '请填写最低使用金额',
                    'numeric' => '必须是数字',
                    'min' => '最低使用金额为 0.01 元'
                ]);
                $form->datetime('before_time')->format('YYYY-MM-DD HH:mm:00')->rules('nullable|before:after_time', [
                    //'required' => '请设置' . trans('coupon-code.fields.after_time'),
                    'before' => trans('coupon-code.fields.before_time') . '必须小于' . trans('coupon-code.fields.after_time')
                ]);
                $form->datetime('after_time')->format('YYYY-MM-DD HH:mm:00')->rules('nullable|after:before_time', [
                    //'required' => '请设置' . trans('coupon-code.fields.after_time'),
                    'after' => trans('coupon-code.fields.after_time') . '必须大于' . trans('coupon-code.fields.before_time')
                ]);
                $form->switch('enable', '是否启用');
            })->title('<span style="color: red">注: 不限制使用时间,开始和结束时间都不设置即可</span>');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
