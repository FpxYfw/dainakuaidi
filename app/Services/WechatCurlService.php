<?php

namespace App\Services;

class WechatCurlService
{
    private static $appid = 'wx836c6db84021a553';
    private static $secret = '5076daf54fee387eb02477ed047e95b0';
    // 设置静态属性
    private static $Curl;

    public function __construct
    (
        CurlService $curl
    )
    {
        // 把 $curl 的值赋予给这个静态属性
        self::$Curl = $curl;
    }

    public static function code2Session($code)
    {
        $data = self::$Curl->init(
         /**
          * 传递 init 的值
          * $url
          * $method
          * $params
         */
            'https://api.weixin.qq.com/sns/jscode2session',
            'get',
            [
                'appid' => 'wx836c6db84021a553',
                'secret' => '5076daf54fee387eb02477ed047e95b0',
                'js_code' => $code,
                'grant_type' => 'authorization_code'
            ]
        )->judge('get');

        return $data;
    }
}