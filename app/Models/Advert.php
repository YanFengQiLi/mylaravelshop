<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{

    use SoftDeletes;

    protected $table = 'advert';

    public function advertType()
    {
        return $this->belongsTo(AdvertType::class,'advert_type_id','id');
    }

}
