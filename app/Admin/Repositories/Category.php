<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Contracts\TreeRepository;
use Dcat\Admin\Repositories\EloquentRepository;
use App\Models\Category as CategoryModel;

class Category extends EloquentRepository implements TreeRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = CategoryModel::class;

}
