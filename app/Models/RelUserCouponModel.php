<?php

namespace App\Models;

use App\Services\GuidService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelUserCouponModel extends Model
{
    use SoftDeletes;

    protected $table = 'rel_user_coupon';

    protected $fillable = [
        'id','guid','created_at','updated_at','deleted_at',
        'user_id','coupon_id'
    ];

    public function createUserCoupon($res)
    {
        $guid = app(GuidService::class);
        $data = $this->firstOrCreate(
            ['guid' => $guid::create_guid()],
            [
                'user_id' => $res['user_id'],
                'coupon_id' => $res['coupon_id']
            ]
        );
        return $data;
    }

    public function updateUserCoupon($res)
    {
        $data = $this->updateOrCreate(
            ['user_id' => $res['user_id']],
            [
                'coupon_id' => $res['coupon_id'],
            ]
        );

        return $data;
    }
    public function deleteUserCoupon($res)
    {
        $model = $this->destroy($res['id']);

        return $model;
    }



}
