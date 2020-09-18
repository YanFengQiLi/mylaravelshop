<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class GroupGood extends Model
{

    protected $table = 'group_goods';

    public function getImagesAttribute($value)
    {
        return json_decode($value, true);
    }

}
