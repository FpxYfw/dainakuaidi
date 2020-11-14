<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PHP\wxBizDataCrypt;
use App\Services\VerifyParamsService;
use App\Services\WechatCurlService;
use App\Services\GuidService;
use App\Models\DataUserLoginModel;

class LoginController extends Controller
{
    private $VerifyParams;
    private $WechatCurl;
    private  $GuidService;
    private $DataUserLogin;
    public function __construct
    (
        VerifyParamsService $VerifyParams,
        WechatCurlService $WechatCurl,
        GuidService $GuidService,
        DataUserLoginModel $DataUserLogin

    )
    {
        $this->VerifyParams = $VerifyParams;
        $this->WechatCurl = $WechatCurl;
        $this->GuidService = $GuidService;
        $this->DataUserLogin = $DataUserLogin;
    }

    public function login()
    {
        // 控制器里 应该 只存放「路由动作方法」
        try {
            // 获取的 code
            $code = $_GET['code'];
            // 获取的 rawData
            $rawData = $_GET['rawData'];
            // 获取的 signature
            $signature = $_GET['signature'];
            // 获取的 iv
            $iv = $_GET['iv'];
            // 获取的 encryptedData
            $encryptedData = $_GET['encryptedData'];
            // 设置 code 必填的规则
            $rule = [
                "code" => ["required" => true]
            ];

            // 验证必填
            $param = $this->VerifyParams
                -> init($_GET, $rule)
                -> verifyRequired()
                -> filter()
                -> updateDataType()
                -> param;

            // 使用 code 换取 session_key openid
            $res = $this->WechatCurl -> code2session($code);

            $openid = $res['openid'];
            $session_key = $res['session_key'];

            // 解密成功 0，解密失败返回对应的错误码
            $appid = 'wx836c6db84021a553';
            $pc = new wxBizDataCrypt($appid, $session_key);
            $errCode = $pc->decryptData($encryptedData, $iv, $data);
            $data = json_decode($data, true);

            // 存入数据库
            $model = DataUserLoginModel::firstOrCreate(
                ["openid" => $res["openid"]],
                [
                    "guid" => $this->GuidService::create_guid(),
                    "session_key" => $res["session_key"],
                    "nickName" => $data["nickName"],
                    "city" => $data["city"],
                    "province" => $data["province"],
                    "country" => $data["country"],
                    "gender" => $data["gender"],
                    "avatarUrl" => $data["avatarUrl"]
                ]
            );

            if ($model->session_key != $res["session_key"]) {
                $model->session_key = $res["session_key"];
            }

            $openid = $model->openid;
            $model->save();
            // 从数据库中提取数据
            $users = $this->DataUserLogin -> get();
            return $users;
        } catch (\Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }
}
