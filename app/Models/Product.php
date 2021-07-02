<?php

namespace App\Models;
use App\Events\ProductUpdated;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $title 商品名称
 * @property string $description 商品描述
 * @property string|null $image 商品封面图
 * @property string|null $pictures 商品轮播图
 * @property int $on_sale 上架状态
 * @property float $rating 商品评分
 * @property int $sold_count 销量
 * @property int $review_count 评论数
 * @property float $price 价格
 * @property int $product_template_id 运费模板ID
 * @property int|null $grand_id 顶级分类ID
 * @property int|null $parent_id 父级分类ID
 * @property int|null $category_id 子级ID
 * @property string|null $concat_id 以逗号连接三级分类ID
 * @property int $is_join_vip 是否参与 vip 年卡活动 0-否 1-是
 * @property int $is_join_integral 是否参与下单得积分活动 0-否 1-是
 * @property string|null $service 商品服务
 * @property float|null $lower_price 降价金额
 * @property int $is_lower 是否降价 0-否 1-是
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProductTemplate $productTemplate
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductSku[] $sku
 * @property-read int|null $sku_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereConcatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereGrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereIsJoinIntegral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereIsJoinVip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereIsLower($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereLowerPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereOnSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePictures($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereProductTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereReviewCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSoldCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    protected $fillable = ['is_lower', 'lower_price'];

    public function sku()
    {
        return $this->hasMany(ProductSku::class,'product_id','id');
    }

    public function productTemplate()
    {
        return $this->belongsTo(ProductTemplate::class,'product_template_id','id')->select('id', 'title', 'type');
    }

    public function setPicturesAttribute($value)
    {
        $this->attributes['pictures'] = json_encode($value);
    }

    public function getPicturesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getImage()
    {
        if (Str::contains($this->image, '//')) {
            return $this->image;
        }

        return Storage::disk('admin')->url($this->image);
    }

    protected $dispatchesEvents = [
        'updated' => ProductUpdated::class
    ];
}
