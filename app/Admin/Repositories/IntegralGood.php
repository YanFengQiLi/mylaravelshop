<?php

namespace App\Admin\Repositories;

use App\Models\IntegralGood as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class IntegralGood extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
