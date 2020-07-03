<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Category;
use Dcat\Admin\Form;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use App\Models\Category as CategoryModel;
use Dcat\Admin\Tree;

/**
 * @author zhenhong~
 * @description 商品分类控制器
 *
 * Class CategoryController
 * @package App\Admin\Controllers
 */
class CategoryController extends AdminController
{
    public function index(Content $content)
    {
        return $content->header('商品分类')
            ->body(function (Row $row) {
                $tree = new Tree(new Category);

                //  更改行数据显示
                $tree->branch(function ($branch) {
                    return $branch['title'];
                });

                $row->column(12, $tree);
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
        return Show::make($id, new Category(), function (Show $show) {
            $show->parent_id;
            $show->order;
            $show->title;
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
        $model = CategoryModel::class;

        //  看源码 MenuController (108行) 和 ModelTree 的(292行) 得知
        return Form::make(new Category(), function (Form $form) use ($model) {
            $form->select('parent_id', '选择分类')->options(function () use ($model){
                return $model::selectOptions();
            })->required();
            $form->number('order')->min(0);
            $form->text('title')->required();
        });
    }
}
