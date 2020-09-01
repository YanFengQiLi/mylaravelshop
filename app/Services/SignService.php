<?php


namespace App\Services;
use App\Models\Member;
use App\Models\MemberIntegral;
use App\Models\MemberSeriesSignRecord;
use App\Models\MemberSign;
use App\Models\Website;
use Illuminate\Support\Facades\DB;

class SignService
{
    //  签到规则
    public $rule;
    //  当前用户
    public $memberId;
    //  今天
    public $today;

    public function __construct()
    {
        $this->rule = $this->getSignRule();

        $member = request()->attributes->get('member');

        $this->memberId = $member->id;

        $this->today = date('Y-m-d');
    }

    /**
     * 查询用户,当月的签到记录
     * @param $date
     * @return \Illuminate\Support\Collection
     */
    public function get($date)
    {
        return MemberSign::where('member_id', $this->memberId)
            ->whereRaw("DATE_FORMAT(sign_date, '%Y-%m') = $date")
            ->orderBy('sign_date', 'ASC')
            ->get('sign_date');
    }

    /**
     * 获取签到规则
     * @return mixed|string
     */
    public function getSignRule()
    {
        $key = Website::where('key_name', 'sign_rule')->value('key_value');

        return empty($key) ? 'add' : $key;
    }

    /**
     * 获取本次签到,奖励积分
     */
    public function getSignNumberByRule()
    {
        if ($this->rule == 'add') {
            $number = $this->getAddNumber();
        } else {
            $number = $this->getFixNumber();
        }

        return $number;
    }

    /**
     * 获取累计积分
     * @return int|mixed
     */
    private function getAddNumber()
    {
        $bool = $this->getYesterdaySign();

        if ($bool === true) {
            $number = MemberSeriesSignRecord::where('member_id', $this->memberId)->value('sign_day');

            return $number >= 7 ? 7 : $number;
        }

        return 1;
    }

    /**
     * 获取固定积分
     * @return int
     */
    private function getFixNumber()
    {
        $number = Website::where('key_name', 'fix_number')->value('key_value');

        return empty($number) ? 1 : intval($number);
    }

    /**
     * 查询用户昨天是否签到
     * @return bool
     */
    private function getYesterdaySign()
    {
        $id = MemberSign::where('member_id', $this->memberId)
            ->whereDate('sign_date', date('Y-m-d', strtotime("-1 day")))
            ->value('id');

        return empty($id) ? false : true;
    }

    /**
     * 校验用户,是否有连续签到记录
     * @return bool
     */
    public function checkMemberSeriesSignRecordExists()
    {
        return MemberSeriesSignRecord::where('member_id', $this->memberId)->exists();
    }

    /**
     * 签到
     * @return bool
     * @throws \Exception
     */
    public function sign()
    {
        DB::beginTransaction();

        try {
            //  创建/更新 连续签到记录
            if ($this->checkMemberSeriesSignRecordExists()) {
                MemberSeriesSignRecord::where('member_id', $this->memberId)->increment('sign_day',1);
            } else {
                MemberSeriesSignRecord::create([
                    'member_id' => $this->memberId,
                    'sign_day' => 1
                ]);
            }

            $number = $this->getSignNumberByRule();

            //  创建用户每天签到记录
            MemberSign::create([
                'member_id' => $this->memberId,
                'sign_date' => $this->today,
                'number' => $number
            ]);

            //  创建用户积分日志
            MemberIntegral::create([
                'member_id' => $this->memberId,
                'type' => MemberIntegral::getType('sign'),
                'source' => 'sign',
                'num' => $number
            ]);

            //  累加用户积分
            Member::where('id', $this->memberId)->increment('integral', $number);

            DB::commit();
            return true;
        }catch (\Exception $exception){
            DB::rollBack();
            return false;
        }
    }

    /**
     * 校验用户,当天是否已经签到
     * @return bool
     */
    public function checkTodaySign()
    {
        $id = MemberSign::where('member_id', $this->memberId)
            ->whereDate('sign_date', $this->today)
            ->value('id');

        return empty($id) ? true : false;
    }
}
