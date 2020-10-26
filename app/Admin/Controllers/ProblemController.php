<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\BatchDelete;
use App\Admin\Actions\Grid\BatchRestore;
use App\Admin\Actions\Grid\Delete;
use App\Admin\Actions\Grid\Restore;
use App\Admin\Repositories\Problem;
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

            $grid->disableDeleteButton();
            $grid->actions(function (Grid\Displayers\Actions $actions) {
                //  软删除行恢复操作
                if (request('_scope_') == 'trashed') {
                    $actions->append(new Restore(\App\Models\Problem::class));
                } else {
                    $actions->append(new Delete(\App\Models\Problem::class));
                }
            });

            $grid->disableBatchDelete();
            $grid->batchActions(function (Grid\Tools\BatchActions $batchActions) {
                //  软删除批量恢复操作
                if (request('_scope_') == 'trashed') {
                    $batchActions->add(new BatchRestore(\App\Models\Problem::class));
                } else {
                    $batchActions->add(new BatchDelete(\App\Models\Problem::class));
                }
            });

            $grid->setActionClass(config('admin.grid.grid_logo_action_class'));
            $grid->quickSearch('title');
            $grid->filter(function (Grid\Filter $filter) {
                // 更改为 panel 布局, 当 filter 里只有回收站方法时, 会出现 rightSide 布局弹窗为空的情况
                $filter->panel();

                $filter->scope('trashed', '回收站')->onlyTrashed();
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
