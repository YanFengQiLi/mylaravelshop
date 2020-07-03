<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\MemberIntegral;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class MemberIntegralController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new MemberIntegral(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->member_id;
            $grid->type;
            $grid->source;
            $grid->num;
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
        return Show::make($id, new MemberIntegral(), function (Show $show) {
            $show->id;
            $show->member_id;
            $show->type;
            $show->source;
            $show->num;
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
        return Form::make(new MemberIntegral(), function (Form $form) {
            $form->display('id');
            $form->text('member_id');
            $form->text('type');
            $form->text('source');
            $form->text('num');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
