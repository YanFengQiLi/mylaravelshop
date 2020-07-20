<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Product;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class ProductController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Product(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->title;
            $grid->image;
            $grid->on_sale;
            $grid->rating;
            $grid->sold_count;
            $grid->review_count;
            $grid->price;
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
        return Show::make($id, new Product(), function (Show $show) {
            $show->id;
            $show->title;
            $show->description;
            $show->image;
            $show->on_sale;
            $show->rating;
            $show->sold_count;
            $show->review_count;
            $show->price;
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
        return Form::make(new Product(), function (Form $form) {
            $form->text('title')->required();
            $form->editor('description')->required();
            $form->image('image')->rules('file',[
                'file' => '请上传'.trans('image')
            ]);
            $form->switch('on_sale','是否上架');
            $form->hasMany('sku','添加商品属性',function (Form\NestedForm $form){
                $form->text('title')->required();
                $form->text('description')->required();
                $form->currency('price')->symbol('￥')->required();
                $form->number('stock',trans('product-sku.fields.stock'))->min(0)->required();
                $form->image('img',trans('product-sku.fields.img'))->required();
            });

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
