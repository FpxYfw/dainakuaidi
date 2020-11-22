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
        'session_key'
    ];  
    


    public function create_query($res)
    {
        $guid = app(GuidService::class);
        $model = $this->firstOrCreate(
            ['openid' => $res['openid']],
            [
                'guid' => $guid::create_guid(),
                'session_key' => $res['session_key'],

            ]
        );

        if ($model->session_key != $res['session_key']) {
            $model->session_key = $res['session_key'];
        }

        $model->save();

        return $model;
    }
}
