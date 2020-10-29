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
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Member status()
 */
class Member extends Authenticatable implements JWTSubject
{

    use SoftDeletes;
    use Notifiable;

    protected $fillable = [
        'account', 'email', 'password', 'user_name', 'nick_name', 'photo'
    ];

    protected $hidden = ['password'];

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

    public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }

    /**
     * 根据条件查询用户
     * @param array $data
     * @param array $column
     * @return Member|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function getMemberInfoByData(array $data, $column = ['*'])
    {
        $query = self::query()->status();

        if (isset($data['id'])) {
            $query = $query->where('id', $data['id']);
        }

        if (isset($data['email'])) {
            $query = $query->where('email', $data['email']);
        }

        $query = $query->select($column)->first();

        return $query ? $query->makeHidden(['created_at', 'updated_at', 'deleted_at']) : null;
    }

    /**
     * 统计新用户
     * @param string $condition
     * @return int
     */
    public function countNewMember($condition = 'day')
    {
        switch ($condition) {
            case 'month':
                $date = date('Y-m');
                $where = "DATE_FORMAT('created_at', '%Y-%m')";
                break;
            case 'year':
                $date = date('Y');
                $where = "DATE_FORMAT('created_at', '%Y')";
                break;
            default :
                $date = date('Y-m-d');
                $where = "DATE_FORMAT('created_at', '%Y-%m-%d')";
                break;
        }

        return self::query()->whereRaw("$where = $date")->count();
    }

}
