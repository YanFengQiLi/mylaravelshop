<?php

namespace App\Admin\Controllers;

use App\Models\District;
use App\Admin\Repositories\ProductTemplate;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use App\Models\ProductTemplate as ProductTemplateModel;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductTemplateController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ProductTemplate('templateRule'), function (Grid $grid) {
            $grid->id->sortable();
            $grid->title;
            //  badge 内置了 color 的所有css属性
            $grid->type->using(ProductTemplateModel::RULES)->badge([
                0 => '#000',
                1 => 'green',
                2 => 'purple',
                3 => 'blue',
                4 => 'red'
            ]);
            //  返回城市
            $grid->column('templateRule.city','地区')->display(function (){
                $district = new District();

                $data = $district::getProvinceList();

                $selected = explode(',' ,$this->row()['template_rule']['city']) ?: [];

                $str = '';

                foreach ($data as $val){
                    if (in_array($val['id'], $selected)){
                        $str .= ',' . $val['name'];
                    }
                }

                $str = ltrim($str,',');

                return $str ?: '全部';
            })->explode()->label('orange');
            $grid->status->switch('green');
            $grid->created_at;
            $grid->updated_at->sortable();
            //  固定列 参数1: 从头开始的前 N 列  参数2: 从后往前数的 N 列
            $grid->fixColumns(4,-4);

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('title');

                $filter->equal('type')->select(ProductTemplateModel::RULES);

                $filter->where('city', function ($query){
                    $query->whereHas('templateRule', function ($query){
                        $ids = implode(',', $this->input);

                        $query->whereRaw("FIND_IN_SET({$ids}, city)");
                    });
                }, '地区')->multipleSelect('api/province');
            });

            $grid->disableDeleteButton();
            $grid->disableBatchDelete();
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
        return Show::make($id, new ProductTemplate(['templateRule']), function (Show $show) {
            $show->title;
            $show->type->using(ProductTemplateModel::RULES);
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * @return Form
     */
    protected function form()
    {
        $district = new District();

        $repository = new ProductTemplate(['templateRule']);

        return Form::make($repository, function (Form $form) use ($district) {
            //  被选中的城市
            $selected = $form->model()->template_rule['city'] ?: '';
            $form->hidden('id');
            $form->text('title')->rules('required',['required' => admin_trans_field('title').'必填']);
            $form->switch('status');
            $form->select('type')
                ->when(ProductTemplateModel::SPECIAL_FREE, function (Form $form) use ($district, $selected) {
                    $form->tree('city', '选择地区')
                        ->nodes($district::getProvinceList())
                        ->disableFilterParents()
                        ->rules('required_if:type,1', ['required_if' => '请选择地区'])
                        ->customFormat(function () use ($selected){
                            //  customFormat 来设置 checkbox 的选中项, 阅读源代码: Dcat\Admin\Form\Field\Tree / Dcat\Admin\Form\Field, 发现
                            return $selected;
                        });
                })
                ->when(ProductTemplateModel::UNIT, function (Form $form) use ($district, $selected) {
                    $form->tree('city', '选择地区')
                        ->nodes($district::getProvinceList())
                        ->disableFilterParents()
                        ->rules('required_if:type,2', ['required_if' => '请选择地区'])
                        ->customFormat(function () use ($selected){
                            return $selected;
                        });
                    $form->number('default_num', '默认数量')
                        ->min(1)
                        ->width(-10, 2)
                        ->help('默认购买 N 件商品')
                        ->value($form->model()->template_rule['default_num']);
                    $form->number('default_price', '默认邮费')
                        ->min(0)
                        ->width(-10, 2)
                        ->help('默认需要支付 N 元邮费')
                        ->value($form->model()->template_rule['default_price']);
                    $form->number('add_num', '新增数量')
                        ->min(1)
                        ->width(-10, 2)
                        ->help('每新增 N 件商品')
                        ->value($form->model()->template_rule['add_num']);
                    $form->number('add_price', '新增费用')
                        ->min(0)
                        ->width(-10, 2)
                        ->help('需要额外支付 N 元邮费')
                        ->value($form->model()->template_rule['add_price']);
                })
                ->when(ProductTemplateModel::FIXED, function (Form $form) use ($district, $selected) {
                    $form->tree('city', '选择地区')
                        ->nodes($district::getProvinceList())
                        ->disableFilterParents()
                        ->rules('required_if:type,3', ['required_if' => '请选择地区'])
                        ->customFormat(function () use ($selected){
                            return $selected;
                        });
                    $form->number('extra', '固定邮费')
                        ->min(0)
                        ->rules('required_if:type,3|numeric', ['required_if' => '消费金额必须大于0', 'numeric' => '必须是数字'])
                        ->value($form->model()->template_rule['extra']);
                })
                ->when(ProductTemplateModel::MONEY, function (Form $form) use ($district, $selected){
                    $form->tree('city', '选择地区')
                        ->nodes($district::getProvinceList())
                        ->disableFilterParents()
                        ->rules('required_if:type,4', ['required_if' => '请选择地区'])
                        ->customFormat(function () use ($selected){
                            return $selected;
                        });
                    $form->number('extra', '消费金额')
                        ->min(0)
                        ->rules('required_if:type,4|numeric', ['required_if' => '消费金额必须大于0', 'numeric' => '必须是数字'])
                        ->value($form->model()->template_rule['extra']);
                })
                ->options(ProductTemplateModel::RULES)
                ->default(ProductTemplateModel::FREE);
        });
    }

    /**
     * 选择运费模板 select ajax 分页接口
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProductTemplate(Request $request)
    {
        $q = $request->get('q');

        return ProductTemplateModel::where('title', 'like', "%$q%")
            ->paginate(null, ['id', 'title as text']);
    }
}
