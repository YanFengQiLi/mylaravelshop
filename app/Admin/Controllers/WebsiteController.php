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
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Website(), function (Form $form) {
            $form->tab('基本设置', function (Form $form) {
                $form->image('key[][logo]','logo');
                $form->text('key[]');
            })->tab('积分设置', function (Form $form){
                $form->display('id');
                $form->text('key');
                $form->text('key_name');
                $form->text('key_value');
            });

        });
    }
}
