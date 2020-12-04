<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;

class UserOrderController extends Controller
{
    protected $order;
    public function __construct(OrderService $order)
    {
        $this->order = $order;
    }

    public function order(Request $request)
    {
        try {
            $res = $request->all();
            $data = $this->order->order_first_or_create($res);
            return response()->json($data);
        } catch (\Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }


}
