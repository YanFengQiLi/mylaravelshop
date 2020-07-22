<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function sku()
    {
        return $this->hasMany(ProductSku::class,'product_id','id');
    }

    public function setPicturesAttribute($value)
    {
        $this->attributes['pictures'] = json_encode($value);
    }

    public function getImage()
    {
        if (Str::contains($this->image, '//')) {
            return $this->image;
        }

        return Storage::disk('admin')->url($this->image);
    }
}
