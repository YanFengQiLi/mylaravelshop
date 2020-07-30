<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Product;
use App\Models\ProductTemplate;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Traits\HasUploadedFile;
use Illuminate\Support\Arr;

class ProductController extends AdminController
{
    use HasUploadedFile;

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Product(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->title;
            $grid->image->image('', 100, 100);
            $grid->on_sale->using([0 => '下架', 1 => '上架'])->label([
                0 => 'danger',
                1 => 'success'
            ]);
            $grid->rating;
            $grid->sold_count->sortable();
            $grid->review_count;
            $grid->price;
            $grid->created_at;
            $grid->updated_at;

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('title');

                $filter->equal('on_sale')->select([
                    0 => '下架',
                    1 => '上架'
                ]);

                $filter->between('sold_count');

                $filter->between('review_count');
            });

            $grid->disableDeleteButton();
            $grid->disableViewButton();
            $grid->disableBatchActions();
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
        return Show::make($id, new Product(), function (Show $show) {
            $show->id;
            $show->title;
            $show->description;
            $show->image;
            $show->on_sale;
            $show->rating;
            $show->sold_count;
            $show->review_count;
            $show->price;
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
        //  必须显式指定 一对多关系关系
        $repository = new Product(['sku']);

        return Form::make($repository, function (Form $form) {
            $form->text('title')->required();
            //  options 这里控制器默认选中, 也可以使用闭包自己控制选中
            $form->select('product_template_id')
                ->options(ProductTemplate::class, 'id', 'title')
                ->ajax('/api/product-template')->required();
            //  三级联动
            $form->select('grand_id')->options('/api/grand-category')
                ->load('parent_id', '/api/categories')
                ->required();
            $form->select('parent_id')
                ->load('category_id', '/api/categories')
                ->required();
            $form->select('category_id')->required();
            $form->editor('description')->required();
            $form->image('image')->uniqueName()
                ->accept(config('filesystems.images_config.mime_type'))
                ->maxSize(config('filesystems.images_config.max_size'))
                ->rules('required', [
                    'required' => '请上传' . admin_trans_field('image')
                ]);
            $form->multipleImage('pictures')->uniqueName()
                ->limit(5)
                ->rules('required', [
                    'required' => '请上传' . admin_trans_field('image')
                ]);
            //  必须设置此字段,否则在事件中保存不了
            $form->hidden('concat_id');
            $form->switch('on_sale', '是否上架');
            $form->hasMany('sku', '添加商品属性', function (Form\NestedForm $form) {
                $form->text('title', trans('product-sku.fields.title'))
                    ->rules('required', [
                        'required' => '请填写' . trans('product-sku.fields.title')
                    ]);
                $form->text('description', trans('product-sku.fields.description'))
                    ->rules('required', [
                        'required' => '请填写' . trans('product-sku.fields.description')
                    ]);
                $form->number('price')->min(0)
                    ->rules('required', [
                        'required' => '请填写' . trans('product-sku.fields.price')
                    ]);
                $form->number('stock', trans('product-sku.fields.stock'))->min(0)
                    ->rules('required|gt:0', [
                        'required' => '请填写' . trans('product-sku.fields.stock'),
                        'gt' => trans('product-sku.fields.stock') . '必须大于等于0'
                    ]);
                $form->image('img', trans('product-sku.fields.img'))->uniqueName()
                    ->accept(config('filesystems.images_config.mime_type'))
                    ->maxSize(config('filesystems.images_config.max_size'))
                    ->rules('required', [
                        'required' => '请上传' . trans('global.fields.image')
                    ]);
            });

            $form->saving(function (Form $form) {
                $arr = Arr::only(request()->all(), ['grand_id', 'parent_id', 'category_id']);

                $form->concat_id = implode(',', array_values($arr));

                if (request()->has('sku') && !request()->has('_file_del_')) {
                    $sku = $form->input('sku');
                    //  将 sku 的最低价格设置为商品价格
                    $min_price = collect($sku)->where(Form::REMOVE_FLAG_NAME, 0)->min('price') ?: 0;

                    $form->price = $min_price;
                } elseif (request()->has('_file_del_')) {
                    return;
                } else {
                    return $form->error('请添加商品属性');
                }
            });
        });
    }
}
