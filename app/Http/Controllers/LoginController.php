<?php

namespace App\Http\Controllers;

use App\Services\VerifyParamsService;
use App\Models\DataClientInfoModel;
use App\Services\WechatCurlService;

class LoginController extends Controller
{
    private $verifyparams;
    private $datainfo;
    private $wechat;

    function __construct(
        VerifyParamsService $verifyparams,
        DataClientInfoModel $datainfo,
        WechatCurlService $wechatcurl
    ) {
        $this->verifyparams = $verifyparams;
        $this->datainfo = $datainfo;
        $this->wechatcurl = $wechatcurl;
    }

    public function login()
    {

              // 控制器里 应该 只存放「路由动作方法」
              try {
                  
                  $data = ['code' => 200 , "data" => [] ];
                  // 设置 code 必填的规则
                  $rule = ["code" => ["required" => true]];
                  // 获取的 code
                  $code = $_GET['code'];
                  // 获取所有 get 数据
                  $whole = $_GET;
                  
                // 验证 code 必填
                $param = $this->verifyparams
                -> init($_GET, $rule)
                -> verifyRequired()
                -> filter()
                -> updateDataType()
                -> param;
                
                // 使用 code 换取 session_key openid
                $res = $this->wechatcurl -> code2session($code);
                
                // 保存数据
                $data['data'] = $this->datainfo->create_query($res,$whole);
                
                return response()->json($data);
            } catch (\Exception $e) {
                echo $e->getCode();
                echo $e->getMessage();
            }
        }
}


