<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use App\Models\TestTokenModel;

class VerifyTokenService
{
    private $defaultToken;
    private $version;
    private $hash;
    private $publicApiArr;
    private $testToken;

    public function __construct(TestTokenModel $tokenModel)
    {
        $this->defaultToken = config::get('token.defaultToken');
        $this->version = config::get('token.version');
        $this->hash = config('token.hash');
        $this->publicApiArr = config::get('token.publicApiArr');
        $this->testToken = $tokenModel;
    }

    public function tokenService($request, $routes, $param, $timeNow)
    {
        try {
            // 验证请求时间
            if ($timeNow - $param['time'] > 60) {
                throw new \Exception('请求时间过长', 17);
            }
            // 验证版本号
            if ($this->version != $param['version']) {
                throw new \Exception('版本号不一致', 18);
            }
            // 判断接口（商业、公共）
            $token = $this->isSecret($request) ? $this->testToken->testmodel($guid) : $this->defaultToken;
            // 生成crypttoken
            $crypttoken = $this->getCryptToekn($token);
            $signature = md5($routes .
                $param['time'] . $param['guid'] . $param['platform'] . $param['param'] .
                $crypttoken);
            // 验证 token 是否正确
            if ($signature != $param['signature']) {
                throw new \Exception('token 验证失败', 19);
            }

            $respose = $next($request);
            return $respose;
        } catch (\Exception $e) {
            return response()->json([
                'serverTime' => time(),
                'serverNo' => $e->getCode(),
                'ResultData' => $e->getMessage()
            ]);
        }
    }
    public function isSecret($request)
    {
        // 如果路由有在公共数组中
        $action = $request->route()->getAction();
        if (
            isset($action['controller']) &&
            in_array($action['controller'], $this->publicApiArr)
        ) {
            return false;
        }
        return true;
    }

    public function getCryptToekn($token)
    {
        if (strlen($token) != 32) {
            throw new \Exception("token长度不一样", 20);
        }
        $str = $token[2] . $token[5] . $token[8];
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
}