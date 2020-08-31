<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
	
    use SoftDeletes;

    protected $table = 'problem';
    
}
