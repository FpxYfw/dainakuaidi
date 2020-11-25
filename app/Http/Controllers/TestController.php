<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataClientLoginModel;

class TestController extends Controller
{
   public function test()
   {
//       echo "我是你爹";
       $testToken = app(DataClientLoginModel::class);
       $res = $testToken->testtoken();
       var_dump($res->token);
   }
}
