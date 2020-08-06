<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Grid\BatchRead;
use App\Admin\Actions\Grid\Read;
use App\Admin\Repositories\AdminMessage;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use App\Models\AdminMessage as AdminMessageModel;

class AdminMessageController extends AdminController
{
    /**
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        $id = request('id');

        $status = request('status');

        return $content->body($this->grid($status, $id));
    }

    /**
     * @param $status  -状态
     * @param $id   - ID
     * @return Grid
     */
    protected function grid($status, $id)
    {
        return Grid::make(new AdminMessage(), function (Grid $grid) use ($status, $id){
            if ($id) {
                $grid->model()->where('id', $id);
            }

            if (!is_null($status)) {
                $grid->model()->where('status', 0);
            }

            $grid->id->sortable();
            $grid->type->using(AdminMessageModel::TYPE)->label([
                AdminMessageModel::ORDER_PAID => 'info',
                AdminMessageModel::ORDER_REFUND => 'danger'
            ]);
            $grid->title;
//            $grid->extra;
            $grid->created_at->sortable();
            $grid->status->using([0 => '未读', 1 => '已读'])->badge([
                0 => 'danger',
                1 => 'success'
            ]);
            $grid->updated_at;

            $grid->actions(function (Grid\Displayers\Actions $actions){
                $actions->append(new Read());
            });
            $grid->batchActions(function (Grid\Tools\BatchActions $batch) {
                $batch->add(new BatchRead());
            });

            $grid->filter(function (Grid\Filter $filter){
                $filter->like('title');

            });

            $grid->disableCreateButton();
            $grid->disableEditButton();
            $grid->disableViewButton();
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
