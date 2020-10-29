<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MemberSeriesSignRecord
 *
 * @property int $id
 * @property int $member_id 用户ID
 * @property int $sign_day 连续签到天数
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberSeriesSignRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberSeriesSignRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberSeriesSignRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberSeriesSignRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberSeriesSignRecord whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberSeriesSignRecord whereSignDay($value)
 * @mixin \Eloquent
 */
class MemberSeriesSignRecord extends Model
{
    protected $table = 'member_series_sign_record';

    public $timestamps = false;

    protected $fillable = ['member_id', 'sign_day'];
}
