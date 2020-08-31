<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Problem;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class ProblemController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Problem(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('title');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
            //  以弹窗形式渲染新增按钮
            $grid->enableDialogCreate();
            //  以弹窗形式渲染编辑按钮
            $grid->showQuickEditButton();

            $grid->disableEditButton();

            $grid->setActionClass(config('admin.grid.grid_logo_action_class'));

            $grid->quickSearch('title');
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
        return Show::make($id, new Problem(), function (Show $show) {
            $show->field('id');
            $show->field('title');
            $show->field('answer');
            $show->field('created_at');
            $show->field('updated_at');

            $show->disableEditButton();
            $show->disableDeleteButton();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Problem(), function (Form $form) {
            $form->text('title')->required();
            $form->textarea('answer')->required();
        });
    }
}
