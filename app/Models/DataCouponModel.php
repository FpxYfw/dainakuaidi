<?php

namespace App\Models;

use App\Services\GuidService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DataCouponModel extends Model
{
    use SoftDeletes;

    protected $table = 'data_coupon';

    protected $fillable = [
        'id','guid','created_at','updated_at','deleted_at',
        'coupon_name','start_time','end_time','coupon_type','money','full_money','coupon_status','coupon_number','coupon_total'
    ];

    public function createCoupon($res)
    {
        $guid = app(GuidService::class);
        $data = $this->firstOrCreate(
            ['guid' => $guid::create_guid()],
            [
                'coupon_name' => $res['coupon_name'],
                'start_time' => $res['start_time'],
                'end_time' => $res['end_time'],
                'coupon_type' => $res['coupon_type'],
                'money' => $res['money'],
                'full_money' => $res['full_money'],
                'coupon_status' => $res['coupon_status'],
                'coupon_number' => $res['coupon_number'],
                'coupon_total' => $res['coupon_total']
            ]
        );

        return $data;
    }
    public function updateCoupon($res)
    {
        $guid = app(GuidService::class);
        $data = $this->updateOrCreate(
            [ 'coupon_name' => $res['coupon_name']],
            [
                'start_time' => $res['start_time'],
                'end_time' => $res['end_time'],
                'coupon_type' => $res['coupon_type'],
                'money' => $res['money'],
                'full_money' => $res['full_money'],
                'coupon_status' => $res['coupon_status'],
                'coupon_number' => $res['coupon_number'],
                'coupon_total' => $res['coupon_total']
            ]
        );

        return $data;
    }

    public function deleteCoupon($res)
    {
        $model = $this->destroy($res['id']);

        return $model;
    }

    public function selectCoupon($res)
    {
        $data = DB::table('data_coupon')->where('id', '=', $res['coupon_id'])->first();
        return $data;
    }
}
