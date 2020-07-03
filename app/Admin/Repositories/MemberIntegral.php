<?php

namespace App\Admin\Repositories;

use Dcat\Admin\Repositories\EloquentRepository;
use App\Models\MemberIntegral as MemberIntegralModel;

class MemberIntegral extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = MemberIntegralModel::class;
}
