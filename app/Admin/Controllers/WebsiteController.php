<?php

namespace App\Admin\Controllers;

use App\Admin\Renderable\CouponCodeTable;
use App\Admin\Repositories\Website;
use App\Models\CouponCode;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class WebsiteController extends AdminController
{
    public function index(Content $content)
    {
        return $content->body($this->form());
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
        return Show::make($id, new Website(), function (Show $show) {
            $show->id;
            $show->key;
            $show->key_name;
            $show->key_value;
        });
    }

    /**
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Website(), function (Form $form) {
            $form->tab('基本设置', function (Form $form) {
                $form->image('key[logo]','logo');
            })->tab('商城设置', function (Form $form){
                $form->embeds('key', '', function ($form){
                    $form->radio('register_integral', '新人注册送积分')->options([
                        0 => '关闭',
                        1 => '开启'
                    ])->default('0');
                    $form->number('register_integral_number', '赠送积分数量')->min(0)->width(100);
                    $form->radio('register_coupon', '新人注册送优惠券')->options([
                        0 => '关闭',
                        1 => '开启'
                    ])->default('0');
                    $form->multipleSelectTable('register_coupon_id', '选择优惠券')
                        ->from(CouponCodeTable::make())
                        ->model(CouponCode::class, 'id','name')
                        ->saving(function ($v) {
                            return implode(',', $v);
                        });
                    $form->radio('integral_money', '积分抵扣')
                        ->when(1, function (Form $form){
                            $form->number('integral_money_number', '设置积分抵扣数量')
                                ->min(1)->width(100)
                                ->help('说明: 设置X积分,抵扣1元');
                        })
                        ->options([
                            0 => '关闭',
                            1 => '开启'
                        ])
                        ->default('0')->help('开启后下单时,可以用积分抵扣现金');


                });
            });

        });
    }
}
