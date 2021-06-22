<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberFavoriteProduct extends Model
{
    protected $table = 'member_favorite_products';

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id','id');
    }

    /**
     * @param array $data
     * @return MemberFavoriteProduct|Model
     * 创建商品收藏（关注）
     */
    public function insertMemberFavoriteProduct(array $data)
    {
        return self::create($data);
    }

}
