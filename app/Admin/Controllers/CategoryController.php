<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Category;
use Dcat\Admin\Form;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use App\Models\Category as CategoryModel;
use Illuminate\Http\Request;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Tree;
use Dcat\Admin\Layout\Row;

/**
 * @author zhenhong~
 * @description 商品分类控制器
 *
 * Class CategoryController
 * @package App\Admin\Controllers
 */
class CategoryController extends AdminController
{
    public function index(Content $content)
    {
        return $content->header('树状模型')
            ->body(function (Row $row) {
                $tree = new Tree(new Category);

                $tree->branch(function ($branch) {
                    return "{$branch['title']}";
                });

                $row->column(12, $tree);
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
            $form->number('order')->min(0);
            $form->text('title')->required();
        });
    }

    /**
     * 根据层级深度,查询分类
     *
     * @param $level
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getDeepCategory($level, Request $request)
    {
        $q = $request->get('q');

        return CategoryModel::where('title', 'like', "%$q%")
            ->where('deep', $level)
            ->orderBy('order','asc')
            ->paginate(null, ['id', 'title AS text']);
    }


    /**
     * 获取商品顶级分类
     *
     * @return array
     */
    public function getGrandCategory()
    {
        $options = CategoryModel::where('parent_id',0)->get([
            'id', 'title AS text'
        ]);

        return collect($options)->prepend([
            'id' => 0,
            'text' => '顶级分类'
        ],'0')->all();
    }
}
