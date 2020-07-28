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

        try {
            //  插入运费模板
            (new $this->eloquentClass)->fill([
                'title' => $attributes['title'],
                'type' => $attributes['type']
            ])->save();

            switch ($attributes['type'])
            {
                case 0:
                    break;
                case 1:
                    (new $this->eloquentClass)->templateRule()->create([
                        'city' => $attributes['city']
                    ]);
                    break;
                case 2:
                    (new $this->eloquentClass)->templateRule()->create([
                        'city' => $attributes['city'],
                        'default_num' => $attributes['default_num'],
                        'default_price' => $attributes['default_price'],
                        'add_num' => $attributes['add_num'],
                        'add_price' => $attributes['add_price'],
                    ]);
                    break;
                case 3:
                case 4:
                    (new $this->eloquentClass)->templateRule()->create([
                        'city' => $attributes['city'],
                        'extra' => $attributes['extra']
                    ]);
                    break;
            }

            DB::commit();

            return true;
        }catch (\Exception $exception){
            DB::rollBack();

            return false;
        }
    }

    /**
     * 覆写更新方法
     *
     * @param Form $form
     * @return bool
     * @throws \Exception
     */
    public function update(Form $form)
    {
        // 获取待新增的数据
        $attributes = $form->updates();

        DB::beginTransaction();

        try {
            //  获取当前要更新的模型
            $model = (new $this->eloquentClass)::find($attributes['id']);

            $model->title = $attributes['title'];

            $model->type = $attributes['type'];

            $model->save();

            $type = $attributes['type'];

            //  用户可能会改成其他的类型, 要判断一下
            switch ($type)
            {
                case 0:
                    break;
                case 1:
                    $model->templateRule ? $model->templateRule()->update([
                        'city' => $attributes['city']
                    ]) : $model->templateRule()->create([
                        'city' => $attributes['city']
                    ]);
                    break;
                case 2:
                    $model->templateRule ? $model->templateRule()->update([
                        'city' => $attributes['city'],
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
                        'city' => $attributes['city'],
                        'extra' => $attributes['extra']
                    ]) : $model->templateRule()->create([
                        'city' => $attributes['city'],
                        'extra' => $attributes['extra']
                    ]);
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
