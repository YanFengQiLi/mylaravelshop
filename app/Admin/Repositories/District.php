<?php

namespace App\Admin\Repositories;

use App\Models\District as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class District extends EloquentRepository
{

    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;

}
