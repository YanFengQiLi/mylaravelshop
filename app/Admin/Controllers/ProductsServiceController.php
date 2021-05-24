<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\ProductsService;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use App\Models\ProductsService as ProductServiceModel;

class ProductsServiceController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ProductsService(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('icon')->image('',100,100);
            $grid->column('title');
            $grid->column('content');
            $grid->column('status')->switch('green');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->quickSearch('title');

            $grid->enableDialogCreate();
            $grid->showQuickEditButton();

            $grid->disableEditButton();
            $grid->disableViewButton();
            $grid->disableDeleteButton();
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
        return Show::make($id, new ProductsService(), function (Show $show) {
            $show->field('icon');
            $show->field('title');
            $show->field('content');
            $show->field('status');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new ProductsService(), function (Form $form) {
            $form->image('icon')->url('/uploadFile')->required();
            $form->text('title')->required();
            $form->textarea('content')->help('最多输入50个字符')->width(6,2)->rules('required|max:50',[
                'required' => '晴天服务描述',
                'max' => '最多输入50个字符'
            ]);
            $form->switch('status');
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * 商品服务select多选接口
     */
    public function getProductServiceSelectList(ProductServiceModel $productsService)
    {
       return $productsService->getProductServiceList('id, title as text');
    }
}
