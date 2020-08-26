<?php
namespace App\Admin\Renderable;

use App\Models\CouponCode;
use Dcat\Admin\Grid\LazyRenderable;
use Dcat\Admin\Grid;

/**
 * @author zhenhong~
 * 表格筛选器
 * Class CouponCodeTable
 * @package App\Admin\Renderable
 */
class CouponCodeTable extends LazyRenderable
{
    public function grid(): Grid
    {
        return Grid::make(new CouponCode(), function (Grid $grid) {
            $grid->model()->where('enable',1)
                ->where('total','>',0);

            $grid->id;
            $grid->column('name', trans('coupon-code.fields.name'));
            $grid->column('type', trans('coupon-code.fields.type'))->using(CouponCode::COUPON_TYPE)->label([
                CouponCode::TYPE_FIXED => 'primary',
                CouponCode::TYPE_RATE => 'info',
            ]);
            $grid->column('value_show', trans('coupon-code.fields.value_show'));
            $grid->column('before_time', trans('coupon-code.fields.before_time'))->display(function () {
                return $this->before_time ?: '--';
            });
            $grid->column('after_time', trans('coupon-code.fields.after_time'))->display(function () {
                return $this->after_time ?: '--';
            });

            $grid->quickSearch(['name'])->placeholder('输入优惠券标题');

            $grid->paginate(10);
            $grid->disableActions();

//            $grid->filter(function (Grid\Filter $filter) {
//                $filter->like('name', trans('coupon-code.fields.name'));
//
//                $filter->equal('type', trans('coupon-code.fields.type'))->select([0 => 111]);
//            });
        });
    }
}
