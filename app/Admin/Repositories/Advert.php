<?php

namespace App\Admin\Repositories;

use App\Models\Advert as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Advert extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
