<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestTokenModel;

class TestController extends Controller
{
   public function test()
   {
//       echo "我是你爹";
       $testToken = app(TestTokenModel::class);
       $res = $testToken->testtoken();
       var_dump($res->token);
   }
}
