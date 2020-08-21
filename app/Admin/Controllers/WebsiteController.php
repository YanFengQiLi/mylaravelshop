<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Website;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class WebsiteController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
//    protected function grid()
//    {
//        return Grid::make(new Website(), function (Grid $grid) {
//            $grid->id->sortable();
//            $grid->key;
//            $grid->key_name;
//            $grid->key_value;
//
//            $grid->filter(function (Grid\Filter $filter) {
//                $filter->equal('id');
//
//            });
//        });
//    }

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
//                $form->image('key[logo]','logo');
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
                    $form->multipleSelect('register_coupon_id', '选择优惠券');
                });
            });

        });
    }
}
