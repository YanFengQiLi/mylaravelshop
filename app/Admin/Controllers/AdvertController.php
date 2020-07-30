<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Advert;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
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
        return Grid::make(new Advert(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->title;
            $grid->advert_type_id;
            $grid->links;
            $grid->status;
            $grid->image;
            $grid->sort;
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
        return Show::make($id, new Advert(), function (Show $show) {
            $show->id;
            $show->title;
            $show->advert_type_id;
            $show->links;
            $show->status;
            $show->image;
            $show->sort;
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
        return Form::make(new Advert(), function (Form $form) {
            $form->display('id');
            $form->text('title');
            $form->text('advert_type_id');
            $form->text('links');
            $form->text('status');
            $form->text('image');
            $form->text('sort');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
