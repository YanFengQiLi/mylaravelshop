<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdminMessage;

class TestController extends Controller
{
    public function createAdminMessage()
    {
      return AdminMessage::create([
          'type' => 1,
          'title' => '222333',
          'extra' => '121212'
      ]);
    }
}
