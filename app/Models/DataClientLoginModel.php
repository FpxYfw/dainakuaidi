<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\GuidService;

class DataClientLoginModel extends Model
{
    public $table = "data_token";

    //设置登录字段信息
    public $fillable = [
        "id",
        "guid",
        "created_at",
        "updated_at",
        "deleted_at",
        "token_time",
        "client_guid",
        "token"
    ];

    //新用户首次登录，创建一个新的用户
    public function dataClintLoginInfo($guid)
    {
        $token = app(GuidService::class)->create_guid();

        $time_later = time() + 300;

        $this->create([
            "token" => $token,
            "token_time" => $time_later,
            "client_guid" => $guid,
        ]);
        return $token;
    }

    //根据用户guid，查询用户token过期时间和token
    public function clientTokenSelect($guid)
    {
        $data = $this->where('client_guid',"=",$guid)->first();
        //判断是否为空
        if (empty($data)) {
            throw new \Exception("数据为空值", 21);
        }
        //判断过期时间
        if (time() > $data->token_time) {
            throw new \Exception("token已过期", 22);
        }
        return $data->token;
    }

    //根据用户guid，更新token过期时间和token
    public function updataToken($guid)
    {
        $token = app(GuidService::class)->getGuid();
        $this->where('client_guid',$guid)->update([
            'token_time' => time() + 300,
            'token' => $token,
        ]);
        return $token;
    }
}
