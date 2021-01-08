<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\GuidService;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DataUserModel extends Model
{
    use SoftDeletes;

    protected $table = 'data_user';

    protected $fillable = [
        'id','guid','created_at','updated_at','deleted_at','sex','user_roles','portrait',
        'user_status','coupon_receive','coupon_use','coupon_expire','user_name'
    ];

    public function createUser($res)
    {
        $guid = app(GuidService::class);
        $data = $this->firstOrCreate(
            ['guid' => $guid::create_guid()],
            [
                'sex' => $res['gender'],
                'user_roles' => $res['user_roles'],
                'portrait' => $res['portrait'],
                'user_status' => $res['user_status'],
                'coupon_receive' => $res['coupon_receive'],
                'coupon_use' => $res['coupon_use'],
                'coupon_expire' => $res['coupon_expire'],
                'user_name' => $res['user_name']
            ]
        );

        return $data;
    }
    public function updateUser($res)
    {
        $data = $this->updateOrCreate(
            ['sex' => $res['gender']],
            [
                'user_roles' => $res['user_roles'],
                'portrait' => $res['portrait'],
                'user_status' => $res['user_status'],
                'coupon_receive' => $res['coupon_receive'],
                'coupon_use' => $res['coupon_use'],
                'coupon_expire' => $res['coupon_expire'],
                'user_name' => $res['user_name']
            ]
        );

        return $data;
    }

    public function deleteUser($res)
    {
        $model = $this->destroy($res['id']);

        return $model;
    }

    public function selectUser($res)
    {
        $data = DB::table('data_user')->where('id', '=', $res['user_id'])->first();
        return $data;
    }
}
