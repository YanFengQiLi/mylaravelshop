<?php
/*
 * @Author: your name
 * @Date: 2020-06-10 09:18:29
 * @LastEditTime: 2020-06-10 10:58:34
 * @LastEditors: your name
 * @Description: In User Settings Edit
 * @FilePath: \mylaravel\app\Admin\Controllers\MemberController.php
 */
/**
 *  会员控制器
 */
namespace App\Admin\Controllers;

use App\Admin\Repositories\Member;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class MemberController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Member(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->account;
            $grid->email;
            $grid->password;
            $grid->user_name;
            $grid->nick_name;
            $grid->sex;
            $grid->photo;
            $grid->status;
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
        return Show::make($id, new Member(), function (Show $show) {
            $show->id;
            $show->account;
            $show->email;
            $show->password;
            $show->user_name;
            $show->nick_name;
            $show->sex;
            $show->photo;
            $show->status;
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
        return Form::make(new Member(), function (Form $form) {
            $form->display('id');
            $form->text('account');
            $form->text('email');
            $form->text('password');
            $form->text('user_name');
            $form->text('nick_name');
            $form->text('sex');
            $form->text('photo');
            $form->text('status');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
