<?php


namespace App\Admin\Renderable;

use App\Models\ProductTemplate;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;

/**
 * 运费模表格筛选器
 * Class ProductTemplateTable
 * @package App\Admin\Renderable
 */
class ProductTemplateTable extends LazyRenderable
{
    public function grid(): Grid
    {
       return Grid::make(new ProductTemplate(), function (Grid $grid){
           $grid->model()->where('status', 1);

           $grid->column('id');

           $grid->column('title', trans('product-template.fields.title'));

           $grid->column('type', trans('product-template.fields.type'))->using(ProductTemplate::RULES)->badge([
               0 => '#000',
               1 => 'green',
               2 => 'purple',
               3 => 'blue',
               4 => 'red'
           ]);
       });
    }
}
