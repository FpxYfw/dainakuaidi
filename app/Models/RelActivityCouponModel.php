<?php

namespace App\Models;

use App\Services\GuidService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RelActivityCouponModel extends Model
{
    use SoftDeletes;

    protected $table = 'rel_act_coupon';

    protected $fillable = [
        'id','guid','created_at','updated_at','deleted_at',
        'act_id','coupon_id'
    ];

    public function createActCoupon($res)
    {
        $guid = app(GuidService::class);
        $data = $this->firstOrCreate(
            ['guid' => $guid::create_guid()],
            [
                'act_id' => $res['act_id'],
                'coupon_id' => $res['coupon_id']
            ]
        );

        return $data;
    }

    public function updateActCoupon($res)
    {
        $data = $this->updateOrCreate(
            ['coupon_id' => $res['coupon_id']],
            [
                'act_id' => $res['act_id']
            ]
        );

        return $data;
    }

    public function deleteActCoupon($res)
    {
        $model = $this->destroy($res['id']);

        return $model;
    }
}
