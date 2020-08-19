<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\Member
 *
 * @property int $id
 * @property string $account 账号-手机号
 * @property string $email 邮箱
 * @property string $password 密码
 * @property string $user_name 姓名
 * @property string $nick_name 昵称
 * @property int $sex 性别 1-男 2-女
 * @property int $photo 头像
 * @property int $status 状态 0-冻结 1-正常
 * @property int $integral 积分
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereIntegral($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereNickName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereSex($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member whereUserName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member withoutTrashed()
 * @mixin \Eloquent
 */
class Member extends Authenticatable implements JWTSubject
{

    use SoftDeletes;
    use Notifiable;

    protected $fillable = [
        'account', 'email', 'password', 'user_name', 'nick_name', 'photo'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function createMemberByData($data)
    {
        return self::create($data) ? true : false;
    }

}
