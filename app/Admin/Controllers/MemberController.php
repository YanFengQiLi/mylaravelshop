<?php
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
            $grid->user_name;
            $grid->nick_name;
            $grid->sex()->using(admin_trans('member.options.sex'));
            $grid->photo;
            $grid->integral;
            $grid->status()->using(admin_trans('member.options.status'))->label([
                0 => 'danger',
                1 => 'success'
            ]);
            $grid->created_at;
            $grid->updated_at->sortable();

            $grid->disableCreateButton();
            $grid->disableEditButton();
            $grid->disableViewButton();
            $grid->setActionClass(config('admin.grid.grid_logo_action_class'));

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('sex')->select([
                    1 => '男',
                    2 => '女'
                ]);
                $filter->equal('status')->select([
                    0 => '冻结',
                    1 => '正常'
                ]);
                $filter->like('account');
                $filter->like('email');
                $filter->like('user_name');
                $filter->like('nick_name');
                $filter->between('created_at')->date();
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
