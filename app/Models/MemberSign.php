<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberSign extends Model
{
    protected $table = 'member_sign';

    public $timestamps = false;

    protected $fillable = ['member_id', 'sign_date', 'number'];
}
