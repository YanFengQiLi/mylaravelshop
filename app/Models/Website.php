<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Website
 *
 * @property int $id
 * @property string $key_name 配置标识
 * @property string|null $key_value 标识值
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Website newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Website newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Website query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Website whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Website whereKeyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Website whereKeyValue($value)
 * @mixin \Eloquent
 */
class Website extends Model
{
    protected $table = 'website';

    public $timestamps = false;

    protected $fillable = ['key_name', 'key_value'];

    public function getWebSiteConfig()
    {
       return self::all()->pluck('key_value', 'key_name')->toArray();
    }

}
