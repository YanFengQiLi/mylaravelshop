<?php
namespace App\Services;

use App\Models\Member;
use Illuminate\Support\Facades\Schema;

class MemberService {
    protected $member;

    public function __construct(Member $member)
    {
        $this->member = $member;
    }

    /**
     * @return array
     * @author zhenhong~
     * 获取 member 表字段
     */
    protected function getMemberDbAttributes()
    {
        return Schema::getColumnListing('db_members');
    }

    /**
     * @param string $column
     * @return bool
     * @author zhenhong~
     * 判断 字段 是否属于 member
     */
    protected function checkIsMemberColumn(string $column)
    {
        $columns = $this->getMemberDbAttributes();

        return in_array($column, $columns) ? true : false;
    }

    /**
     * @param array $where
     * @param string $column
     * @param string $data
     * @return bool
     * @author zhenhong~
     * 更新 member 基础字段 （生日、性别等）
     */
    public function updateBaseMemberColumn(array $where, string $column, string $data)
    {
        $model = $this->member::query()->where($where)->first();

        $model->$column = $data;

        $bool = $model->save();

        return $bool;
    }
}
