<?php

namespace App\Models;

use App\Services\GuidService;
use Illuminate\Database\Eloquent\Model;

class LogUserModel extends Model
{
    protected $table = 'log_user';

    protected $fillable = [
        'id','guid','created_at','updated_at','deleted_at',
        'login_status','login_roles','login_type','list_ip','landing_time'
    ];

    public function log_user($res)
    {
        $guid = app(GuidService::class);
        $data = $this->firstOrCreate(
            ['guid' => $guid::create_guid()],
            [
                'login_status' => $res['login_status'],
                'login_roles' => $res['login_roles'],
                'login_type' => $res['login_type'],
                'list_ip' => $res['list_ip'],
                'landing_time' => $res['landing_time']
            ]
        );

        return $data['guid'];
    }
}
