<?php

namespace App\Admin\Repositories;

use App\Models\IntegralGoodsOrder as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class IntegralGoodsOrder extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
