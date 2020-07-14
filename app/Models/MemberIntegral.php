<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MemberIntegral
 *
 * @property int $id
 * @property int $member_id 用户ID
 * @property string $type 类型,add-加 sub-减
 * @property string $source 积分来源
 * @property int $num 积分数量
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIntegral newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIntegral newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIntegral query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIntegral whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIntegral whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIntegral whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIntegral whereNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIntegral whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIntegral whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MemberIntegral whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MemberIntegral extends Model
{
	
    protected $table = 'member_integral';
    

}
