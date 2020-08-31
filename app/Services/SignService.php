<?php


namespace App\Services;
use App\Models\MemberSign;

class SignService
{
    public function get($memberId,$date)
    {
        return MemberSign::whereIn('sign_date', $date);
    }

    public function count()
    {

    }

    public function sign()
    {

    }
}
