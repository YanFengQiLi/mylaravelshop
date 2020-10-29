<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MemberSign
 *
 * @property int $id
 * @property int $member_id 用户ID
 * @property string $sign_date 签到日期
 * @property int $number 获得积分数量
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberSign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberSign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberSign query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberSign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberSign whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberSign whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberSign whereSignDate($value)
 * @mixin \Eloquent
 */
class MemberSign extends Model
{
    protected $table = 'member_sign';

    public $timestamps = false;

    protected $fillable = ['member_id', 'sign_date', 'number'];
}
