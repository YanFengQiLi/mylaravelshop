<?php

namespace App\Admin\Repositories;

use App\Models\ProductTemplate as Model;
use Dcat\Admin\Form;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Support\Facades\DB;

class ProductTemplate extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    /**
     * 覆写保存方法
     *
     * @param Form $form
     * @return bool|mixed
     * @throws \Exception
     */
    public function store(Form $form)
    {
        // 获取待新增的数据
        $attributes = $form->updates();

        DB::beginTransaction();

        $model = new $this->eloquentClass;

        try {
            //  插入运费模板
            $model->fill([
                'title' => $attributes['title'],
                'type' => $attributes['type'],
                'status' => $attributes['status']
            ])->save();

            switch ($attributes['type'])
            {
                case 0:
                    break;
                case 1:
                    $model->templateRule()->create([
                        'city' => $attributes['city']
                    ]);
                    break;
                case 2:
                    $model->templateRule()->create([
                        'city' => $attributes['city'],
                        'default_num' => $attributes['default_num'],
                        'default_price' => $attributes['default_price'],
                        'add_num' => $attributes['add_num'],
                        'add_price' => $attributes['add_price'],
                    ]);
                    break;
                case 3:
                case 4:
                    $model->templateRule()->create([
                        'city' => $attributes['city'],
                        'extra' => $attributes['extra']
                    ]);
                    break;
            }

            DB::commit();

            return true;
        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception->getMessage());
            return false;
        }
    }

    /**
     * 覆写更新方法
     *
     * 此处涉及到行内编辑, $attributes 内没有我们需要的key,所以需要判断一下
     *
     * @param Form $form
     * @return bool
     * @throws \Exception
     */
    public function update(Form $form)
    {
        // 获取待编辑的数据
        $attributes = $form->updates();

        DB::beginTransaction();

        $id = $form->model()->id;

        try {
            //  获取当前要更新的模型
            $model = (new $this->eloquentClass)::find($id);

            if (isset($attributes['title'])){
                $model->title = $attributes['title'];
            }

            if (isset($attributes['type'])){
                $model->type = $attributes['type'];
            }

            $model->status = $attributes['status'];

            $model->save();

            $type = isset($attributes['type']) ? $attributes['type'] : '';

            //  用户可能会改成其他的类型, 要判断一下
            switch ($type)
            {
                case 1:
                    $model->templateRule ? $model->templateRule()->update([
                        'city' => implode(',', $attributes['city'])
                    ]) : $model->templateRule()->create([
                        'city' => $attributes['city']
                    ]);
                    break;
                case 2:
                    $model->templateRule ? $model->templateRule()->update([
                        'city' => implode(',', $attributes['city']),
                        'default_num' => $attributes['default_num'],
                        'default_price' => $attributes['default_price'],
                        'add_num' => $attributes['add_num'],
                        'add_price' => $attributes['add_price'],
                    ]) : $model->templateRule()->create([
                        'city' => $attributes['city'],
                        'default_num' => $attributes['default_num'],
                        'default_price' => $attributes['default_price'],
                        'add_num' => $attributes['add_num'],
                        'add_price' => $attributes['add_price'],
                    ]);
                    break;
                case 3:
                case 4:
                    $model->templateRule ? $model->templateRule()->update([
                        'city' => implode(',', $attributes['city']),
                        'extra' => $attributes['extra']
                    ]) : $model->templateRule()->create([
                        'city' => $attributes['city'],
                        'extra' => $attributes['extra']
                    ]);
                    break;
                default :
                    break;
            }
            DB::commit();

            return true;
        }catch (\Exception $exception){
            DB::rollBack();

            return false;
        }
    }
}
