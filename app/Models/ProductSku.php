<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

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
