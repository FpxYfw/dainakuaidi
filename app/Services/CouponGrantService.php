<?php

namespace App\Services;

use App\Models\DataCouponModel;
use App\Models\DataUserModel;
use App\Models\RelUserCouponModel;
use Illuminate\Http\Request;

class CouponGrantService
{
    protected $coupon;
    protected $user;
    public function __construct
    (
        DataCouponModel $coupon,
        DataUserModel $user
    )
    {
        $this->coupon = $coupon;
        $this->user = $user;
    }

    public function receiveCoupon($res)
    {
        try {
            // 获取优惠券信息
            $coupon_info = $this->coupon->selectCoupon($res);
            $user_info = $this->user->selectUser($res);
            // 判断用户是否存在
            if (is_null($user_info)) {
                throw new \Exception('该用户不存在', 001);
            }
            // 判断优惠券是否存在
            if (is_null($coupon_info)) {
                throw new \Exception('优惠券不存在', 002);
            }
            // 给用户发放优惠券
            $this->useType($user_info,$coupon_info,$role = 0);
            return "发放成功";
        } catch (\Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }

    protected function useType($user_info, $coupon_info, $role = 0)
    {
        $relusercoupon = app(RelUserCouponModel::class);
        $res = [
            'user_id' => $user_info->id,
            'coupon_id' => $coupon_info->id
        ];
        if ($role == 0) {
            $model = $relusercoupon->createUserCoupon($res);
        }

        return true;
    }

}