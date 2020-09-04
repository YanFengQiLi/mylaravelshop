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

    protected $fillable = ['member_id', 'type', 'source', 'num'];

    //  签到
    const SIGN = 'sign';
    //  下单评价
    const ORDER_COMMENT = 'comment';
    //  下单积分抵现
    const ORDER_SPEND = 'order';
    //  积分商品兑换
    const SPEND = 'spend';

    //  积分来源
    const SOURCE = [
        self::SIGN => '签到',
        self::ORDER_COMMENT => '下单评价',
        self::ORDER_SPEND => '签到',
        self::SPEND => '积分商品兑换'
    ];

    /**
     * 获取积分类型
     * @param $source
     * @return string
     */
    public static function getType($source)
    {
        $add = [self::SIGN, self::ORDER_COMMENT];

        if (in_array($source, $add)) {
            return 'add';
        } else {
            return 'sub';
        }
    }

    public function member()
    {
        return $this->belongsTo(Member::class,'member_id', 'id');
    }
}
