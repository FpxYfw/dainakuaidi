<?php

namespace App\Http\Controllers;

use App\Models\DataCouponModel;
use App\Models\DataOrderModel;
use App\Models\DataUserModel;
use App\Services\CouponGrantService;
use App\Services\UseCouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected $user;
    protected $coupon;
    protected $use;
    protected $grant;
    protected $order;
    public function __construct
    (
        DataUserModel $user,
        DataCouponModel $coupon,
        UseCouponService $use,
        CouponGrantService $grant,
        DataOrderModel $order
    )
    {
        $this->user = $user;
        $this->coupon = $coupon;
        $this->use = $use;
        $this->grant = $grant;
        $this->order = $order;
    }

    public function add(Request $request)
    {
        try {
            $res = $request->all();
            $data = $this->coupon->createCoupon($res);
            return response()->json($data);
        } catch (\Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }
    public function edit(Request $request)
    {
        try {
            $res = $request->all();
            $data = $this->coupon->updateCoupon($res);
            return response()->json($data);
        } catch (\Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }

    public function del(Request $request)
    {
        try {
            $res = $request->all();
            $data = $this->coupon->deleteCoupon($res);
            return response()->json($data);
        } catch (\Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }

    public function query(Request $request)
    {
        try {
            $res = $request->all();
            $userModel = $this->user->selectUser($res);
            $couponModel = $this->coupon->selectCoupon($res);
            return response()->json($userModel,$couponModel);
        } catch (\Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }

    // 发放优惠券
    public function receive(Request $request)
    {
        try {
            $res = $request->all();
            $data = $this->grant->receiveCoupon($res);
            return $data;
        } catch (\Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }

    // 模拟使用优惠券
    public function useCoupon(Request $request)
    {
        try {
            // 此处传入3个id  coupon_id，user_id，order_id
            $res = $request->all();
            $coupon_info = $this->coupon->selectCoupon($res);
            $user_info = $this->user->selectUser($res);
            $order_info = $this->order->selectOrder($res);
            // 校验订单以及优惠券
            $verify = $this->use->verifyCoupon($coupon_info,$user_info,$order_info);
            if ($verify == true) {
            $res = [
                'money' => $order_info->money,
                'final_money' => $order_info->money - $coupon_info->money
            ];
            $data = $this->order->orderUpdate($res);
            }
            return $data->final_money;
        } catch (\Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }
}
