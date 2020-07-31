<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\BatchRestore;
use App\Admin\Actions\Grid\Restore;
use App\Admin\Repositories\Advert;
use App\Models\Advert as AdvertModel;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;

class AdvertController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Advert('advertType'), function (Grid $grid) {
            $grid->id->sortable();
            $grid->title;
            $grid->column('advertType.title','广告类型');
            $grid->links->link();
            $grid->status->switch();
            $grid->image->image('',100,100);
            $grid->sort->sortable();
            $grid->created_at;
            $grid->updated_at->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->scope('trashed', '回收站')->onlyTrashed();
                $filter->like('title');
                $filter->equal('advert_type_id')->select('/api/advert-type');
            });

            $grid->disableViewButton();
            $grid->setActionClass(config('admin.grid.grid_logo_action_class'));

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                //  软删除行恢复操作
                if (request('_scope_') == 'trashed') {
                    $actions->append(new Restore(AdvertModel::class));
                }
            });

            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                //  软删除批量恢复操作
                if (request('_scope_') == 'trashed') {
                    $batch->add(new BatchRestore(AdvertModel::class));
                }
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Advert(), function (Form $form) {
            $form->text('title')->required();
            $form->select('advert_type_id')->options('/api/advert-type')->required();
            $form->url('links');
            $form->image('image')->required();
            $form->number('sort')->min(0);
            $form->switch('status','是否启用');
        });
    }
}
