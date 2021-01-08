<?php

namespace App\Services;

class UseCouponService
{
    public function verifyCoupon($coupon_info,$user_info,$order_info)
    {
        try {
            // 判断优惠券是否存在
            if (is_null($user_info)) {
                throw new \Exception('优惠券不存在', 30);
            }
            // 判断优惠券时间
            if (time() < strtotime($coupon_info->start_time)) {
                throw new \Exception('活动未开始', 31);
            }
            if (time() > strtotime($coupon_info->end_time)) {
                throw new \Exception('活动已经结束', 32);
            }
            // 判断订单的金额是否满足优惠券使用底线
            if ($order_info->money !== $coupon_info->full_money) {
                throw new \Exception('优惠券不能满足订单需求', 33);
            }
            // 判断优惠券是否使用过
            if ($user_info->coupon_use == 1) {
                throw new \Exception('该用户已使用过优惠券，不可重复使用', 35);
            }

            // 判断订单是否存在
            if (is_null($order_info)) {
                throw new \Exception('订单不存在',36);
            }

            return true;
        } catch (\Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }
}