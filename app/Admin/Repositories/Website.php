<?php

namespace App\Admin\Repositories;

use App\Models\Website as Model;
use Dcat\Admin\Form;
use Dcat\Admin\Repositories\EloquentRepository;
use Illuminate\Support\Facades\DB;

class Website extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

    public function store(Form $form)
    {
        $attributes = $form->updates();

        DB::beginTransaction();

        try {
            foreach ($attributes as $config => $value) {
                if (Model::where('key_name', $config)->value('key_value')) {
                    Model::where('key_name', $config)->update([
                        'key_value' => $value
                    ]);
                } else {
                    Model::create([
                        'key_name' => $config,
                        'key_value' => $value,
                    ]);
                }
            }

            DB::commit();
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }
    }
}
