<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SignService;
use Illuminate\Http\Request;

class SignController extends Controller
{
    protected $sign;

    public function __construct(SignService $service)
    {
        $this->sign = $service;
    }

    public function getMemberSignList()
    {

    }

    public function createSignRecord()
    {

    }
}
