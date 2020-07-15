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

    public function toTree()
    {
        $tree = parent::toTree();

        return $this->getDeep($tree);
    }

    //  给树形结构加层级深度
    protected function getDeep(&$tree, $deep = 1)
    {
        foreach ($tree as $k => &$row) {
            $row['deep'] = $deep;

            if(isset($row['children'])){
                $this->getDeep($row['children'], $deep + 1);
            }
        }

        return $tree;
    }
}
