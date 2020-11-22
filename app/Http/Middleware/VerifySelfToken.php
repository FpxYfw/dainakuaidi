<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\TestTokenModel;
use Illuminate\Support\Facades\Request;

class VerifySelfToken
{
    // 测试代码
    //            http://jrjqq/login?time=1606059956&version=v1&guid=27B6857E-AA92-21CF-2114-307C0C8C1ED&platform=-wx&param=123&code=023cqf0w3frumV2Goy1w3xkqke4cqf06&signature=74d26abc4b53e96d3c2a3ae72dafe89c
    private $defaultToken = "0cc175b9c0f1b6a831c399e269772661";
    private $version = 'v1';
    private $hash = [
        [2,3,1,17,22,28],
        [0,8,19,23,30,31],
        [9,15,31,1,5,7],
        [11,21,31,10,12,16],
        [30,1,12,18,25,28],
        [8,14,17,27,1,4],
        [2,8,13,19,20,24],
        [5,16,20,29,18,22]
    ];
    private $publicApiArr = [
        'App\Http\Controller\LoginController@login'
    ];

    public function handle($request, Closure $next)
    {
        try {
            $param = $request->all();
            $timeNow = time();
            $route = $request->path();
            // 请求时间验证
            if ($timeNow - $param['time'] > 60*24*1000) {
                throw new \Exception('请求时间过长',17);
            }

            // 版本号验证
            if ($this->version != $param['version']) {
                throw new \Exception('版本不一致', 18);
            }
            // 判断是公共接口还是商业接口
            if ($this->isSecret($request)) {
                // 判断是否第一次登录 ，不是则从数据库中取出 token 并判断过期时间
                $model = app(TestTokenModel::class)->TokenSelect();
                // 判断 token 的有效期
                if ($param['time'] < $model['token_time']) {
                    throw new \Exception('请重新登录', 22);
                }
                $cryptToken = $model['token'];
            } else {
                // 公共接口
                $cryptToken = $this->defaultToken;
            }

            // token 验证
            $cryptToken = $this->getCryptToken($this->defaultToken);
            $temp = md5(
                $route .
                $param['time'] .$param["guid"] . $param["platform"] . $param["param"] .
                $cryptToken
            );
            if ($temp != $param['signature']) {
                return response()->json([
                    "serverTime" => $timeNow,
                    "serverNo" => 5,
                    "ResultData" => "签名错误"
                ]);
            }
            return $next($request);
        } catch (\Exception $e) {
            return response()->json([
                'serverTime' => time(),
                'serverNo' => $e->getCode(),
                'ResultData' => $e->getMessage()
            ]);
        }
    }
    private function getCryptToken($defaultToken)
    {
        if (strlen($defaultToken) != 32) {
            throw new \Exception('token 错误', 19);
        }
        $str = $defaultToken[2] . $defaultToken[5] . $defaultToken[8];
        $tenstr = hexdec($str);
        $quyu = $tenstr % 8;
        $hashMuban = $this->hash[$quyu];
        $cryptToken = '';
        foreach ($hashMuban as $key => $value) {
            for ($i = 0; $i <= 0; $i++) {
                $cryptToken .= $defaultToken[$value];
            }
        }
        return $cryptToken;
    }
    private function isSecret($request)
    {
        $action = $request->route()->getAction();
        if (
            isset($action["controller"]) &&
            in_array($action["controller"], $this->publicApiArr)
        ) {
            return false;
        }
        return true;
    }
}