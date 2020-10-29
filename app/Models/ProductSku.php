<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductSku
 *
 * @property int $id
 * @property string $title sku名称
 * @property string $description sku描述
 * @property float $price sku价格
 * @property int $stock sku库存
 * @property int $product_id 商品ID
 * @property string|null $img sku图片
 * @property string|null $img_icon sku小图片
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductSku newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductSku newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductSku query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductSku whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductSku whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductSku whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductSku whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductSku whereImgIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductSku wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductSku whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductSku whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductSku whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProductSku whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductSku extends Model
{

    protected $table = 'product_sku';

    protected $fillable = [
        'title', 'description', 'price', 'stock', 'product_id', 'img', 'img_icon'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

}
