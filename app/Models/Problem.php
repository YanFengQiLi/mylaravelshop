<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Problem
 *
 * @property int $id
 * @property string $title 问题名称
 * @property string $answer 问题答案
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Problem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Problem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Problem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Problem withoutTrashed()
 * @mixin \Eloquent
 */
class Problem extends Model
{
	
    use SoftDeletes;

    protected $table = 'problem';
    
}
