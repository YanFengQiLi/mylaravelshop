<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\District;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use App\Models\District as DistrictModel;

class DistrictController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new District(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->pid;
            $grid->deep;
            $grid->name;
            $grid->pinyin;
            $grid->pinyin_short;
            $grid->ext_name;
            $grid->create_time;
            $grid->update_time;
            $grid->operator;

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
        return Show::make($id, new District(), function (Show $show) {
            $show->id;
            $show->pid;
            $show->deep;
            $show->name;
            $show->pinyin;
            $show->pinyin_short;
            $show->ext_name;
            $show->create_time;
            $show->update_time;
            $show->operator;
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new District(), function (Form $form) {
            $form->display('id');
            $form->text('pid');
            $form->text('deep');
            $form->text('name');
            $form->text('pinyin');
            $form->text('pinyin_short');
            $form->text('ext_name');
            $form->text('create_time');
            $form->text('update_time');
            $form->text('operator');
        });
    }


    /**
     * 获取省份
     *
     * @param DistrictModel $district
     * @return \Illuminate\Support\Collection
     */
    public function getProvince(DistrictModel $district)
    {
        return $district::where('pid', 0)->get([
            'id', 'ext_name AS text'
        ]);
    }
}
