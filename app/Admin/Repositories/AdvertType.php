<?php

namespace App\Admin\Repositories;

use App\Models\AdvertType as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AdvertType extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
