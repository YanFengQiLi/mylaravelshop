<?php

namespace App\Admin\Repositories;

use App\Models\ProductTemplate as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class ProductTemplate extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
