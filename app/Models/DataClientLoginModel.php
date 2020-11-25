<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\GuidService;

class DataClientLoginModel extends BaseModel
{
    private $table = 'test_token';

    private  $fillable = [
        'id','client_id','created_at','updated_at','deleted_at','token','token_time'
    ];
    public function tokenmodel($guid)
    {
        $uuid = app(GuidService::class);

        if (!isset($guid)) {
            // 创建
            $this->create_query($guid,$uuid);
        } else {
            // 更新
            $this->update_query($guid, $uuid);
        }
    }
    protected function create_query($guid, $uuid)
    {

        $data = $this->firstOrCreate(
            ['token' => $uuid::create_guid()],
            [
                'token_time' => time() + 300,
                'client_id' => $guid
            ]
        );
        if ($data->client_id != $guid) {
            $data->client_id = $guid;
        }
        $data->save();

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

    protected function update_query($guid, $uuid)
    {
        $data = $this->updateOrCreate(
            ['token' => $uuid::create_guid()],
            [
                'token_time' => time() + 300,
                'client_id' => $guid
            ]
        );

        return $data->token;
    }

}
