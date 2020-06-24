<?php

namespace App\Models;

/**
 * @author zhenhong~
 * @description 商品分类模型
 */

use Dcat\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use ModelTree;

    protected $table = 'categories';
}
