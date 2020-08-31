<?php

namespace App\Admin\Repositories;

use App\Models\Problem as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Problem extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
