<?php

namespace App\Admin\Repositories;

use App\Models\GroupGood as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class GroupGood extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
