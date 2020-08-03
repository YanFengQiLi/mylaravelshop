<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\AdminMessage;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class AdminMessageController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AdminMessage(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->type;
            $grid->title;
//            $grid->extra;
            $grid->created_at;
            $grid->status->using([0 => '未读', 1 => '已读'])->badge([
                0 => 'danger',
                1 => 'success'
            ]);
            $grid->updated_at->sortable();
            $grid->quickSearch('title');

            $grid->disableCreateButton();
            $grid->disableEditButton();
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
        return Show::make($id, new AdminMessage(), function (Show $show) {
            $show->id;
            $show->type;
            $show->title;
            $show->extra;
            $show->created_at;
            $show->updated_at;
        });
    }
}
