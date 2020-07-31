<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class AdvertType extends Model
{

    use SoftDeletes;

    protected $table = 'advert_type';

}
