<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductTemplateRule extends Model
{

    protected $table = 'product_template_rule';

    protected $fillable = [
        'product_template_id',
        'city',
        'default_num',
        'default_price',
        'add_num',
        'add_price',
        'extra'
    ];

    public function setCityAttribute($value)
    {
        if ($value && is_array($value)){
            $this->attributes['city'] = implode(',', $value);
        }else{
            $this->attributes['city'] = '';
        }
    }

}
