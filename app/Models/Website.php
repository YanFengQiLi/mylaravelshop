<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

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
