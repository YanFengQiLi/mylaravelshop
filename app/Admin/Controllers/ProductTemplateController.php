<?php

namespace App\Admin\Controllers;

use App\Models\District;
use App\Admin\Repositories\ProductTemplate;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use App\Models\ProductTemplate as ProductTemplateModel;
use function foo\func;

class ProductTemplateController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ProductTemplate(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->title;
            $grid->type;
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
        return Show::make($id, new ProductTemplate(), function (Show $show) {
            $show->id;
            $show->title;
            $show->type;
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * @return Form
     */
    protected function form()
    {
        $district = new District();

        $repository = new ProductTemplate(['templateRule']);

        return Form::make($repository, function (Form $form) use ($district) {
            $form->hidden('id');
            $form->text('title')->rules('required',['required' => admin_trans_field('title').'必填']);
            $form->select('type')
                ->when(ProductTemplateModel::SPECIAL_FREE, function (Form $form) use ($district) {
                    $form->tree('city', '选择地区')
                        ->nodes($district::getProvinceList()->toArray())->setTitleColumn('ext_name')
                        ->disableFilterParents()
                        ->rules('required_if:type,1', ['required_if' => '请选择地区']);
                })
                ->when(ProductTemplateModel::UNIT, function (Form $form) use ($district) {
                    $form->tree('city', '选择地区')
                        ->nodes($district::getProvinceList()->toArray())->setTitleColumn('ext_name')
                        ->disableFilterParents()
                        ->rules('required_if:type,2', ['required_if' => '请选择地区']);
                    $form->number('default_num', '默认数量')->min(1)->width(-10, 2)->help('默认购买 N 件商品');
                    $form->number('default_price', '默认邮费')->min(0)->width(-10, 2)->help('默认需要支付 N 元邮费');
                    $form->number('add_num', '新增数量')->min(1)->width(-10, 2)->help('每新增 N 件商品');
                    $form->number('add_price', '新增费用')->min(0)->width(-10, 2)->help('需要额外支付 N 元邮费');
                })
                ->when(ProductTemplateModel::FIXED, function (Form $form) use ($district) {
                    $form->tree('city', '选择地区')
                        ->nodes($district::getProvinceList()->toArray())->setTitleColumn('ext_name')
                        ->disableFilterParents()
                        ->rules('required_if:type,3', ['required_if' => '请选择地区']);
                    $form->number('extra', '固定邮费')->min(0);
                })
                ->when(ProductTemplateModel::MONEY, function (Form $form) use ($district){
                    $form->tree('city', '选择地区')
                        ->nodes($district::getProvinceList()->toArray())->setTitleColumn('ext_name')
                        ->disableFilterParents()
                        ->rules('required_if:type,4', ['required_if' => '请选择地区']);
                    $form->number('extra', '消费金额')->min(0);
                })
                ->options(ProductTemplateModel::RULES)
                ->default(ProductTemplateModel::FREE);
        });
    }
}
