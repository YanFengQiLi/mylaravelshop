<?php

namespace App\Admin\Repositories;

use App\Models\ProductsService as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class ProductsService extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
