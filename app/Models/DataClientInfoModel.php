<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Services\GuidService;

class DataClientInfoModel extends BaseModel
{
    protected $table = 'data_user_login';

    protected $fillable = [
        'id',
        'guid',
        'openid',
        'session_key',
        'nickName',
        'city',
        'province',
        'country',
        'avatarUrl',
        'gender',
        'language'
    ];  
    


    public function create_query($res,$whole)
    {
        $rawData = json_decode($whole['rawData'], true);
        $guid = app(GuidService::class);
        $model = $this->firstOrCreate(
            ['openid' => $res['openid']],
            [
                'guid' => $guid::create_guid(),
                'session_key' => $res['session_key'],
                'nickName' => $rawData['nickName'],
                'city' => $rawData['city'],
                'province' => $rawData['province'],
                'country' => $rawData['country'],
                'avatarUrl' => $rawData['avatarUrl'],
                'gender' => $rawData['gender'],
                'language' => $rawData['language'],

            ]
        );

        if ($model->session_key != $res['session_key']) {
            $model->session_key = $res['session_key'];
        }

        $model->save();

        return $model;
    }
}
