<?php

namespace App\Admin\Controllers;

use App\Admin\Renderable\CouponCodeTable;
use App\Admin\Repositories\Website;
use App\Models\CouponCode;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use App\Models\Website as WebModel;

class WebsiteController extends AdminController
{
    public function index(Content $content)
    {
        $web = new WebModel();

        $data = $web->getWebSiteConfig();

        return $content
            ->title('网站设置')
            ->body($this->form($data));
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
     * @param $web
     * @return Form
     */
    protected function form($web)
    {
        return Form::make(new Website(), function (Form $form) use ($web) {
            $form->action('web-sites');

            $form->tab('基本设置', function (Form $form) use ($web) {
                $form->image('logo', 'logo')->required();
                $form->text('shop_name', '网站名称')->value($web['shop_name'])->required();
            })
                ->tab('商城设置', function (Form $form) use ($web) {
                    $form->radio('register_integral', '新人注册送积分')
                        ->when(1, function (Form $form) use ($web) {
                            $form->number('register_integral_number', '赠送积分数量')
                                ->min(0)->width(100)
                                ->value($web['register_integral_number']);
                        })->options([
                            0 => '关闭',
                            1 => '开启'
                        ])->default(0)
                        ->value($web['register_integral'])
                        ->help('开启后,只要是新用户注册就送N个积分');

                    $form->radio('register_coupon', '新人注册送优惠券')
                        ->when(1, function (Form $form) use ($web) {
                            $form->multipleSelectTable('register_coupon_id', '选择优惠券')
                                ->from(CouponCodeTable::make($web['register_coupon_id'] ?: []))
                                ->model(CouponCode::class, 'id', 'name')
                                ->saving(function ($v) {
                                    return implode(',', $v);
                                });
                        })->options([
                            0 => '关闭',
                            1 => '开启'
                        ])->default(0)
                        ->value($web['register_coupon'])
                        ->help('开启后,只要是新用户注册就送选择好的优惠券');

                    $form->radio('integral_money', '积分抵现')
                        ->when(1, function (Form $form) use ($web) {
                            $form->number('use_integral', '满N个积分可抵扣')
                                ->min(1)->width(100)
                                ->help('说明: 积分达到 N 个后可抵扣')
                                ->value($web['use_integral']);

                            $form->number('integral_money_number', '设置积分抵扣数量')
                                ->min(1)->width(100)
                                ->help('说明: 设置 N 个积分,抵扣1元')
                                ->value($web['integral_money_number']);
                        })
                        ->options([
                            0 => '关闭',
                            1 => '开启'
                        ])->default(0)
                        ->value($web['integral_money'])
                        ->help('开启后,下单时可以使用积分抵扣现金');
                })
                ->tab('签到设置', function (Form $form) use ($web) {
                    $form->radio('sign_rule', '签到规则')
                        ->when('fix', function (Form $form) use ($web) {
                            $form->number('fix_number', '固定积分')->min(1)->value($web['fix_number']);
                        })->options([
                            'add' => '连续签到,累加积分',
                            'fix' => '固定积分'
                        ])
                        ->default('add')
                        ->value($web['sign_rule'])
                        ->help('连续签到: 以7天为单位,最高可得7积分,断签重置从1积分开始 <br /> 固定积分: 不论哪天签到,都获得固定积分');
                });

            $form->disableListButton();
        });
    }
}
