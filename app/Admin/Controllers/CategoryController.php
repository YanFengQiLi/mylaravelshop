<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Category;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use App\Models\Category as CategoryModel;
use Dcat\Admin\Traits\HasFormResponse;
use Illuminate\Http\Request;
use Dcat\Admin\Layout\Content;

/**
 * @author zhenhong~
 * @description 商品分类控制器
 *
 * Class CategoryController
 * @package App\Admin\Controllers
 */
class CategoryController extends AdminController
{
    use HasFormResponse;

    public function index(Content $content)
    {
        $grid = Grid::make(new Category(), function (Grid $grid) {
            $grid->title->tree(true);

            $grid->disableBatchActions();

            $grid->disableRowSelector();

            $grid->enableDialogCreate();

            $grid->disableViewButton();

            $grid->column('icon', '图标')->if(function (Grid\Column $column) {
                return $column->getValue() ?? '';
            })->then(function (Grid\Column $column) {
                $column->display($this->icon)->image('', 32,32);
            })->else(function (Grid\Column $column) {
                $column->emptyString();
            });

            $grid->column('is_index_show', '是否在首页显示')->if(function () {
                $parentId = $this->parent_id;

                return $parentId === 0 ? true : false;
            })->then(function (Grid\Column $column) {
                $column->switch('green');
            })->else(function (Grid\Column $column) {
                $column->emptyString();
            });
        });

        return $content->header('商品分类管理')->body($grid);
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
        return Show::make($id, new Category(), function (Show $show) {
            $show->parent_id;
            $show->order;
            $show->title;
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * Make a form builder.
     *
     * 注意, 若想直接使用 dcat 无限极分类下拉组件,则使用:
     *      看源码 MenuController (108行) 和 ModelTree 的(292行) 得知 CategoryModel::selectOptions();
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Category(), function (Form $form) {
            $form->select('parent_id', '选择分类')->options(function () {
                return CategoryModel::selectOptions();
            });
            $form->image('icon', '图标')->url('/uploadFile')->rules('required', ['required' => '请上传分类图标'])->help('分类图标最佳尺寸为 37 * 37');
            $form->number('order')->min(0);
            $form->text('title')->required();
            $form->hidden('is_index_show')->default(0);
        });
    }

    /**
     * 下拉菜单,联动获取商品分类
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function getCategory(Request $request)
    {
        $parentId = $request->get('q');

        return CategoryModel::where('parent_id', $parentId)
            ->orderBy('order','asc')
            ->get(['id', 'title AS text']);
    }


    /**
     * 获取商品顶级分类
     * @return \Illuminate\Support\Collection
     */
    public function getGrandCategory()
    {
        return CategoryModel::where('parent_id',0)->orderBy('order', 'asc')->get([
            'id', 'title AS text'
        ]);
    }
}
