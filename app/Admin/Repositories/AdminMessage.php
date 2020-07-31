<?php

namespace App\Admin\Repositories;

use App\Models\AdminMessage as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class AdminMessage extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
