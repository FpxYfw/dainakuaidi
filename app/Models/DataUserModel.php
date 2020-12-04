<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\GuidService;

class DataUserModel extends Model
{
    protected $table = 'data_user';

    protected $fillable = [
      'id','guid','created_at','updated_at','deleted_at','sex','user_roles','portrait'
    ];

    public function data_user($res)
    {
        $guid = app(GuidService::class);
        $data = $this->firstOrCreate(
            ['guid' => $guid::create_guid()],
            [
                'sex' => $res['gender'],
                'user_roles' => $roles['1 => 用户 , 2 => 骑手 , 3 => 管理员'],
                'portrait' => $res['avatarUrl']
            ]
        );

        return $data['guid'];
    }
}
