<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\BatchRestore;
use App\Admin\Actions\Grid\Restore;
use App\Models\AdvertType;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;

class AdvertTypeController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AdvertType(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->title->editable(true)->help('单击标题名称编辑');
            $grid->created_at;
            $grid->updated_at->sortable();
            $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
                $create->text('title', '类型名称');
            });
            $grid->quickSearch('title');
            $grid->setActionClass(config('admin.grid.grid_logo_action_class'));

            $grid->filter(function ($filter){
                //  回收站入口
                $filter->scope('trashed', '回收站')->onlyTrashed();
            });

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                //  软删除行恢复操作
                if (request('_scope_') == 'trashed') {
                    $actions->append(new Restore(AdvertType::class));
                }
            });

            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                //  软删除批量恢复操作
                if (request('_scope_') == 'trashed') {
                    $batch->add(new BatchRestore(AdvertType::class));
                }
            });


            $grid->disableCreateButton();
            $grid->disableEditButton();
            $grid->disableViewButton();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new AdvertType(), function (Form $form) {
            $form->display('id');
            $form->text('title');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }


    /**
     * 获取广告类型
     * @return array
     */
    public function getAdvertType()
    {
       return AdvertType::get(['id', 'title AS text'])->toArray();
    }
}
